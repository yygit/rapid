<?php
Yii::import('application.vendors.comicvine.*');
require_once(realpath(dirname(__FILE__) . '/../vendors/comicvine/comicvine.php'));

class CvController extends Controller{

    public $layout = '//layouts/column2';

    public static function newCv() {
        //Replace this with your API key
        return new CbdbComicVine('ce7a59c578eccffe907937640e7e9b683fc23c48', 'http://www.comicvine.com/api/');
    }

    private function errorHandler($result, $view) {
        if ($result['error']) {
            $this->render($view, array('error' => $result['content']->error));
            return true;
        }
        return false;
    }

    public function actionIndex() {
        $model = new CvSearchForm();
        $model->searchString = 'spiderman';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $postData = Yii::app()->request->getPost('CvSearchForm');
        $getData = $this->getGetdata();
        $data = ($postData) ? $postData : $getData;
        if ($data) {
            $model->attributes = $data;
            if ($model->validate()) {
                $cv = $this->newCv();
                $baseLimit = 15;
                $offset = (int)Yii::app()->request->getParam('offset', 0); // 20140129 obsolete for search?
                $page = ceil($offset / $baseLimit + 1);
                $limit = ($page <= 1) ? $baseLimit + 1 : $baseLimit;
                $searchString = $model->searchString;
                if ($model->gridview) {
                    $this->redirect(array('search', 'searchString' => $searchString));
                }
                $result = $cv->volumeSearch($searchString, array(), $offset, $limit, $page);
                $this->render('search', array('result' => $result, 'searchString' => $searchString, 'offset' => $offset));
            } else
                $this->render('index', array('model' => $model));
        } else
            $this->render('index', array('model' => $model));
    }

    /**
     * uses CArrayDataProvider to search for Comic Vine volumes and CGridView widget to display those
     * $rawData should be an array type
     * array(
     *      array('id'=>1,'username'=>'user1'),
     *      array('id'=>2,'username'=>'user2'),
     *      array('id'=>3,'username'=>'user3'),
     * );
     */
    public function actionSearch() {
        $cv = $this->newCv();
        $number_of_total_results = 0;
        $page = (int)Yii::app()->request->getParam('page', 1);
        $baseLimit = 20;
        $offset = ($page - 1) * $baseLimit; // 20140129 obsolete for search?
        $limit = ($page <= 1) ? $baseLimit + 1 : $baseLimit;
        $searchString = Yii::app()->request->getParam('searchString', 'spiderman');
        $result = $cv->volumeSearch($searchString, array(), $offset, $limit, $page);

        $rawData = array();
        $arr = array();
        $id_arr = array();
        if (isset($result['content'])) {
            $number_of_total_results = isset($result['content']->number_of_total_results) ? $result['content']->number_of_total_results : 0;
            if (isset($result['content']->results)) {
                foreach ($result['content']->results as $k => $rec) {
                    $arr['id'] = $id_arr[] = $k + $offset + 1;
                    $arr['name'] = $rec->name;
                    $arr['volume_id'] = $rec->id;
                    $arr['url'] = $rec->site_detail_url;
                    $rawData[] = $arr;
                }
            }
        }
        $dataProvider = new CArrayDataProvider($rawData, array(
            'sort' => array(
                'attributes' => array( //                    'id', 'name', 'url',
                ),
            ),
            'pagination' => array(
                'pageSize' => $limit,
            ),
            'totalItemCount' => $number_of_total_results
        ));
        $this->render('grid_volume', array(
            'dataProvider' => $dataProvider,
            'result' => $result,
            'page' => $page,
            'id_arr' => $id_arr,
            'searchString' => $searchString,
        ));
    }

    public function actionIssues() {
        $cv = $this->newCv();
        $title = '';
        if (isset($_GET['title'])) {
            $title = CHtml::encode($_GET['title']);
        }
        if (!empty($_GET['volume_id'])) {
            $volumeId = (int)$_GET['volume_id'];
            if (!empty($_GET['issue_url'])) {
                $this->redirect($_GET['issue_url']);
            }
            $result = $cv->issuesForVolume($volumeId);
            if (!$this->errorHandler($result, 'issues')) {
                $issues = $result['content']->results;
                usort($issues, array('CvController', 'sortIssues'));
                if (Yii::app()->request->getQuery('grid')) {
                    $dataProvider = new CArrayDataProvider($issues, array(
                        'sort' => array(
                            'attributes' => array(
                                'issue_number', 'name'
                            ),
                        ),
                        'pagination' => array(
                            'pageSize' => 20,
                        ),
                    ));
                    $this->render('grid_issues', array(
                        'dataProvider' => $dataProvider,
                        'volumeId' => $volumeId,
                        'volumeName' => reset($issues)->volume->name,
                    ));
                } else {
                    $this->render('issues', array(
                        'result' => $issues,
                        'title' => $title,
                    ));
                }
            }
        } else {
            $this->render('issues', array('error' => 'No volume id or issue url specified', 'result' => null));
        }
    }

    static function sortIssues($a, $b) {
        $l = $a->issue_number;
        $r = $b->issue_number;
        if ($l == $r) {
            return 0;
        }
        return ($l > $r) ? +1 : -1;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comicvine-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * collect search related data
     * @return array|null
     */
    private function getGetdata() {
        if (Yii::app()->request->getQuery('search')) {
            return array(
                'offset' => $_GET['offset'],
                'searchString' => $_GET['q'],
            );
        }
        return null;
    }
}


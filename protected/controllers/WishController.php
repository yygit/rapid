<?php

class WishController extends BController{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
//    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
//            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
            'ajaxOnly + claim', // only ajax requests
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'claim'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'delete', 'removeAuthor', 'createAuthor'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Wish;
        $this->create($model);
    }


    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Wish');
        $dataProvider->criteria = array(
            'scopes' => array('gotIt'), // YY; 20140109
        );
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Wish('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Wish']))
            $model->attributes = $_GET['Wish'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Wish the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Wish::model()->gotIt()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Wish $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'wish-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * record wish/author association
     * @param $model
     * @param $author
     */
    protected function saveAssociation($model, $author) {
        $wa = new WishAuthor;
        $wa->wish_id = $model->id;
        $wa->author_id = $author->id;
        $wa->save();
    }

    /**
     * processing ajax requests from \js\wish_list_ajax.js
     * @param $id
     */
    public function actionClaim($id) {
        $model = $this->loadModel($id);
        $status = 'indefinite';
        // if the wish was claimed by the user, toggle it off
        if ($model->got_it == Yii::app()->user->getId()) {
            $model->got_it = new CDbExpression('NULL');
            $status = 'disclaimed';
        }
        // if the wish was claimed by no one, toggle it on
        if ($model->got_it == null) {
            $model->got_it = Yii::app()->user->getId();
            $status = 'claimed';
        }
        if ($model->save()) {
            echo $status;
        } else
            echo 'cannot save';
    }


}

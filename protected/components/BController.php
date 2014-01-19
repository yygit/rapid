<?php
/* 
 * BController is a customized controller base class 
 * extended from Controller
 * to provide shared author functions 
 * for controllers of objects that are joined to authors
 */
class BController extends Controller{
    /**
     * create author by ajax request when pressing 'add' button at Book form
     * @param $id
     * @throws CHttpException
     */
    public function actionCreateAuthor($id) {
        // request must be made via ajax
        if (isset($_GET['ajax']) && isset($_GET['Person'])) {
            $model = $this->loadModel($id);
            $author = Person::model()->findByAttributes(array('fname' => $_GET['Person']['fname'], 'lname' => $_GET['Person']['lname']));
            if (empty($author)){
                $author = new Person();
                $author->attributes = $_GET['Person'];
            }
            if (($author->fname != null) && ($author->lname != null)) {
                if($model->addAuthor($author)){
                    Yii::app()->user->setFlash('authorAdded', "Added author " . CHtml::encode($author->fname . " " . $author->lname));
                    /*$this->renderPartial('_li', array(
                        'model' => $model,
                        'author' => $author,
                    ), false, true);*/
                }
            }
        } else {
            throw new CHttpException(400, 'Invalid request.');
        }
    }

    /**
     * create author when pressing 'save' button at Book form
     * @param $model Wish|Book
     * @return Person
     */
    protected function createAuthor($model) {
        $author = new Person();
        if (isset($_POST['Person'])) {
            $person = Person::model()->findByAttributes(array('fname' => $_POST['Person']['fname'], 'lname' => $_POST['Person']['lname']));
            if (empty($person)) {
                $author->attributes = $_POST['Person'];
            } else $author = $person;
            if ($model->addAuthor($author)) {
                Yii::app()->user->setFlash('authorAdded', "Added author " . CHtml::encode($author->fname . " " . $author->lname));
                $this->refresh();
            }
        }
        return $author;
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionRemoveAuthor($id) {
        // request must be made via ajax
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            if ($model->removeAuthor($_GET['author_id'])) {
                Yii::app()->user->setFlash('authorRemoved', "Removed author " . $_GET['author_id']);
            }
        } else {
            throw new CHttpException(400, 'Invalid request.');
        }
    }

    /**
     * Takes the object model, creates an author
     * if form values are present, saves and redirects to view
     * otherwise, renders create view
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function create($model) {
        $author = $this->createAuthor($model);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // get object name from model
        // $objName = ucfirst($model->tableName());
        $objName = get_class($model);

        if (isset($_POST[$objName])) {
            $model->attributes = $_POST[$objName];
            if ($model->save()) {
                $this->saveAssociation($model, $author);

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'author' => $author,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $author = $this->createAuthor($model);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // get object name from model
        // $objName = ucfirst($model->tableName());
        $objName = get_class($model);

        if (isset($_POST[$objName])) {
            $model->attributes = $_POST[$objName];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'author' => $author,
        ));
    }



}

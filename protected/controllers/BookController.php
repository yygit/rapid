<?php

class BookController extends Controller{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'removeAuthor', 'createAuthor'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'),
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
        $model = new Book;
        $model->bagged = 1;
//        $model->signed = 1;

        $author = $this->createAuthor($model);

        // Uncomment the following line if AJAX validation is needed
         $this->performAjaxValidation($model);

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];
            if ($model->save()) {
                // record book/author association
                $ba = new BookAuthor;
                $ba->book_id = $model->id;
                $ba->author_id = $author->id;
                $ba->save();

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
         $this->performAjaxValidation($model);

        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'author' => $author,
        ));
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
        $dataProvider = new CActiveDataProvider('Book');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Book('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Book']))
            $model->attributes = $_GET['Book'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Book the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
//        $model = Book::model()->findByPk($id);
        $model = Book::model()->with('authors')->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Book $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'book-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * create author when pressing 'save' button at Book form
     * @param $book Book
     * @return Person
     */
    protected function createAuthor($book) {
        $author = new Person();
        if(isset($_POST['Person'])) {
            $author->attributes=$_POST['Person'];
            if ($book->addAuthor($author)) {
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
     * create author by ajax request when pressing 'add' button at Book form
     * @param $id
     * @throws CHttpException
     */
    public function actionCreateAuthor($id) {
        // request must be made via ajax
        if (isset($_GET['ajax']) && isset($_GET['Person'])) {
            $model = $this->loadModel($id);
            $author = new Person();
            $author->attributes = $_GET['Person'];
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
}

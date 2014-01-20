<?php
class LibraryController extends Controller{

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' action
                'actions' => array('index', 'request', 'lend', 'return'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Display library
     */
    public function actionIndex() {
        $criteria = new CDbCriteria;
        $criteria->compare('lendable', 1);
        $criteria->with = array('type');

        $sort = new CSort;
        $sort->defaultOrder = array('id' => CSort::SORT_ASC);
        $sort->attributes = array(
            'type' => array(
                'asc' => 'type.name',
                'desc' => 'type.name DESC',
            ),
            '*',
        );

        $dataProvider = new CActiveDataProvider('Book', array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * accept request for book lending
     * @param $id
     */
    public function actionRequest($id) {
        $request = new Request();
        $request->book_id = $id;
        $request->requester_id = Yii::app()->user->getId();
        try {
            $request->save();
        } catch (CDbException $e) {
            if ($e) {
                Yii::app()->user->setFlash('error', "Your book request cannot be submitted: " . print_r($e->errorInfo[2], true));
                $this->redirect(array('index'));
            }
        }
        Yii::app()->user->setFlash('success', "Your request for book #" . $id . " has been submitted.");
        $this->redirect(array('index'));
    }

    /**
     * lend a book
     * @param $book_id
     * @param $user_id
     * @throws CHttpException
     */
    public function actionLend($book_id, $user_id) {
        $model = Book::model()->findByPk($book_id);
        if ($model === null)
            throw new CHttpException(404, 'The requested book does not exist.');
        $request = Request::model()->find('book_id=:book_id AND requester_id=:user_id',
            array(
                ':book_id' => $book_id,
                ':user_id' => $user_id,
            ));
        if ($request === null)
            throw new CHttpException(404, 'The request does not exist.');
        $request->delete();
        $model->borrower_id = $user_id;
        $model->save();
        $this->redirect(array('book/index'));
    }

    /**
     * return a book (dis-lend it)
     * @param $book_id
     * @param $user_id
     * @throws CHttpException
     */
    public function actionReturn($book_id, $user_id) {
        $model = Book::model()->findByPk($book_id);
        if ($model === null)
            throw new CHttpException(404, 'The requested book does not exist.');
        $model->borrower_id = null;
        $model->save();
        $this->redirect(array('book/index'));
    }


}

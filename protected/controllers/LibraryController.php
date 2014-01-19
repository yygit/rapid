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
                'actions' => array('index'),
                'users' => array('*'),
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
        $dataProvider = new CActiveDataProvider('Book', array(
            'criteria' => $criteria,
        ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
}

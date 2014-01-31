<?php

/**
 * CvSearchForm class.
 */
class CvSearchForm extends CFormModel{
    public $searchString;
    public $offset;
    public $gridview;

    public function rules() {
        return array(
            array('offset', 'default', 'value' => 0, 'setOnEmpty' => true), // does not work if 'enableClientValidation' => true in CActiveForm
            array('searchString, offset', 'required'),
            array('searchString, offset', 'filter', 'filter' => 'trim'),
            array('searchString', 'filter', 'filter' => 'CHtml::encode'),
            array('offset', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('gridview', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'searchString' => 'Search String',
            'offset' => 'Offset',
            'gridview' => 'Grid View',
        );
    }

}

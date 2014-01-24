<?php

/**
 * This is the model class for table "request".
 *
 * The followings are the available columns in table 'request':
 * @property string $book_id
 * @property string $requester_id
 */
class Request extends MyActiveRecord {
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'request';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that will receive user inputs.
        return array(
            array('book_id, requester_id', 'required'),
            array('book_id, requester_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // array('book_id, requester_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'book_id' => 'Book',
            'requester_id' => 'Requester',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('book_id', $this->book_id, true);
        $criteria->compare('requester_id', $this->requester_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Request the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}

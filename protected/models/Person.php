<?php

/**
 * This is the model class for table "person".
 *
 * The followings are the available columns in table 'person':
 * @property string $id
 * @property string $fname
 * @property string $lname
 *
 * The followings are the available model relations:
 * @property Book[] $books model relation
 * @property Book[] $bookauthors model relation
 * @property Book[] $bookillustrators model relation
 * @property Book[] $books1 model relation
 *
 * @method Person find
 */
class Person extends MyActiveRecord{
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'person';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fname, lname', 'required'),
            array('fname, lname', 'length', 'max' => 64),
            array('fname, lname', 'filter', 'filter' => 'trim'),
            array('fname, lname', 'filter', 'filter' => 'CHtml::encode'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, fname, lname', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'books' => array(self::MANY_MANY, 'Book', 'bookauthor(author_id, book_id)', 'index' => 'id'), // books of this person as an author
            'bookauthors' => array(self::HAS_MANY, 'Bookauthor', 'author_id'),
            'bookillustrators' => array(self::HAS_MANY, 'Bookillustrator', 'illustrator_id'),
            'books1' => array(self::MANY_MANY, 'Book', 'bookillustrator(illustrator_id, book_id)'), // books of this person as an illustrator
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'fname' => 'First Name',
            'lname' => 'Last Name',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('fname', $this->fname, true);
        $criteria->compare('lname', $this->lname, true);

        $sort = new CSort;
        $sort->defaultOrder = array('id' => CSort::SORT_ASC);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Person the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}

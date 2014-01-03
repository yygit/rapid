<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $pwd_hash
 * @property string $person_id
 *
 * The followings are the available model relations:
 * @property Person $person
 */
class User extends CActiveRecord{

    public $password;
    public $password_repeat;
    public $person_fname;
    public $person_lname;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username', 'required'),
            array('username', 'length', 'max'=>20),
            array('password', 'length', 'max'=>32),
            array('password', 'compare'),
            array('password_repeat', 'safe'),
            array('id, username, person_fname, person_lname', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'password_repeat' => 'Password Repeat',
            'person_fname' => Person::model()->getAttributeLabel("fname"),
            'person_lname' => Person::model()->getAttributeLabel("lname"),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare('person.fname', $this->person_fname, true);
        $criteria->compare('person.lname', $this->person_lname, true);
        $criteria->with = array('person');

        $sort = new CSort;
        $sort->defaultOrder = array('id' => CSort::SORT_ASC);
        $sort->attributes = array(
            'person_fname' => array(
                'asc' => 'person.fname',
                'desc' => 'person.fname DESC',
            ),
            'person_lname' => array(
                'asc' => 'person.lname',
                'desc' => 'person.lname DESC',
            ),
            '*',
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}

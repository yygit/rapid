<?php

/**
 * This is the model class for table "hangman".
 *
 * The followings are the available columns in table 'hangman':
 * @property string $id
 * @property string $title
 * @property string $guessed
 * @property integer $fails
 * @property string $token
 */
class Hangman extends CActiveRecord{

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hangman';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, token', 'required'),
            array('fails', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 80),
            array('guessed', 'length', 'max' => 26),
            array('token', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, guessed, fails, token', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'title' => 'Title',
            'guessed' => 'Guessed',
            'fails' => 'Fails',
            'token' => 'Token',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('guessed', $this->guessed, true);
        $criteria->compare('fails', $this->fails);
        $criteria->compare('token', $this->token, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Hangman the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function init() {
        parent::init();
        $this->attachEventHandler('onAfterFind', array($this, 'titleAndGuessedToUpper'));
    }

    protected function titleAndGuessedToUpper() {
        if (!empty($this->guessed))
            $this->guessed = strtoupper($this->guessed);
        if (!empty($this->title))
            $this->title = strtoupper($this->title);
        return true;
    }

}

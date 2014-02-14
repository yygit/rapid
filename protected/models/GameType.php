<?php

/**
 * This is the model class for table "game_type".
 *
 * The followings are the available columns in table 'game_type':
 * @property string $id
 * @property string $devname
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Game[] $games
 */
class GameType extends MyActiveRecord{
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'game_type';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('devname', 'length', 'max' => 20),
            array('name', 'length', 'max' => 40),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, devname, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'games' => array(self::HAS_MANY, 'Game', 'game_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'devname' => 'Devname',
            'name' => 'Name',
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
        $criteria->compare('devname', $this->devname, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GameType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @param $gameName
     * @return int
     * @throws CDbException
     */
    public static function getTypeId($gameName) {
        $model = self::model()->findByAttributes(array('devname' => $gameName));
        if (empty ($model))
            throw new CDbException('cannot find model for game named ' . $gameName);
        return $model->id;
    }
}

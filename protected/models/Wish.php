<?php

/**
 * This is the model class for table "wish".
 *
 * The followings are the available columns in table 'wish':
 * @property string $id
 * @property string $title
 * @property string $issue_number
 * @property string $type_id
 * @property string $publication_date
 * @property string $store_link
 * @property string $notes
 * @property string $got_it
 *
 * The followings are the available model relations:
 * @property Type $type
 * @property User $gotIt
 * @property Person[] $people
 * @property Publisher[] $publishers
 */
class Wish extends CActiveRecord{
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'wish';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, type', 'required'),
            array('title', 'length', 'max' => 256),
            array('issue_number, type_id, got_it', 'length', 'max' => 10),
            array('store_link', 'length', 'max' => 255),
            array('publication_date, notes', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, issue_number, type_id, publication_date, store_link, notes, got_it', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'type' => array(self::BELONGS_TO, 'Type', 'type_id'),
            'gotIt' => array(self::BELONGS_TO, 'User', 'got_it'),
            'illustrators' => array(self::MANY_MANY, 'Person', 'wishillustrator(wish_id, illustrator_id)'),
            'authors' => array(self::MANY_MANY, 'Person', 'wishauthor(wish_id, author_id)', 'index' => 'id'),
            'wishauthors' => array(self::HAS_MANY, 'WishAuthor', 'wish_id', 'index' => 'author_id'),
            'publishers' => array(self::MANY_MANY, 'Publisher', 'wishpublisher(wish_id, publisher_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'issue_number' => 'Issue Number',
            'type_id' => 'Type',
            'publication_date' => 'Publication Date',
            'store_link' => 'Store Link',
            'notes' => 'Notes',
            'got_it' => 'Got It',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('issue_number', $this->issue_number, true);
        $criteria->compare('type_id', $this->type_id, true);
        $criteria->compare('publication_date', $this->publication_date, true);
        $criteria->compare('store_link', $this->store_link, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('got_it', $this->got_it, true);

        $criteria->scopes = array('gotIt'); // YY; 20140109

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Wish the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * assign this author to this wish
     */
    public function addAuthor($author) {
        $wishauthor = new WishAuthor();
//        $author->save();
        try {
            $author->save();
        } catch (CDbException $e) {
            if ($e) {
                Yii::app()->user->setFlash('authorAddedNotice', "Notice: " . $e->getMessage());
            }
        }
        $wishauthor->wish_id = $this->id;
        $wishauthor->author_id = $author->id;
        return $wishauthor->save();
    }

    /**
     * remove an author association from wish
     */
    public function removeAuthor($author_id) {
        $pk = array('wish_id' => $this->id, 'author_id' => $author_id);
        WishAuthor::model()->deleteByPk($pk);
    }

    /**
     * @return array
     */
    /*public function scopes() {
        $user = Yii::app()->user;
        if (empty($user->id) OR empty($user->name) OR $user->name === Yii::app()->params['God'])
            return array(
                'gotIt' => array(),
            );

        return array(
            'gotIt' => array(
                'condition' => "got_it is NULL OR " . "got_it='" . Yii::app()->user->id . "'",
            ),
        );
    }*/
    /**
     * scope to filter out users who picked up the wish
     * @return $this
     */
    public function gotIt() {
        $user = Yii::app()->user;
        if (!empty($user->id) && !empty($user->name) && $user->name !== Yii::app()->params['God']) {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => "got_it is NULL OR " . "got_it='" . Yii::app()->user->id . "'",
            ));
        }
        return $this;
    }
}

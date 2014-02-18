<?php

/**
 * This is the model class for table "game".
 *
 * The followings are the available columns in table 'game':
 * @property string $id
 * @property string $target
 * @property string $guessed
 * @property string $book_id
 * @property string $author_id
 * @property string $book_decoy1_id
 * @property string $book_decoy2_id
 * @property string $book_decoy3_id
 * @property integer $fails
 * @property string $token
 * @property string $game_type_id
 * @property integer $win
 *
 * The followings are the available model relations:
 * @property GameType $gameType
 * @property Book $book
 * @property Person $author
 * @property Book $bookDecoy1
 * @property Book $bookDecoy2
 * @property Book $bookDecoy3
 */
class Game extends MyActiveRecord{
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'game';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('token, game_type_id', 'required'),
            array('fails, win', 'numerical', 'integerOnly' => true),
            array('target', 'length', 'max' => 80),
            array('guessed', 'length', 'max' => 26),
            array('book_id, author_id, book_decoy1_id, book_decoy2_id, book_decoy3_id, game_type_id', 'length', 'max' => 10),
            array('token', 'length', 'max' => 64),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, target, guessed, book_id, author_id, book_decoy1_id, book_decoy2_id, book_decoy3_id, fails, token, game_type_id, win', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'gameType' => array(self::BELONGS_TO, 'GameType', 'game_type_id'),
            'book' => array(self::BELONGS_TO, 'Book', 'book_id'),
            'author' => array(self::BELONGS_TO, 'Person', 'author_id'),
            'bookDecoy1' => array(self::BELONGS_TO, 'Book', 'book_decoy1_id'),
            'bookDecoy2' => array(self::BELONGS_TO, 'Book', 'book_decoy2_id'),
            'bookDecoy3' => array(self::BELONGS_TO, 'Book', 'book_decoy3_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'target' => 'Target',
            'guessed' => 'Guessed',
            'book_id' => 'Book',
            'author_id' => 'Author',
            'book_decoy1_id' => 'Book Decoy1',
            'book_decoy2_id' => 'Book Decoy2',
            'book_decoy3_id' => 'Book Decoy3',
            'fails' => 'Fails',
            'token' => 'Token',
            'game_type_id' => 'Game Type',
            'win' => 'Win',
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
        $criteria->compare('target', $this->target, true);
        $criteria->compare('guessed', $this->guessed, true);
        $criteria->compare('book_id', $this->book_id, true);
        $criteria->compare('author_id', $this->author_id, true);
        $criteria->compare('book_decoy1_id', $this->book_decoy1_id, true);
        $criteria->compare('book_decoy2_id', $this->book_decoy2_id, true);
        $criteria->compare('book_decoy3_id', $this->book_decoy3_id, true);
        $criteria->compare('fails', $this->fails);
        $criteria->compare('token', $this->token, true);
        $criteria->compare('game_type_id', $this->game_type_id, true);
        $criteria->compare('win', $this->win);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Game the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function init() {
        parent::init();
        $this->attachEventHandler('onAfterFind', array($this, 'targetAndGuessedToUpper'));
    }

    protected function targetAndGuessedToUpper() {
        if (!empty($this->guessed))
            $this->guessed = strtoupper($this->guessed);
        if (!empty($this->target))
            $this->target = strtoupper($this->target);
        return true;
    }

    /**
     * get Controller ID of the game ie 'hangman', 'wroteit', etc
     * @param TokenForm $model
     * @return string
     * @throws CDbException
     */
    public static function getControllerId(TokenForm $model) {
        /** @var $game Game */
        $game = self::model()->with('gameType')->findByAttributes(array('token' => $model->token));
        if (empty ($game))
            throw new CDbException('no game found with this token');
        return strtolower($game->gameType->devname);
    }
}

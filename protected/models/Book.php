<?php

/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property string $id
 * @property string $title
 * @property string $type_id
 * @property string $publication_date
 * @property string $value
 * @property string $price
 * @property string $notes
 * @property integer $signed
 * @property string $grade_id
 * @property integer $bagged
 * @property string $issue_number
 * @property string $borrower_id // YY; 20140113
 * @property integer $lendable   // YY; 20140113
 * @property User $borrower      // YY; 20140113
 *
 * The followings are the available model relations:
 * @property Type $type
 * @property Grade $grade
 * @property Person[] $people
 * @property Publisher[] $publishers
 * @property Tag[] $tags
 */
class Book extends MyActiveRecord{

    public $borrower_fullname = '';
    public $borrower_fname;
    public $borrower_lname;
    public $num_grade;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'book';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, type_id, grade_id', 'required'),
            array('signed, bagged, type_id, grade_id, lendable', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 256),
            array('issue_number, type_id, value, price, grade_id, borrower_id', 'length', 'max' => 10),
            array('publication_date, notes', 'safe'),
            array('borrower_id', 'default', 'value' => null, 'setOnEmpty' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, type_id, publication_date, value, price, notes, signed, grade_id, bagged, issue_number, lendable, borrower_fname, borrower_lname', 'safe', 'on' => 'search'),
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
            'grade' => array(self::BELONGS_TO, 'Grade', 'grade_id'),
//            'publisher' => array(self::BELONGS_TO, 'Publisher', 'publisher_id'),
            'illustrators' => array(self::MANY_MANY, 'Person', 'bookillustrator(book_id, illustrator_id)'),
            'bookillustrators' => array(self::HAS_MANY, 'BookIllustrator', 'book_id', 'index' => 'illustrator_id'),
            'authors' => array(self::MANY_MANY, 'Person', 'bookauthor(book_id, author_id)', 'index' => 'id'),
            'bookauthors' => array(self::HAS_MANY, 'BookAuthor', 'book_id', 'index' => 'author_id'),
            'publishers' => array(self::MANY_MANY, 'Publisher', 'bookpublisher(book_id, publisher_id)'),
            'tags' => array(self::MANY_MANY, 'Tag', 'booktag(book_id, tag_id)'),
            'booktags' => array(self::HAS_MANY, 'BookTag', 'book_id'),
            'borrower' => array(self::BELONGS_TO, 'User', 'borrower_id'),
            'requesters' => array(self::MANY_MANY, 'User', 'request(requester_id, book_id)', 'index' => 'id'),
            'requests' => array(self::HAS_MANY, 'Request', 'book_id', 'index' => 'requester_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'type_id' => 'Type',
            'publication_date' => 'Publication Date',
            'value' => 'Value',
            'price' => 'Price',
            'notes' => 'Notes',
            'signed' => 'Signed',
            'grade_id' => 'Grade',
            'bagged' => 'Bagged',
            'issue_number' => 'Issue Number',
            'author' => 'Book Author',
            'borrower_id' => 'Borrower',
            'lendable' => 'Lendable',
            'borrower_fname' => 'Borrower First Name',
            'borrower_lname' => 'Borrower Last Name',
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

        $criteria->compare('t.id', $this->id, false);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('type_id', $this->type_id, true);
        $criteria->compare('publication_date', $this->publication_date, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('signed', $this->signed);
        $criteria->compare('grade_id', $this->grade_id, true);
        $criteria->compare('bagged', $this->bagged);
        $criteria->compare('issue_number', $this->issue_number, true);
        $criteria->compare('lendable', ($this->lendable == "yes" ? 1 : ($this->lendable == "no" ? 0 : "")), true);
        $criteria->compare('person.fname', $this->borrower_fname, true);
        $criteria->compare('person.lname', $this->borrower_lname, true);
        $criteria->with = array('borrower.person');

        $sort = new CSort;
        $sort->defaultOrder = array('id' => CSort::SORT_ASC);
        $sort->attributes = array(
            'borrower_fname' => array(
                'asc' => 'person.fname',
                'desc' => 'person.fname DESC',
            ),
            'borrower_lname' => array(
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
     * @return Book the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @param $author Person
     */
    public function addAuthor($author) {
        if ($author->isNewRecord) {
            $author->save();
            $bookauthor = new BookAuthor();
            $bookauthor->book_id = $this->id;
            $bookauthor->author_id = $author->id;
            return $bookauthor->save();
        }
        return false;
    }

    /**
     * @param $author_id string
     */
    public function removeAuthor($author_id) {
        $pk = array('book_id' => $this->id, 'author_id' => $author_id);
        return BookAuthor::model()->deleteByPk($pk);
    }

    /**
     * @param $data
     * @param $row
     * @return string
     */
    public function author_list($data, $row) {
        $list = array();
//        $count = 1;
        foreach ($data->authors as $a) {
            $list[] = $a->fname . ' ' . $a->lname;
//            $count++;
        }
        return implode(", ", $list);
    }

    /**
     * @param $data
     * @param $row
     * @return string
     */
    public function publisher_list($data, $row) {
        $list = array();
        foreach ($data->publishers as $a) {
            $list[] = $a->name;
        }
        return implode(", ", $list);
    }

    public function get_status($data, $row) {
        $status = "Available";
        if ($data->borrower_id != null) {
            $status = "Checked Out";
        }
        if ($data->borrower_id == Yii::app()->user->getId()) {
            $status = "You Have It";
        }
        return $status;
    }

    public function requested($row, $data) {
        $me = Yii::app()->user->getId();
        foreach ($data->requesters as $r) {
            if ($r->id == $me) {
                return false;
            }
        }
        if ($data->borrower_id == $me) {
            return false;
        }
        return true;
    }

}

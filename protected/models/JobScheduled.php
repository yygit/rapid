<?php

/**
 * This is the model class for table "job_scheduled".
 *
 * The followings are the available columns in table 'job_scheduled':
 * @property string $id
 * @property string $params
 * @property string $output
 * @property string $job_id
 * @property string $scheduled_time
 * @property string $started
 * @property string $completed
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Job $job model relation
 *
 * model scopes
 * @method JobScheduled active() model scope
 * @method JobScheduled current() model scope
 */
class JobScheduled extends MyActiveRecord{

    public $job_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'job_scheduled';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('job_id', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('job_id', 'length', 'max' => 10),
            array('params, output, scheduled_time, started, completed', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, params, output, job_id, scheduled_time, started, completed, active', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
//            'job' => array(self::BELONGS_TO, 'Job', 'job_id'),
            'job' => array(self::BELONGS_TO, 'Job', array('job_id' => 'id')),
        );
    }

    public function scopes() {
        return array(
            'active' => array(
                'condition' => 'active=1 AND completed IS NULL',
            ),
            'current' => array(
                'condition' => 'scheduled_time < now()',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'params' => 'Params',
            'output' => 'Output',
            'job_id' => 'Job ID',
            'job_name' => 'Job',
            'scheduled_time' => 'Scheduled Time',
            'started' => 'Started',
            'completed' => 'Completed',
            'active' => 'Active',
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
        $criteria->compare('params', $this->params, true);
        $criteria->compare('output', $this->output, true);
        $criteria->compare('job_id', $this->job_id, true);
        $criteria->compare('scheduled_time', $this->scheduled_time, true);
        $criteria->compare('started', $this->started, true);
        $criteria->compare('completed', $this->completed, true);
        $criteria->compare('active', $this->active);

//        $criteria->scopes = array('active', 'current');

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
     * @return JobScheduled the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}

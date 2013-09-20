<?php

/**
 * This is the model class for table "projectemp".
 *
 * The followings are the available columns in table 'projectemp':
 * @property string $projectempid
 * @property string $projectid
 *
 * The followings are the available model relations:
 * @property Project $project
 */
class Projectemp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Projectemp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'projectemp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projectid,employeeid,workdate,workdateend', 'required'),
			array('projectid,employeeid,requestforid', 'numerical'),
			array('workdateend,workdateend,realdate,description', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('projectempid, projectid, employeeid,workdate,workdateend', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'project' => array(self::BELONGS_TO, 'Project', 'projectid'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
			'requestfor' => array(self::BELONGS_TO, 'Requestfor', 'requestforid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'projectempid' => 'ID',
			'projectid' => 'Header',
            'employeeid' => 'Employee',
            'workdate' => 'Start Date',
            'workdateend'=>'Target Date',
			'requestforid'=>'Request For',
			'realdate'=>'Realization Date',
			'description'=>'Information',
			'uploaddate'=>'Upload Document Date',
			'spkno'=>'WOI No'
		);
	}
	
		public function beforeSave()
    {
      $this->workdate = date(Yii::app()->params['datetodb'], strtotime($this->workdate));
      $this->workdateend = date(Yii::app()->params['datetodb'], strtotime($this->workdateend));
      return parent::beforeSave();
    }


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('project','employee','requestfor');
		if (isset($_GET['Projectemp'])) {
			$criteria->condition='t.projectid='.$_GET['Projectemp']['projectid'];
		} else {
			$criteria->condition='t.projectid=0';
		}
		$criteria->compare('projectempid',$this->projectempid,true);
		$criteria->compare('t.projectid',$this->projectid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('workdate',$this->workdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
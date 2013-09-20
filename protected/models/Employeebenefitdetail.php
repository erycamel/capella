<?php

/**
 * This is the model class for table "employeebenefitdetail".
 *
 * The followings are the available columns in table 'employeebenefitdetail':
 * @property string $employeebenefitdetailid
 * @property string $wagetypeid
 * @property string $startdate
 * @property string $enddate
 * @property string $amount
 * @property string $reason
 * @property string $employeebenefitid
 */
class Employeebenefitdetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeebenefitdetail the static model class
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
		return 'employeebenefitdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wagetypeid, employeebenefitid,isfinal', 'length', 'max'=>10),
			array('reason,amount', 'length', 'max'=>50),
			array('startdate, enddate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeebenefitdetailid, wagetypeid, startdate, enddate, reason, employeebenefitid,amount', 'safe', 'on'=>'search'),
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
			'wagetype' => array(self::BELONGS_TO, 'Wagetype', 'wagetypeid'),
      'employeebenefit' => array(self::BELONGS_TO, 'Employeebenefit', 'employeebenefitid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeebenefitdetailid' => 'ID',
			'wagetypeid' => 'Wage Type',
			'startdate' => 'Start Date',
			'enddate' => 'End Date',
			'reason' => 'Reason',
			'employeebenefitid' => 'Employee',
            'amount'=>'Amount'
		);
	}

            public function beforeSave()
    {
      $this->startdate = date(Yii::app()->params['datetodb'], strtotime($this->startdate));
      $this->enddate = date(Yii::app()->params['datetodb'], strtotime($this->enddate));
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
        $criteria->with=array('wagetype');
		if (isset($_GET['Employeebenefitdetail'])) {
$model=new Employeebenefitdetail('search');
$model->attributes = $_GET['Employeebenefitdetail'];
$criteria->condition='t.employeebenefitid='.$model->employeebenefitid;
} else {
$criteria->condition='t.employeebenefitid=0';
}
		$criteria->compare('employeebenefitdetailid',$this->employeebenefitdetailid,true);
		$criteria->compare('wagetypeid',$this->wagetypeid,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('t.employeebenefitid',$this->employeebenefitid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function behaviors()
  {
    return array(
        // Classname => path to Class
        'ActiveRecordLogableBehavior'=>
            'application.behaviors.ActiveRecordLogableBehavior',
    );
  }
}
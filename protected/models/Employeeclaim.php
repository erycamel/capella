<?php

/**
 * This is the model class for table "employeeclaim".
 *
 * The followings are the available columns in table 'employeeclaim':
 * @property string $employeeclaimid
 * @property string $employeeid
 * @property string $claimenterdate
 * @property string $claimexitdate
 * @property string $claimprice
 * @property string $reason
 */
class Employeeclaim extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employeeclaim the static model class
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
		return 'employeeclaim';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, claimenterdate, claimexitdate', 'required'),
			array('employeeid', 'length', 'max'=>10),
			array('claimprice,claimappprice', 'length', 'max'=>30),
			array('reason,claimappdate', 'length', 'max'=>50),
        array('recordstatus','numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeeclaimid, employeeid, claimenterdate, claimexitdate, claimprice, claimappdate,claimappprice,reason', 'safe', 'on'=>'search'),
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
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
		);
	}

            public function beforeSave()
    {
      $this->claimenterdate = date(Yii::app()->params['datetodb'], strtotime($this->claimenterdate));
      $this->claimexitdate = date(Yii::app()->params['datetodb'], strtotime($this->claimexitdate));
      $this->claimappdate = date(Yii::app()->params['datetodb'], strtotime($this->claimappdate));
      return parent::beforeSave();
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeeclaimid' => 'ID',
			'employeeid' => 'Employee',
			'claimenterdate' => 'Claim Date By Employee',
			'claimexitdate' => 'Claim Date To Insurance',
			'claimappdate' => 'Approve Date By Insurance',
			'claimappprice' => 'Approve Claim Price By Insurance',
			'claimprice' => 'Claim Price By Employee',
			'reason' => 'Reason',
        'recordstatus'=>'Record Status'
		);
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
    $criteria->with=array('employee');
		$criteria->compare('employeeclaimid',$this->employeeclaimid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('claimenterdate',$this->claimenterdate,true);
		$criteria->compare('claimexitdate',$this->claimexitdate,true);
		$criteria->compare('claimappdate',$this->claimappdate,true);
		$criteria->compare('claimappprice',$this->claimappprice,true);
		$criteria->compare('claimprice',$this->claimprice,true);
		$criteria->compare('reason',$this->reason,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
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
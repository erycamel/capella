<?php

/**
 * This is the model class for table "employeebenefit".
 *
 * The followings are the available columns in table 'employeebenefit':
 * @property integer $employeebenefitid
 * @property integer $employeeid
 * @property string $fullname
 * @property string $newnik
 * @property string $oldnik
 * @property string $fulldivision
 * @property integer $wageid
 * @property string $wagename
 * @property string $startdate
 * @property string $enddate
 * @property string $amount
 * @property integer $currencyid
 * @property string $reason
 */
class Employeebenefit extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeebenefit the static model class
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
		return 'employeebenefit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid,currencyid ', 'numerical', 'integerOnly'=>true),
			array('ratevalue ', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeebenefitid, employeeid,currencyid', 'safe', 'on'=>'search'),
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
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeebenefitid' => 'ID',
			'employeeid' => 'Employee',
			'recordstatus' => 'Record Status',
            'currencyid'=>'Currency',
            'ratevalue'=>'Rate'
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
    $criteria->with=array('employee','currency');
		$criteria->compare('employeebenefitid',$this->employeebenefitid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('t.recordstatus',$this->recordstatus,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

    public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
    $criteria->with=array('employee','currency');
    $criteria->condition='t.recordstatus = 1';
		$criteria->compare('employeebenefitid',$this->employeebenefitid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('t.recordstatus',$this->recordstatus,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
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
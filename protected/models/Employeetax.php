<?php

/**
 * This is the model class for table "employeetax".
 *
 * The followings are the available columns in table 'employeetax':
 * @property integer $employeetaxid
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
class Employeetax extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeetax the static model class
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
		return 'employeetax';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid ', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeetaxid, employeeid,taxstartperiod,taxendperiod', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeetaxid' => 'ID',
			'employeeid' => 'Employee',
			'recordstatus' => 'Record Status',
            'taxstartperiod'=>'Start Period',
            'taxendperiod'=>'End Period'
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
		$criteria->compare('employeetaxid',$this->employeetaxid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('recordstatus',$this->recordstatus,true);
        if ($this->taxstartperiod != null)
        {
        $this->taxstartperiod = date(Yii::app()->params['datetodb'], strtotime($this->taxstartperiod));
        }
		$criteria->compare('taxstartperiod',$this->taxstartperiod,true);
        if ($this->taxendperiod != null)
        {
        $this->taxendperiod = date(Yii::app()->params['datetodb'], strtotime($this->taxendperiod));
        }

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
    $criteria->with=array('employee');
    $criteria->condition='recordstatus=1';
		$criteria->compare('employeetaxid',$this->employeetaxid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('recordstatus',$this->recordstatus,true);
        if ($this->taxstartperiod != null)
        {
        $this->taxstartperiod = date(Yii::app()->params['datetodb'], strtotime($this->taxstartperiod));
        }
		$criteria->compare('taxstartperiod',$this->taxstartperiod,true);
        if ($this->taxendperiod != null)
        {
        $this->taxendperiod = date(Yii::app()->params['datetodb'], strtotime($this->taxendperiod));
        }
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
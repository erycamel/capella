<?php

/**
 * This is the model class for table "payrollperiod".
 *
 * The followings are the available columns in table 'payrollperiod':
 * @property string $payrollperiodid
 * @property string $payrollperiodname
 * @property string $startdate
 * @property string $enddate
 * @property string $parentperiodid
 *
 * The followings are the available model relations:
 * @property Payrollperiod $parentperiodid0
 * @property Payrollperiod[] $payrollperiods
 */
class Payrollperiod extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Payrollperiod the static model class
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
		return 'payrollperiod';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payrollperiodname, startdate, enddate', 'required'),
			array('payrollperiodname', 'length', 'max'=>50),
			array('parentperiodid,recordstatus', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('payrollperiodid, payrollperiodname, startdate, enddate, parentperiodid', 'safe', 'on'=>'search'),
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
			'parentpayrollperiod' => array(self::BELONGS_TO, 'Payrollperiod', 'parentperiodid'),
			'payrollperiods' => array(self::HAS_MANY, 'Payrollperiod', 'parentperiodid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'payrollperiodid' => 'ID',
			'payrollperiodname' => 'Payroll Period',
			'startdate' => 'Start Date',
			'enddate' => 'End Date',
			'parentperiodid' => 'Previous Period',
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
        $criteria->with=array('parentpayrollperiod');
		$criteria->compare('payrollperiodid',$this->payrollperiodid,true);
		$criteria->compare('payrollperiodname',$this->payrollperiodname,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('parentpayrollperiod.payrollperiodname',$this->parentperiodid,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
	
	        public function beforeSave()
    {
      $this->startdate = date(Yii::app()->params['datetodb'], strtotime($this->startdate));
      $this->enddate = date(Yii::app()->params['datetodb'], strtotime($this->enddate));
      return parent::beforeSave();
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
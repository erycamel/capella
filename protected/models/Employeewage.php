<?php

/**
 * This is the model class for table "employeewage".
 *
 * The followings are the available columns in table 'employeewage':
 * @property integer $employeewageid
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
class Employeewage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeewage the static model class
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
		return 'employeewage';
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
			array('employeewageid, employeeid,wagestartperiod,wageendperiod', 'safe', 'on'=>'search'),
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
			'employeewageid' => 'ID',
			'employeeid' => 'Employee',
			'recordstatus' => 'Record Status',
            'wagestartperiod' => 'Start Period',
            'wageendperiod' => 'End Period',
            'wagevalue' => 'Total'
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
		$criteria->compare('employeewageid',$this->employeewageid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
        if ($this->wagestartperiod != null)
        {
        $this->wagestartperiod = date(Yii::app()->params['datetodb'], strtotime($this->wagestartperiod));
        }
		$criteria->compare('wagestartperiod',$this->wagestartperiod,true);
        if ($this->wageendperiod != null)
        {
        $this->wageendperiod = date(Yii::app()->params['datetodb'], strtotime($this->wageendperiod));
        }
		$criteria->compare('recordstatus',$this->recordstatus,true);

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
		$criteria->compare('employeewageid',$this->employeewageid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
        if ($this->wagestartperiod != null)
        {
        $this->wagestartperiod = date(Yii::app()->params['datetodb'], strtotime($this->wagestartperiod));
        }
		$criteria->compare('wagestartperiod',$this->wagestartperiod,true);
        if ($this->wageendperiod != null)
        {
        $this->wageendperiod = date(Yii::app()->params['datetodb'], strtotime($this->wageendperiod));
        }
		$criteria->compare('wageendperiod',$this->wageendperiod,true);
		$criteria->compare('recordstatus',$this->recordstatus,true);

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
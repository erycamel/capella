<?php

/**
 * This is the model class for table "employeeinformal".
 *
 * The followings are the available columns in table 'employeeinformal':
 * @property integer $employeeinformalid
 * @property integer $employeeid
 * @property string $informalname
 * @property string $organizer
 * @property integer $period
 * @property integer $isdiploma
 * @property string $sponsoredby
 * @property integer $recordstatus
 */
class Employeeinformal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeeinformal the static model class
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
		return 'employeeinformal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, informalname, recordstatus', 'required'),
			array('employeeid, isdiploma, recordstatus', 'numerical', 'integerOnly'=>true),
			array('informalname, organizer, sponsoredby,period', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeeinformalid, employeeid, informalname, organizer, period, isdiploma, sponsoredby, recordstatus', 'safe', 'on'=>'search'),
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
			'employeeinformalid' => 'ID',
			'employeeid' => 'Employee ',
			'informalname' => 'Course / Training / Skill',
			'organizer' => 'Organizer',
			'period' => 'Period',
			'isdiploma' => 'Is Certificate',
			'sponsoredby' => 'Sponsored By',
			'recordstatus' => 'Record Status',
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
$criteria->compare('employeeinformalid',$this->employeeinformalid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('informalname',$this->informalname,true);
		$criteria->compare('organizer',$this->organizer,true);
		$criteria->compare('period',$this->period);
		$criteria->compare('isdiploma',$this->isdiploma);
		$criteria->compare('sponsoredby',$this->sponsoredby,true);
		$criteria->compare('recordstatus',$this->recordstatus);
$criteria->compare('iswo','0',true);
		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

  /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
    $criteria->with=array('employee');
		$criteria->compare('employeeinformalid',$this->employeeinformalid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('informalname',$this->informalname,true);
		$criteria->compare('organizer',$this->organizer,true);
		$criteria->compare('period',$this->period);
		$criteria->compare('isdiploma',$this->isdiploma);
		$criteria->compare('sponsoredby',$this->sponsoredby,true);
$criteria->compare('iswo','0',true);
$criteria->compare('t.recordstatus','1',true);

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
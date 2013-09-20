<?php

/**
 * This is the model class for table "lockerstaff".
 *
 * The followings are the available columns in table 'lockerstaff':
 * @property integer $lockerstaffid
 * @property integer $employeeid
 * @property string $fullname
 * @property string $newnik
 * @property string $oldnik
 * @property string $fulldivision
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Lockercheck[] $lockerchecks
 * @property Lockerreturn[] $lockerreturns
 */
class Lockerstaff extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lockerstaff the static model class
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
		return 'lockerstaff';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, recordstatus', 'required'),
			array('employeeid, recordstatus', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lockerstaffid, employeeid,recordstatus', 'safe', 'on'=>'search'),
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
			'lockerchecks' => array(self::HAS_MANY, 'Lockercheck', 'lockerstaffid'),
			'lockerreturns' => array(self::HAS_MANY, 'Lockerreturn', 'lockerstaffid'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lockerstaffid' => 'ID',
			'employeeid' => 'Employee',
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
		$criteria->compare('lockerstaffid',$this->lockerstaffid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('recordstatus',$this->recordstatus);

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
    $criteria->condition='t.recordstatus=1';
    $criteria->with=array('employee');
		$criteria->compare('lockerstaffid',$this->lockerstaffid);
		$criteria->compare('employee.fullname',$this->employeeid,true);

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
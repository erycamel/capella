<?php

/**
 * This is the model class for table "reportperday".
 *
 * The followings are the available columns in table 'reportperday':
 * @property integer $reportperdayid
 * @property integer $employeeid
 * @property string $fullname
 * @property string $oldnik
 * @property string $newnik
 * @property string $fulldivision
 * @property string $absdate
 * @property string $hourin
 * @property string $hourout
 * @property integer $absscheduleid
 * @property string $schedulename
 * @property string $statusin
 * @property string $statusout
 */
class Reportperday extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Reportperday the static model class
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
		return 'reportperday';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, fullname, oldnik, newnik, fulldivision, absdate, hourin, hourout, absscheduleid, schedulename, statusin, statusout', 'required'),
			array('employeeid, absscheduleid', 'numerical', 'integerOnly'=>true),
			array('fullname, oldnik, newnik', 'length', 'max'=>50),
			array('fulldivision', 'length', 'max'=>500),
			array('hourin, hourout', 'length', 'max'=>5),
			array('schedulename', 'length', 'max'=>10),
			array('statusin, statusout', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reportperdayid, employeeid, fullname, oldnik, newnik, fulldivision, absdate, hourin, hourout, absscheduleid, schedulename, statusin, statusout', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reportperdayid' => 'ID',
			'employeeid' => 'Employee',
			'fullname' => 'Name ',
			'oldnik' => 'Oldnik',
			'newnik' => 'Newnik',
			'fulldivision' => 'Fulldivision',
			'absdate' => 'Absence Date',
			'hourin' => 'Hour In',
			'hourout' => 'Hour Out',
			'absscheduleid' => 'ID Schedule',
			'schedulename' => 'Schedule',
			'statusin' => 'Status In',
			'statusout' => 'Status Out',
            'reason'=>'Reason'
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

		$criteria->compare('reportperdayid',$this->reportperdayid);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('oldnik',$this->oldnik,true);
		$criteria->compare('newnik',$this->newnik,true);
		$criteria->compare('fulldivision',$this->fulldivision,true);
		$criteria->compare('absdate',$this->absdate,true);
		$criteria->compare('hourin',$this->hourin,true);
		$criteria->compare('hourout',$this->hourout,true);
		$criteria->compare('absscheduleid',$this->absscheduleid);
		$criteria->compare('schedulename',$this->schedulename,true);
		$criteria->compare('statusin',$this->statusin,true);
		$criteria->compare('statusout',$this->statusout,true);
		$criteria->compare('reason',$this->reason,true);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "lockercompare".
 *
 * The followings are the available columns in table 'lockercompare':
 * @property integer $lockercompareid
 * @property integer $lockerkeyid
 * @property string $keynum
 * @property integer $employeeid
 * @property string $fullname
 * @property string $oldnik
 * @property string $newnik
 * @property string $fulldivision
 * @property integer $absscheduleid
 * @property string $schedulename
 * @property string $transdate
 * @property string $takedate
 * @property string $checkdate
 * @property string $returndate
 */
class Lockercompare extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lockercompare the static model class
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
		return 'lockercompare';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lockerkeyid, keynum, employeeid, fullname, oldnik, newnik, fulldivision, absscheduleid, schedulename, transdate', 'required'),
			array('lockerkeyid, employeeid, absscheduleid', 'numerical', 'integerOnly'=>true),
			array('keynum, schedulename', 'length', 'max'=>10),
			array('fullname, oldnik, newnik', 'length', 'max'=>50),
			array('fulldivision', 'length', 'max'=>100),
			array('takedate, checkdate, returndate', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lockercompareid, lockerkeyid, keynum, employeeid, fullname, oldnik, newnik, fulldivision, absscheduleid, schedulename, transdate, takedate, checkdate, returndate', 'safe', 'on'=>'search'),
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
			'lockercompareid' => 'Lockercompareid',
			'lockerkeyid' => 'Lockerkeyid',
			'keynum' => 'Keynum',
			'employeeid' => 'Employeeid',
			'fullname' => 'Fullname',
			'oldnik' => 'Oldnik',
			'newnik' => 'Newnik',
			'fulldivision' => 'Fulldivision',
			'absscheduleid' => 'Absscheduleid',
			'schedulename' => 'Schedulename',
			'transdate' => 'Transdate',
			'takedate' => 'Takedate',
			'checkdate' => 'Checkdate',
			'returndate' => 'Returndate',
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

		$criteria->compare('lockercompareid',$this->lockercompareid);
		$criteria->compare('lockerkeyid',$this->lockerkeyid);
		$criteria->compare('keynum',$this->keynum,true);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('oldnik',$this->oldnik,true);
		$criteria->compare('newnik',$this->newnik,true);
		$criteria->compare('fulldivision',$this->fulldivision,true);
		$criteria->compare('absscheduleid',$this->absscheduleid);
		$criteria->compare('schedulename',$this->schedulename,true);
		$criteria->compare('transdate',$this->transdate,true);
		$criteria->compare('takedate',$this->takedate,true);
		$criteria->compare('checkdate',$this->checkdate,true);
		$criteria->compare('returndate',$this->returndate,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "lockerreturn".
 *
 * The followings are the available columns in table 'lockerreturn':
 * @property integer $lockerreturnid
 * @property integer $lockerkeyid
 * @property integer $lockerboxid
 * @property string $returndate
 * @property integer $lockerstaffid
 * @property integer $employeeid
 * @property string $fullname
 * @property string $oldnik
 * @property string $newnik
 * @property string $fulldivision
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Lockerbox $lockerbox
 * @property Employee $employee
 * @property Lockerkey $lockerkey
 * @property Lockerstaff $lockerstaff
 */
class Lockerreturn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lockerreturn the static model class
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
		return 'lockerreturn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lockerkeyid, lockerboxid, returndate, lockerstaffid, employeeid, fullname, oldnik, newnik, fulldivision, recordstatus', 'required'),
			array('lockerkeyid, lockerboxid, lockerstaffid, employeeid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('fullname, oldnik, newnik, fulldivision', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lockerreturnid, lockerkeyid, lockerboxid, returndate, lockerstaffid, employeeid, fullname, oldnik, newnik, fulldivision, recordstatus', 'safe', 'on'=>'search'),
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
			'lockerbox' => array(self::BELONGS_TO, 'Lockerbox', 'lockerboxid'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
			'lockerkey' => array(self::BELONGS_TO, 'Lockerkey', 'lockerkeyid'),
			'lockerstaff' => array(self::BELONGS_TO, 'Lockerstaff', 'lockerstaffid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lockerreturnid' => 'Lockerreturnid',
			'lockerkeyid' => 'Lockerkeyid',
			'lockerboxid' => 'Lockerboxid',
			'returndate' => 'Returndate',
			'lockerstaffid' => 'Lockerstaffid',
			'employeeid' => 'Employeeid',
			'fullname' => 'Fullname',
			'oldnik' => 'Oldnik',
			'newnik' => 'Newnik',
			'fulldivision' => 'Fulldivision',
			'recordstatus' => 'Recordstatus',
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

		$criteria->compare('lockerreturnid',$this->lockerreturnid);
		$criteria->compare('lockerkeyid',$this->lockerkeyid);
		$criteria->compare('lockerboxid',$this->lockerboxid);
		$criteria->compare('returndate',$this->returndate,true);
		$criteria->compare('lockerstaffid',$this->lockerstaffid);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('oldnik',$this->oldnik,true);
		$criteria->compare('newnik',$this->newnik,true);
		$criteria->compare('fulldivision',$this->fulldivision,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
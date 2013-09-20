<?php

/**
 * This is the model class for table "lockertake".
 *
 * The followings are the available columns in table 'lockertake':
 * @property integer $lockertakeid
 * @property integer $employeeid
 * @property integer $lockerkeyid
 * @property string $fullname
 * @property string $oldnik
 * @property string $newnik
 * @property string $fulldivision
 * @property string $takedate
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Lockerkey $lockerkey
 */
class Lockertake extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lockertake the static model class
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
		return 'lockertake';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, lockerkeyid, fullname, oldnik, newnik, fulldivision, takedate, recordstatus', 'required'),
			array('employeeid, lockerkeyid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('fullname, oldnik, newnik', 'length', 'max'=>50),
			array('fulldivision', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lockertakeid, employeeid, lockerkeyid, fullname, oldnik, newnik, fulldivision, takedate, recordstatus', 'safe', 'on'=>'search'),
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
			'lockerkey' => array(self::BELONGS_TO, 'Lockerkey', 'lockerkeyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lockertakeid' => 'Lockertakeid',
			'employeeid' => 'Employeeid',
			'lockerkeyid' => 'Lockerkeyid',
			'fullname' => 'Fullname',
			'oldnik' => 'Oldnik',
			'newnik' => 'Newnik',
			'fulldivision' => 'Fulldivision',
			'takedate' => 'Takedate',
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

		$criteria->compare('lockertakeid',$this->lockertakeid);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('lockerkeyid',$this->lockerkeyid);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('oldnik',$this->oldnik,true);
		$criteria->compare('newnik',$this->newnik,true);
		$criteria->compare('fulldivision',$this->fulldivision,true);
		$criteria->compare('takedate',$this->takedate,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
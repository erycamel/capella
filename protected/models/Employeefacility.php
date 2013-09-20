<?php

/**
 * This is the model class for table "employeefacility".
 *
 * The followings are the available columns in table 'employeefacility':
 * @property string $employeefacilityid
 * @property string $employeeid
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Employeefacilitydet[] $employeefacilitydets
 */
class Employeefacility extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeefacility the static model class
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
		return 'employeefacility';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('employeeid', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeefacilityid, employeeid, recordstatus', 'safe', 'on'=>'search'),
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
			'employeefacilitydets' => array(self::HAS_MANY, 'Employeefacilitydet', 'employeefacilityid'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeefacilityid' => 'ID',
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
		$criteria->compare('employeefacilityid',$this->employeefacilityid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
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
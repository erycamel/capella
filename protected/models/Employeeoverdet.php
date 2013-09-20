<?php

/**
 * This is the model class for table "employeeoverdet".
 *
 * The followings are the available columns in table 'employeeoverdet':
 * @property integer $employeeoverdetid
 * @property integer $employeeoverid
 * @property integer $accountid
 * @property string $debit
 * @property string $credit
 *
 * The followings are the available model relations:
 * @property Account $account
 * @property Employeeover $employeeover
 */
class Employeeoverdet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeeoverdet the static model class
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
		return 'employeeoverdet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeoverid', 'required'),
			array('employeeoverid,employeeid', 'numerical', 'integerOnly'=>true),
			array('overtime,overtimeend', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeeoverdetid, employeeoverid, employeeid, overtime,overtimeend', 'safe', 'on'=>'search'),
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
			'employeeover' => array(self::BELONGS_TO, 'Employeeover', 'employeeoverid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeeoverdetid' => 'ID',
			'employeeoverid' => 'Header',
            'employeeid'=>'Employee',
            'overtime'=>'Start Time',
            'overtimeend'=>'End Time'
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
		$criteria->with=array('employeeover','employee');
		if (isset($_GET['Employeeoverdet'])) {
$model=new Employeeoverdet('search');
$model->attributes = $_GET['Employeeoverdet'];
$criteria->condition='t.employeeoverid='.$model->employeeoverid;
} else {
$criteria->condition='t.employeeoverid=0';
}
		$criteria->compare('employeeoverdetid',$this->employeeoverdetid);
		$criteria->compare('employeeover.employeeoverid',$this->employeeoverid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('overtime',$this->overtime,true);

		return new CActiveDataProvider(get_class($this), array(
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
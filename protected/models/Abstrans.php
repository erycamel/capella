<?php

/**
 * This is the model class for table "abstrans".
 *
 * The followings are the available columns in table 'abstrans':
 * @property integer $abstransid
 * @property integer $employeeid
 * @property string $date_in
 * @property string $date_out
 * @property string $time_in
 * @property string $time_out
 * @property integer $shift
 * @property string $overdue
 * @property string $early
 * @property integer $holiday
 *
 * The followings are the available model relations:
 * @property Employee $employee
 */
class Abstrans extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Abstrans the static model class
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
		return 'abstrans';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid', 'numerical', 'integerOnly'=>true),
			array('reason', 'length', 'max'=>50),
			array('datetimeclock', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('abstransid, employeeid, datetimeclock,reason', 'safe', 'on'=>'search'),
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
			'abstransid' => 'ID',
			'employeeid' => 'Employee',
			'datetimeclock' => 'Date Time Clock',
			'reason' => 'Reason',
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
		$criteria->compare('abstransid',$this->abstransid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('datetimeclock',$this->datetimeclock,true);
		$criteria->compare('reason',$this->reason,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
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
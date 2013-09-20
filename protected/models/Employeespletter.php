<?php

/**
 * This is the model class for table "employeespletter".
 *
 * The followings are the available columns in table 'employeespletter':
 * @property string $employeespletterid
 * @property integer $employeeid
 * @property string $splettertypeid
 * @property string $transdate
 * @property string $expiredate
 * @property string $reason
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Splettertype $splettertype
 */
class Employeespletter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employeespletter the static model class
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
		return 'employeespletter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, splettertypeid, transdate, reason', 'required'),
			array('employeeid,recordstatus', 'numerical', 'integerOnly'=>true),
			array('splettertypeid,enddate', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeespletterid, employeeid, splettertypeid, transdate, reason', 'safe', 'on'=>'search'),
		);
	}
            public function beforeSave()
    {
      $this->transdate = date(Yii::app()->params['datetodb'], strtotime($this->transdate));
      $this->enddate = date(Yii::app()->params['datetodb'], strtotime($this->enddate));
      return parent::beforeSave();
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
			'splettertype' => array(self::BELONGS_TO, 'Splettertype', 'splettertypeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeespletterid' => 'ID',
			'employeeid' => 'Employee',
			'splettertypeid' => 'Sanction Type',
			'transdate' => 'Date',
			'reason' => 'Reason',
			'enddate' => 'End Date'
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
		$criteria->with=array('employee','splettertype');
		$criteria->compare('employeespletterid',$this->employeespletterid,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('splettertype.splettername',$this->splettertypeid,true);
		$criteria->compare('transdate',$this->transdate,true);
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
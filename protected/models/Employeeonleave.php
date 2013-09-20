<?php

/**
 * This is the model class for table "employeeonleave".
 *
 * The followings are the available columns in table 'employeeonleave':
 * @property integer $employeeonleaveid
 * @property integer $employeeid
 * @property integer $onleaveid
 * @property string $periodefrom
 * @property string $periodeto
 * @property integer $lastvalue
 * @property integer $recordstatus
 */
class Employeeonleave extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeeonleave the static model class
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
		return 'employeeonleave';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, onleaveid, periodefrom, periodeto, lastvalue, recordstatus', 'required'),
			array('employeeid, onleaveid, lastvalue, recordstatus', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeeonleaveid, employeeid, onleaveid, periodefrom, periodeto, lastvalue, recordstatus', 'safe', 'on'=>'search'),
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
			'onleavetype' => array(self::BELONGS_TO, 'Onleavetype', 'onleaveid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeeonleaveid' => 'ID',
			'employeeid' => 'Employee',
			'onleaveid' => 'Onleave',
			'periodefrom' => 'Periode From',
			'periodeto' => 'Periode To',
			'lastvalue' => 'Onleave value',
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
        $criteria->with=array('employee','onleavetype');
		$criteria->compare('employeeonleaveid',$this->employeeonleaveid);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('onleavetype.onleavename',$this->onleaveid,true);
		$criteria->compare('periodefrom',$this->periodefrom,true);
		$criteria->compare('periodeto',$this->periodeto,true);
		$criteria->compare('lastvalue',$this->lastvalue);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
    
    public function beforeSave()
    {
      $this->periodefrom = date(Yii::app()->params['datetodb'], strtotime($this->periodefrom));
      $this->periodeto = date(Yii::app()->params['datetodb'], strtotime($this->periodeto));
      return parent::beforeSave();
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
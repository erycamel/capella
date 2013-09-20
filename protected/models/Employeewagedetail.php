<?php

/**
 * This is the model class for table "employeewagedetail".
 *
 * The followings are the available columns in table 'employeewagedetail':
 * @property string $employeewagedetailid
 * @property string $wagetypeid
 * @property string $startdate
 * @property string $enddate
 * @property string $amount
 * @property string $currencyid
 * @property string $reason
 * @property string $employeewageid
 */
class Employeewagedetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeewagedetail the static model class
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
		return 'employeewagedetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wagetypeid, currencyid, employeewageid', 'length', 'max'=>10),
			array('amount', 'length', 'max'=>20),
			array('reason', 'length', 'max'=>50),
			array('startdate, enddate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeewagedetailid, wagetypeid, startdate, enddate, amount, currencyid, reason, employeewageid', 'safe', 'on'=>'search'),
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
			'wagetype' => array(self::BELONGS_TO, 'Wagetype', 'wagetypeid'),
      'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
      'employeewage' => array(self::BELONGS_TO, 'Employeewage', 'employeewageid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeewagedetailid' => 'ID',
			'wagetypeid' => 'Wage Type',
			'startdate' => 'Start Date',
			'enddate' => 'End Date',
			'amount' => 'Amount',
			'currencyid' => 'Currency',
			'reason' => 'Reason',
			'employeewageid' => 'Employee',
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
        $criteria->with=array('wagetype','currency');
		if (isset($_GET['Employeewagedetail'])) {
$model=new Employeewagedetail('search');
$model->attributes = $_GET['Employeewagedetail'];
$criteria->condition='t.employeewageid='.$model->employeewageid;
} else {
$criteria->condition='t.employeewageid=0';
}
		$criteria->compare('employeewagedetailid',$this->employeewagedetailid,true);
		$criteria->compare('wagetypeid',$this->wagetypeid,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('currencyid',$this->currencyid,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('t.employeewageid',$this->employeewageid,true);

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
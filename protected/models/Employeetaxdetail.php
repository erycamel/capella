<?php

/**
 * This is the model class for table "employeetaxdetail".
 *
 * The followings are the available columns in table 'employeetaxdetail':
 * @property string $employeetaxdetailid
 * @property string $wagetypeid
 * @property string $startdate
 * @property string $enddate
 * @property string $amount
 * @property string $currencyid
 * @property string $reason
 * @property string $employeetaxid
 */
class Employeetaxdetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeetaxdetail the static model class
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
		return 'employeetaxdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wagetypeid, currencyid, employeetaxid', 'length', 'max'=>10),
			array('amount', 'length', 'max'=>20),
			array('reason', 'length', 'max'=>50),
			array('startdate, enddate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeetaxdetailid, wagetypeid, startdate, enddate, amount, currencyid, employeetaxid', 'safe', 'on'=>'search'),
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
      'employeetax' => array(self::BELONGS_TO, 'Employeetax', 'employeetaxid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeetaxdetailid' => 'ID',
			'wagetypeid' => 'Wage Type',
			'startdate' => 'Start Date',
			'enddate' => 'End Date',
			'amount' => 'Amount',
			'currencyid' => 'Currency',
			'employeetaxid' => 'Employee',
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
		if (isset($_GET['Employeetaxdetail'])) {
$model=new Employeetaxdetail('search');
$model->attributes = $_GET['Employeetaxdetail'];
$criteria->condition='t.employeetaxid='.$model->employeetaxid;
} else {
$criteria->condition='t.employeetaxid=0';
}
		$criteria->compare('employeetaxdetailid',$this->employeetaxdetailid,true);
		$criteria->compare('wagetypeid',$this->wagetypeid,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('currencyid',$this->currencyid,true);
		$criteria->compare('t.employeetaxid',$this->employeetaxid,true);

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
<?php

/**
 * This is the model class for table "journaldetail".
 *
 * The followings are the available columns in table 'journaldetail':
 * @property integer $journaldetailid
 * @property integer $genjournalid
 * @property integer $accountid
 * @property string $debit
 * @property string $credit
 *
 * The followings are the available model relations:
 * @property Account $account
 * @property Genjournal $genjournal
 */
class Pocdetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Journaldetail the static model class
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
		return 'pocdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pocheaderid, productid', 'required'),
			array('pocheaderid, productid, unitofmeasureid,serviceuomid,servicecurrencyid,currencyid', 'numerical', 'integerOnly'=>true),
			array('qty,price,serviceqty,serviceprice', 'numerical', 'integerOnly'=>false),
			array('description', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pocheaderid, productid, unitofmeasureid, qty,price,currencyid,serviceprice,serviceqty,serviceuomid,servicecurrencyid', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'unitofmeasure' => array(self::BELONGS_TO, 'Unitofmeasure', 'unitofmeasureid'),
			'pocheader' => array(self::BELONGS_TO, 'Pocheader', 'pocheaderid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'serviceuom' => array(self::BELONGS_TO, 'Unitofmeasure', 'serviceuomid'),
			'servicecurrency' => array(self::BELONGS_TO, 'Currency', 'servicecurrencyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pocdetailid' => 'ID',
			'pocheaderid' => 'POC Header',
			'productid' => 'Material / Service',
			'unitofmeasureid' => 'Unit of Measure',
			'qty' => 'Quantity',
            'price'=>'Price',
            'currencyid'=>'Currency',
            'serviceqty'=>'Service Qty',
            'servicecurrencyid'=>'Service Currency',
            'serviceprice'=>'Service Price',
            'serviceuomid'=>'Service UOM'
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
		$criteria->with=array('product','unitofmeasure','pocheader','currency','servicecurrency');
if (isset($_GET['Pocdetail'])) {
$model=new Pocdetail('search');
$model->attributes = $_GET['Pocdetail'];
$criteria->condition='t.pocheaderid='.$model->pocheaderid;
} else {
$criteria->condition='t.pocheaderid=0';
} 		$criteria->compare('pocdetailid',$this->pocdetailid);
		$criteria->compare('pocheader.pocheaderid',$this->pocheaderid,true);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('unitofmeasure.uomcode',$this->unitofmeasureid,true);
		$criteria->compare('qty',$this->qty,true);

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
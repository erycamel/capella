<?php

/**
 * This is the model class for table "invoicearmat".
 *
 * The followings are the available columns in table 'invoicearmat':
 * @property string $invoicearmatid
 * @property string $productid
 * @property string $qty
 * @property string $unitofmeasureid
 * @property string $price
 * @property string $currencyid
 * @property string $taxid
 */
class Invoicearmat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invoicearmat the static model class
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
		return 'invoicearmat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoiceid,productid, qty, unitofmeasureid, price, currencyid, taxid', 'required'),
			array('productid, qty, unitofmeasureid, currencyid, taxid', 'length', 'max'=>10),
			array('price', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoicearmatid, productid, qty, unitofmeasureid, price, currencyid, taxid', 'safe', 'on'=>'search'),
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
			'tax' => array(self::BELONGS_TO, 'Tax', 'taxid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'unitofmeasure' => array(self::BELONGS_TO, 'Unitofmeasure', 'unitofmeasureid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'invoice' => array(self::BELONGS_TO, 'Invoice', 'invoiceid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoicearmatid' => 'ID',
			'productid' => 'Product',
			'qty' => 'Qty',
			'unitofmeasureid' => 'UOM',
			'price' => 'Price',
			'currencyid' => 'Currency',
			'taxid' => 'Tax',
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
        $criteria->with=array('product','currency','tax','unitofmeasure','invoice');
if (isset($_GET['Invoicearmat'])) {
$model=new Invoicearmat('search');
$model->attributes = $_GET['Invoicearmat'];
$criteria->condition='t.invoiceid='.$model->invoiceid;
} else {
$criteria->condition='t.invoiceid=0';
}
		$criteria->compare('invoicearmatid',$this->invoicearmatid,true);
		$criteria->compare('invoice.invoiceno',$this->invoiceid,true);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('unitofmeasure.uomcode',$this->unitofmeasureid,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('tax.taxcode',$this->taxid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
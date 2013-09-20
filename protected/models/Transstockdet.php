<?php

/**
 * This is the model class for table "transstockdet".
 *
 * The followings are the available columns in table 'transstockdet':
 * @property string $transstockdetid
 * @property string $transferstockid
 * @property string $productid
 * @property string $unitofmeasureid
 * @property string $qty
 */
class Transstockdet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Transstockdet the static model class
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
		return 'transstockdet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transstockid, productid, unitofmeasureid, qty', 'required'),
			array('transstockid, productid, unitofmeasureid, qty', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('transstockdetid, transstockid, productid, unitofmeasureid, qty', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transstockdetid' => 'ID',
			'transstockid' => 'Header',
			'productid' => 'Product',
			'unitofmeasureid' => 'UOM',
			'qty' => 'Qty',
            'itemtext'=>'Description'
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

		$criteria->compare('transstockdetid',$this->transstockdetid,true);
		$criteria->compare('transstockid',$this->transstockid,true);
		$criteria->compare('productid',$this->productid,true);
		$criteria->compare('unitofmeasureid',$this->unitofmeasureid,true);
		$criteria->compare('qty',$this->qty,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
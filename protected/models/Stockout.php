<?php

/**
 * This is the model class for table "stockout".
 *
 * The followings are the available columns in table 'stockout':
 * @property string $stockoutid
 * @property string $productstockid
 * @property string $qtyout
 * @property string $unitofmeasureid
 * @property string $giheaderid
 */
class Stockout extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Stockout the static model class
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
		return 'stockout';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('productstockid, qtyout, unitofmeasureid, giheaderid', 'required'),
			array('productstockid, qtyout, unitofmeasureid, giheaderid', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stockoutid, productstockid, qtyout, unitofmeasureid, giheaderid', 'safe', 'on'=>'search'),
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
			'giheader' => array(self::BELONGS_TO, 'Giheader', 'giheaderid'),
			'productstock' => array(self::BELONGS_TO, 'Productstock', 'productstockid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'stockoutid' => 'Stockoutid',
			'productstockid' => 'Productstockid',
			'qtyout' => 'Qtyout',
			'unitofmeasureid' => 'Unitofmeasureid',
			'giheaderid' => 'Giheaderid',
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
		$criteria->with=array('giheader','product','unitofmeasure','sloc');
		if (isset($_GET['Stockout'])) {
$model=new Stockout('search');
$model->attributes = $_GET['Stockout'];
$criteria->condition='t.giheaderid='.$model->giheaderid;
} else {
$criteria->condition='t.giheaderid=0';
}
		$criteria->compare('stockoutid',$this->stockoutid,true);
		$criteria->compare('productstockid',$this->productstockid,true);
		$criteria->compare('qtyout',$this->qtyout,true);
		$criteria->compare('unitofmeasureid',$this->unitofmeasureid,true);
		$criteria->compare('giheaderid',$this->giheaderid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
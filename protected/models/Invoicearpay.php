<?php

/**
 * This is the model class for table "invoicearpay".
 *
 * The followings are the available columns in table 'invoicearpay':
 * @property string $invoicearpayid
 * @property string $invoicearid
 * @property string $accountid
 * @property string $debet
 * @property string $credit
 * @property string $currencyid
 */
class Invoicearpay extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invoicearpay the static model class
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
		return 'invoicearpay';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoicearid, accountid, currencyid', 'required'),
			array('invoicearid, accountid, currencyid', 'length', 'max'=>10),
			array('debet, credit', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoicearpayid, invoicearid, accountid, debet, credit, currencyid', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoicearpayid' => 'Invoicearpayid',
			'invoicearid' => 'Invoicearid',
			'accountid' => 'Accountid',
			'debet' => 'Debet',
			'credit' => 'Credit',
			'currencyid' => 'Currencyid',
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

		$criteria->compare('invoicearpayid',$this->invoicearpayid,true);
		$criteria->compare('invoicearid',$this->invoicearid,true);
		$criteria->compare('accountid',$this->accountid,true);
		$criteria->compare('debet',$this->debet,true);
		$criteria->compare('credit',$this->credit,true);
		$criteria->compare('currencyid',$this->currencyid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "invoicejournal".
 *
 * The followings are the available columns in table 'invoicejournal':
 * @property string $invoicejournalid
 * @property string $invoiceid
 * @property string $accountid
 * @property string $debet
 * @property string $credit
 *
 * The followings are the available model relations:
 * @property Invoice $invoice
 */
class Invoicejournal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invoicejournal the static model class
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
		return 'invoicejournal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoiceid, accountid', 'required'),
			array('invoiceid, accountid', 'length', 'max'=>10),
			array('debet, credit', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoicejournalid, invoiceid, accountid, debet, credit', 'safe', 'on'=>'search'),
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
			'invoice' => array(self::BELONGS_TO, 'Invoice', 'invoiceid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoicejournalid' => 'Invoicejournalid',
			'invoiceid' => 'Invoiceid',
			'accountid' => 'Accountid',
			'debet' => 'Debet',
			'credit' => 'Credit',
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

		$criteria->compare('invoicejournalid',$this->invoicejournalid,true);
		$criteria->compare('invoiceid',$this->invoiceid,true);
		$criteria->compare('accountid',$this->accountid,true);
		$criteria->compare('debet',$this->debet,true);
		$criteria->compare('credit',$this->credit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
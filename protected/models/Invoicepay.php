<?php

/**
 * This is the model class for table "invoicepay".
 *
 * The followings are the available columns in table 'invoicepay':
 * @property string $invoicepayid
 * @property string $invoiceid
 * @property string $accountid
 * @property string $debet
 * @property string $credit
 * @property string $currencyid
 *
 * The followings are the available model relations:
 * @property Invoice $invoice
 */
class Invoicepay extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invoicepay the static model class
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
		return 'invoicepay';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoiceid, accountid, currencyid', 'required'),
			array('invoiceid, accountid, currencyid', 'length', 'max'=>10),
			array('debet, credit', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoicepayid, invoiceid, accountid, debet, credit, currencyid', 'safe', 'on'=>'search'),
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
			'account' => array(self::BELONGS_TO, 'Account', 'accountid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoicepayid' => 'ID',
			'invoiceid' => 'Invoice',
			'accountid' => 'Account',
			'debet' => 'Debet',
			'credit' => 'Credit',
			'currencyid' => 'Currency',
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
        $criteria->with=array('account','currency','invoice');
if (isset($_GET['Invoicepay'])) {
$model=new Invoicepay('search');
$model->attributes = $_GET['Invoicepay'];
$criteria->condition='t.invoiceid='.$model->invoiceid;
} else {
$criteria->condition='t.invoiceid=0';
}
		$criteria->compare('invoicepayid',$this->invoicepayid,true);
		$criteria->compare('invoice.invoiceno',$this->invoiceid,true);
		$criteria->compare('account.accountcode',$this->accountid,true);
		$criteria->compare('debet',$this->debet,true);
		$criteria->compare('credit',$this->credit,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
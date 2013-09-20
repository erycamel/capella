<?php

/**
 * This is the model class for table "invoicemat".
 *
 * The followings are the available columns in table 'invoicemat':
 * @property string $invoicematid
 * @property string $invoiceid
 * @property string $accountid
 * @property string $debet
 * @property string $credit
 *
 * The followings are the available model relations:
 * @property Invoice $invoice
 */
class Invoicemat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invoicemat the static model class
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
		return 'invoicemat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoiceapid,productid', 'required'),
			array('invoiceapid,productid,qty,price,serviceqty,serviceprice', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoicematid, invoiceapid,productid,qty,price,serviceqty,serviceprice', 'safe', 'on'=>'search'),
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
			'invoiceap' => array(self::BELONGS_TO, 'Invoicear', 'invoiceapid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'uom' => array(self::BELONGS_TO, 'Unitofmeasure', 'unitofmeasureid'),
			'tax' => array(self::BELONGS_TO, 'Tax', 'taxid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoicematid' => 'ID',
			'invoiceapid' => 'Invoice',
			'productid'=>'Product',
			'qty' =>'Qty',
			'price' => 'Price',
			'unitofmeasureid' => 'UOM',
			'currencyid' => 'Currency',
			'taxid' => 'Tax'
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
		$criteria->with=array('product');
		if (isset($_GET['Invoicemat'])) {
			$criteria->condition='t.invoiceapid='.$_GET['Invoicemat']['invoiceapid'];
		} else {
			$criteria->condition='t.invoiceapid=0';
		}
		$criteria->compare('invoicematid',$this->invoicematid,true);
		$criteria->compare('invoiceapid',$this->invoiceapid,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),	
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
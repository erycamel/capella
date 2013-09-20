<?php

/**
 * This is the model class for table "invoicedet".
 *
 * The followings are the available columns in table 'invoicedet':
 * @property string $invoicedetid
 * @property string $invoiceid
 * @property string $description
 * @property string $qty
 * @property integer $unitofmeasureid
 * @property string $price
 * @property integer $currencyid
 * @property string $rate
 *
 * The followings are the available model relations:
 * @property Currency $currency
 * @property Invoice $invoice
 * @property Unitofmeasure $unitofmeasure
 */
class Invoicedet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Invoicedet the static model class
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
		return 'invoicedet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoiceid', 'required'),
			array('unitofmeasureid, currencyid,productid,taxid', 'numerical', 'integerOnly'=>true),
			array('invoiceid', 'length', 'max'=>10),
			array('qty, price, rate', 'length', 'max'=>30),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoicedetid, invoiceid, description, qty, taxid,unitofmeasureid, price, currencyid, rate,productid', 'safe', 'on'=>'search'),
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
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'invoice' => array(self::BELONGS_TO, 'Invoice', 'invoiceid'),
			'unitofmeasure' => array(self::BELONGS_TO, 'Unitofmeasure', 'unitofmeasureid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'tax' => array(self::BELONGS_TO, 'Tax', 'taxid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoicedetid' => 'ID',
			'invoiceid' => 'Invoice',
			'description' => 'Description',
			'qty' => 'Qty',
			'unitofmeasureid' => 'UOM',
			'price' => 'Price',
			'currencyid' => 'Currency',
			'rate' => 'Rate',
			'productid'=>'Item',
			'taxid'=>'Tax'
		);
	}
	
	public function getTotals()
	{
		$total=0;
		$connection=Yii::app()->db;
			  try
			  {
				$sql = 'select sum(ifnull(price,0) * ifnull(qty,0) * ifnull(rate,0)) as total from invoicedet where invoiceid= '.$this->invoiceid;
				$command=$connection->createCommand($sql);
				$row = 	$command->queryRow();
				$total = $row['total'];
				return $total;
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				return $total;
			}
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
		$criteria->with=array('product','currency','unitofmeasure','invoice','tax');
if (isset($_GET['Invoicedet'])) {
$criteria->condition='t.invoiceid='.$_GET['Invoicedet']['invoiceid'];
} else {
$criteria->condition='t.invoiceid=0';
}
		$criteria->compare('invoicedetid',$this->invoicedetid,true);
		$criteria->compare('t.invoiceid',$this->invoiceid,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('unitofmeasureid',$this->unitofmeasureid,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('currencyid',$this->currencyid,true);
		$criteria->compare('rate',$this->rate,true);
		$criteria->compare('taxid',$this->taxid,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}
	
			public function beforeSave() {
		$this->qty = str_replace(",","",$this->qty);
		$this->price = str_replace(",","",$this->price);
    return parent::beforeSave();
}

	
	public function behaviors()
  {
    return array(
        // Classname => path to Class
        'ActiveRecordLogableBehavior'=>
            'application.behaviors.ActiveRecordLogableBehavior'
    );
  }
}
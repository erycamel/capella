<?php

/**
 * This is the model class for table "prowotemplate".
 *
 * The followings are the available columns in table 'prowotemplate':
 * @property string $prowotemplateid
 * @property string $projectid
 *
 * The followings are the available model relations:
 * @property Project $project
 */
class Prowotemplate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Prowotemplate the static model class
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
		return 'prowotemplate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projecttypeid, addressbookid, recordstatus', 'required'),
			array('unitofmeasureid,serviceuomid,currencyid,servicecurrencyid,productid', 'numerical', 'integerOnly'=>true),
            array('serviceqty,serviceprice,qty,price','numerical','integerOnly'=>false),
			array('contractno', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prowotemplateid, projecttypeid, addressbookid, currencyid, price, currencyid, recordstatus', 'safe', 'on'=>'search'),
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
			'projecttype' => array(self::BELONGS_TO, 'Projecttype', 'projecttypeid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'addressbookid'),
			'unitofmeasure' => array(self::BELONGS_TO, 'Unitofmeasure', 'unitofmeasureid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
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
			'prowotemplateid' => 'ID',
			'projecttypeid' => 'Project Type',
            'addressbookid' => 'Customer',
            'description'=> 'Description',
            'price' => 'Price',
            'currencyid'=>'Currency',
              'recordstatus'=>'Record Status',
            'qty'=>'Qty',
            'unitofmeasureid'=>'UOM',
            'productid'=>'Product',
            'serviceprice'=>'Service Price',
            'servicecurrencyid'=>'Service Currency',
            'serviceuomid'=>'Service UOM',
            'serviceqty'=>'Service Qty',
            'contractno'=>'Contract No'
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
        $criteria->with=array('projecttype','currency','customer','unitofmeasure','product',
            'serviceuom','servicecurrency');
		$criteria->compare('prowotemplateid',$this->prowotemplateid,true);
		$criteria->compare('projecttype.description',$this->projecttypeid,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('unitofmeasure.uomcode',$this->unitofmeasureid,true);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('serviceuom.uomcode',$this->serviceuomid,true);
		$criteria->compare('contractno',$this->contractno,true);
		$criteria->compare('servicecurrency.currencyname',$this->servicecurrencyid,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}

    public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('projecttype','currency','customer','unitofmeasure','product',
            'serviceuom','servicecurrency');
        $criteria->condition='t.recordstatus=1';
		$criteria->compare('prowotemplateid',$this->prowotemplateid,true);
		$criteria->compare('projecttype.description',$this->projecttypeid,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('unitofmeasure.uomcode',$this->unitofmeasureid,true);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('serviceuom.uomcode',$this->serviceuomid,true);
		$criteria->compare('servicecurrency.currencyname',$this->servicecurrencyid,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
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
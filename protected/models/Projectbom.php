<?php

/**
 * This is the model class for table "projectbom".
 *
 * The followings are the available columns in table 'projectbom':
 * @property string $projectbomid
 * @property string $projectid
 *
 * The followings are the available model relations:
 * @property Project $project
 */
class Projectbom extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Projectbom the static model class
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
		return 'projectbom';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projectid', 'required'),
			array('productid,unitofmeasureid,serviceuomid', 'numerical', 'integerOnly'=>false),
			array('qty,serviceqty', 'numerical', 'integerOnly'=>false),
			array('description', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('projectbomid, projectid, ', 'safe', 'on'=>'search'),
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
			'project' => array(self::BELONGS_TO, 'Project', 'projectid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'unitofmeasure' => array(self::BELONGS_TO, 'Unitofmeasure', 'unitofmeasureid'),
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
			'projectbomid' => 'Projectbomid',
			'projectid' => 'Header',
            'productid' => 'Product',
            'qty' => 'Qty',
            'unitofmeasureid' => 'UOM',
            'price'=>'Price',
            'currencyid'=>'Currency',
            'serviceqty'=>'Service Qty',
            'serviceuomid'=>'Service UOM',
            'serviceprice'=>'Service Price',
            'servicecurrencyid'=>'Service Currency'
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
        $criteria->with=array('project','unitofmeasure','product');
if (isset($_GET['Projectbom'])) {
$model=new Projectbom('search');
$model->attributes = $_GET['Projectbom'];
$criteria->condition='t.projectid='.$model->projectid;
} else {
$criteria->condition='t.projectid=0';
}
		$criteria->compare('projectbomid',$this->projectbomid,true);
		$criteria->compare('t.projectid',$this->projectid,true);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('unitofmeasure.uomcode',$this->unitofmeasureid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
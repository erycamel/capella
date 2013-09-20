<?php

/**
 * This is the model class for table "invoiceproject".
 *
 * The followings are the available columns in table 'invoiceproject':
 * @property string $invoiceprojectid
 * @property string $invoiceid
 * @property string $accountid
 * @property string $debet
 * @property string $credit
 *
 * The followings are the available model relations:
 * @property Invoice $invoice
 */
class Invoiceproject extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invoiceproject the static model class
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
		return 'invoiceproject';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoicearid,projectid', 'required'),
			array('invoicearid,projectid,qty,price,serviceqty,serviceprice', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoiceprojectid, invoicearid,projectid,qty,price,serviceqty,serviceprice', 'safe', 'on'=>'search'),
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
			'invoicear' => array(self::BELONGS_TO, 'Invoicear', 'invoicearid'),
			'project' => array(self::BELONGS_TO, 'Project', 'projectid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoiceprojectid' => 'ID',
			'invoicearid' => 'Invoice',
			'projectid'=>'Project',
			'serviceqty'=>'Service Qty',
			'serviceprice'=>'Service Price',
			'qty' =>'Material Qty',
			'price' => 'Material Price'
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
		$criteria->with=array('project');
		if (isset($_GET['Invoiceproject'])) {
			$criteria->condition='t.invoicearid='.$_GET['Invoiceproject']['invoicearid'];
		} else {
			$criteria->condition='t.invoicearid=0';
		}
		$criteria->compare('invoiceprojectid',$this->invoiceprojectid,true);
		$criteria->compare('invoicearid',$this->invoicearid,true);

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
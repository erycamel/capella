<?php

/**
 * This is the model class for table "tikitrans".
 *
 * The followings are the available columns in table 'tikitrans':
 * @property integer $airwaybillno
 * @property string $transdate
 * @property string $shipcompany
 * @property string $shipaddress
 * @property integer $shipcityid
 * @property integer $shipprovinceid
 * @property string $shipzipcode
 * @property string $shipname
 * @property integer $shipcountryid
 * @property string $shiptelno
 * @property string $descofship
 * @property string $deliveryinst
 * @property integer $paymentmethodid
 * @property string $charges
 * @property string $rcvcompany
 * @property string $rcvaddress
 * @property integer $rcvcityid
 * @property integer $rcvprovinceid
 * @property integer $rcvcountryid
 * @property string $rcvtelno
 * @property string $rcvattention
 * @property integer $recordstatus
 */
class Tikitrans extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tikitrans the static model class
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
		return 'tikitrans';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('airwaybillno', 'required'),
			array('airwaybillno, shipcityid, shipprovinceid, shipcountryid, paymentmethodid, rcvcityid, rcvprovinceid, rcvcountryid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('shipcompany, rcvcompany', 'length', 'max'=>100),
			array('shipzipcode, rcvzipcode, charges, rcvtelno', 'length', 'max'=>10),
			array('shipname, rcvattention', 'length', 'max'=>50),
			array('shiptelno', 'length', 'max'=>20),
			array('shipaddress, descofship, deliveryinst, rcvaddress', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('airwaybillno, transdate, shipcompany, shipaddress, shipcityid, shipprovinceid, shipzipcode, shipname, shipcountryid, shiptelno, descofship, deliveryinst, paymentmethodid, charges, rcvcompany, rcvaddress, rcvcityid, rcvprovinceid, rcvcountryid, rcvtelno, rcvattention, recordstatus', 'safe', 'on'=>'search'),
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
		  'paymentmethod' => array(self::BELONGS_TO, 'Paymentmethod', 'paymentmethodid'),
		  'shipcity' => array(self::BELONGS_TO, 'City', 'shipcityid'),
		  'shipprovince' => array(self::BELONGS_TO, 'Province', 'shipprovinceid'),
		  'shipcountry' => array(self::BELONGS_TO, 'Country', 'shipcountryid'),
		  'rcvcity' => array(self::BELONGS_TO, 'City', 'rcvcityid'),
		  'rcvprovince' => array(self::BELONGS_TO, 'Province', 'rcvprovinceid'),
		  'rcvcountry' => array(self::BELONGS_TO, 'Country', 'rcvcountryid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'airwaybillno' => 'Airway Bill No',
			'transdate' => 'Transaction Date',
			'shipcompany' => 'Company',
			'shipaddress' => 'Address',
			'shipcityid' => 'City',
			'shipprovinceid' => 'Province',
			'shipzipcode' => 'Zip Code',
			'shipname' => '',
			'shipcountryid' => 'Country',
			'shiptelno' => 'Tel No',
			'descofship' => 'Description of Ship',
			'deliveryinst' => 'Delivery Instruction',
			'paymentmethodid' => 'Payment Method',
			'charges' => 'Charges',
			'rcvcompany' => 'Company',
			'rcvaddress' => 'Address',
			'rcvcityid' => 'City',
			'rcvprovinceid' => 'Province',
			'rcvcountryid' => 'Country',
			'rcvtelno' => 'Tel No',
			'rcvattention' => 'Attention',
			'rcvzipcode'=>'Zip Code',
			'recordstatus' => 'Record Status',
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

		$criteria->compare('airwaybillno',$this->airwaybillno);
		$criteria->compare('transdate',$this->transdate,true);
		$criteria->compare('shipcompany',$this->shipcompany,true);
		$criteria->compare('shipaddress',$this->shipaddress,true);
		$criteria->compare('shipcityid',$this->shipcityid);
		$criteria->compare('shipprovinceid',$this->shipprovinceid);
		$criteria->compare('shipzipcode',$this->shipzipcode,true);
		$criteria->compare('shipname',$this->shipname,true);
		$criteria->compare('shipcountryid',$this->shipcountryid);
		$criteria->compare('shiptelno',$this->shiptelno,true);
		$criteria->compare('descofship',$this->descofship,true);
		$criteria->compare('deliveryinst',$this->deliveryinst,true);
		$criteria->compare('paymentmethodid',$this->paymentmethodid);
		$criteria->compare('charges',$this->charges,true);
		$criteria->compare('rcvcompany',$this->rcvcompany,true);
		$criteria->compare('rcvaddress',$this->rcvaddress,true);
		$criteria->compare('rcvcityid',$this->rcvcityid);
		$criteria->compare('rcvprovinceid',$this->rcvprovinceid);
		$criteria->compare('rcvcountryid',$this->rcvcountryid);
		$criteria->compare('rcvtelno',$this->rcvtelno,true);
		$criteria->compare('rcvattention',$this->rcvattention,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition='recordstatus=1';
		$criteria->compare('airwaybillno',$this->airwaybillno);
		$criteria->compare('transdate',$this->transdate,true);
		$criteria->compare('shipcompany',$this->shipcompany,true);
		$criteria->compare('shipaddress',$this->shipaddress,true);
		$criteria->compare('shipcityid',$this->shipcityid);
		$criteria->compare('shipprovinceid',$this->shipprovinceid);
		$criteria->compare('shipzipcode',$this->shipzipcode,true);
		$criteria->compare('shipname',$this->shipname,true);
		$criteria->compare('shipcountryid',$this->shipcountryid);
		$criteria->compare('shiptelno',$this->shiptelno,true);
		$criteria->compare('descofship',$this->descofship,true);
		$criteria->compare('deliveryinst',$this->deliveryinst,true);
		$criteria->compare('paymentmethodid',$this->paymentmethodid);
		$criteria->compare('charges',$this->charges,true);
		$criteria->compare('rcvcompany',$this->rcvcompany,true);
		$criteria->compare('rcvaddress',$this->rcvaddress,true);
		$criteria->compare('rcvcityid',$this->rcvcityid);
		$criteria->compare('rcvprovinceid',$this->rcvprovinceid);
		$criteria->compare('rcvcountryid',$this->rcvcountryid);
		$criteria->compare('rcvtelno',$this->rcvtelno,true);
		$criteria->compare('rcvattention',$this->rcvattention,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
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
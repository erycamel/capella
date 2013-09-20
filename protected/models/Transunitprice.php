<?php

/**
 * This is the model class for table "transunitprice".
 *
 * The followings are the available columns in table 'transunitprice':
 * @property integer $transunitpriceid
 * @property integer $pricetypeid
 * @property double $price
 * @property integer $currencyid
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Pricetype $pricetype
 * @property Currency $currency
 */
class Transunitprice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Transunitprice the static model class
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
		return 'transunitprice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pricetypeid, price, currencyid, recordstatus', 'required'),
			array('pricetypeid, currencyid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('transunitpriceid, pricetypeid, price, currencyid, recordstatus', 'safe', 'on'=>'search'),
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
			'pricetype' => array(self::BELONGS_TO, 'Pricetype', 'pricetypeid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transunitpriceid' => 'ID',
			'pricetypeid' => 'Price Type',
			'price' => 'Price',
			'currencyid' => 'Currency',
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
		$criteria->with=array('pricetype','currency');
		$criteria->compare('transunitpriceid',$this->transunitpriceid);
		$criteria->compare('pricetypeid',$this->pricetypeid);
		$criteria->compare('price',$this->price);
		$criteria->compare('currencyid',$this->currencyid);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
'criteria'=>$criteria,
		));
	}

	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
				$criteria->with=array('pricetype','currency');
		$criteria->condition='t.recordstatus=1';
		$criteria->compare('transunitpriceid',$this->transunitpriceid);
		$criteria->compare('pricetypeid',$this->pricetypeid);
		$criteria->compare('price',$this->price);
		$criteria->compare('currencyid',$this->currencyid);
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
		'defaults'=>array(
			  'class'=>'ext.DecimalI18NBehavior',
			  'format'=>'db',
		  ),
    );
  }
}
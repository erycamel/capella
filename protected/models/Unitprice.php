<?php

/**
 * This is the model class for table "unitprice".
 *
 * The followings are the available columns in table 'unitprice':
 * @property integer $unitpriceid
 * @property integer $pricetypeid
 * @property double $price
 * @property integer $currencyid
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Currency $currency
 * @property Pricetype $pricetype
 */
class Unitprice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Unitprice the static model class
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
		return 'unitprice';
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
			array('unitpriceid, pricetypeid, price, currencyid, recordstatus', 'safe', 'on'=>'search'),
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
			'pricetype' => array(self::BELONGS_TO, 'Pricetype', 'pricetypeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'unitpriceid' => 'ID',
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
		$criteria->compare('unitpriceid',$this->unitpriceid);
		$criteria->compare('pricetype.pricetypename',$this->pricetypeid,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
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
		$criteria->compare('unitpriceid',$this->unitpriceid);
		$criteria->compare('pricetype.pricetypename',$this->pricetypeid,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
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
            'application.behaviors.ActiveRecordLogableBehavior'
    );
  }
}
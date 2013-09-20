<?php

/**
 * This is the model class for table "currencyrate".
 *
 * The followings are the available columns in table 'currencyrate':
 * @property integer $currencyrateid
 * @property integer $currencyid
 * @property string $ratedate
 * @property double $ratevalue
 *
 * The followings are the available model relations:
 * @property Currency $currency
 */
class Currencyrate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Currencyrate the static model class
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
		return 'currencyrate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('currencyid, ratedate, ratevalue', 'required'),
			array('currencyid', 'numerical', 'integerOnly'=>true),
			array('ratevalue', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('currencyrateid, currencyid, ratedate, ratevalue', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'currencyrateid' => 'ID',
			'currencyid' => 'Currency',
			'ratedate' => 'Rate Date',
			'ratevalue' => 'Rate Value',
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
		$criteria->with=array('currency');
		$criteria->compare('currencyrateid',$this->currencyrateid);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('ratedate',$this->ratedate,true);
		$criteria->compare('ratevalue',$this->ratevalue);

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
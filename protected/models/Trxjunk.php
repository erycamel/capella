<?php

/**
 * This is the model class for table "trxjunk".
 *
 * The followings are the available columns in table 'trxjunk':
 * @property integer $trxjunkid
 * @property string $trxdate
 * @property string $senderx
 * @property string $textdecoded
 */
class Trxjunk extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Trxjunk the static model class
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
		return 'trxjunk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trxdate, senderx, textdecoded', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('trxjunkid, trxdate, senderx, textdecoded', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'trxjunkid' => 'Trxjunkid',
			'trxdate' => 'Trxdate',
			'senderx' => 'Senderx',
			'textdecoded' => 'Textdecoded',
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

		$criteria->compare('trxjunkid',$this->trxjunkid);
		$criteria->compare('trxdate',$this->trxdate,true);
		$criteria->compare('senderx',$this->senderx,true);
		$criteria->compare('textdecoded',$this->textdecoded,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
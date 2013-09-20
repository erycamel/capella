<?php

/**
 * This is the model class for table "assphonegroup".
 *
 * The followings are the available columns in table 'assphonegroup':
 * @property integer $assphonegroupid
 * @property integer $phonegroupid
 * @property integer $voucheragentid
 *
 * The followings are the available model relations:
 * @property Phonegroup $phonegroup
 * @property Voucheragent $voucheragent
 */
class Assphonegroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Assphonegroup the static model class
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
		return 'assphonegroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('phonegroupid, voucheragentid', 'required'),
			array('phonegroupid, voucheragentid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('assphonegroupid, phonegroupid, voucheragentid', 'safe', 'on'=>'search'),
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
			'phonegroup' => array(self::BELONGS_TO, 'Phonegroup', 'phonegroupid'),
			'voucheragent' => array(self::BELONGS_TO, 'Voucheragent', 'voucheragentid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'assphonegroupid' => 'ID',
			'phonegroupid' => 'Phone Group',
			'voucheragentid' => 'SMS Agent',
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

		$criteria->compare('assphonegroupid',$this->assphonegroupid);
		$criteria->compare('phonegroupid',$this->phonegroupid);
		$criteria->compare('voucheragentid',$this->voucheragentid);

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
            'application.behaviors.ActiveRecordLogableBehavior'
    );
  }
}
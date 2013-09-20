<?php

/**
 * This is the model class for table "groupmenuauth".
 *
 * The followings are the available columns in table 'groupmenuauth':
 * @property string $groupmenuauthid
 * @property string $groupaccessid
 * @property string $menuaccessid
 * @property string $menuvalueid
 */
class Groupmenuauth extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Groupmenuauth the static model class
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
		return 'groupmenuauth';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('groupaccessid, menuaccessid, menuvalueid', 'required'),
			array('groupaccessid, menuaccessid, menuvalueid', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('groupmenuauthid, groupaccessid, menuaccessid, menuvalueid', 'safe', 'on'=>'search'),
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
			'groupmenuauthid' => 'Groupmenuauthid',
			'groupaccessid' => 'Groupaccessid',
			'menuaccessid' => 'Menuaccessid',
			'menuvalueid' => 'Menuvalueid',
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

		$criteria->compare('groupmenuauthid',$this->groupmenuauthid,true);
		$criteria->compare('groupaccessid',$this->groupaccessid,true);
		$criteria->compare('menuaccessid',$this->menuaccessid,true);
		$criteria->compare('menuvalueid',$this->menuvalueid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "host".
 *
 * The followings are the available columns in table 'host':
 * @property integer $hostid
 * @property string $hostname
 * @property string $ipclient
 * @property integer $recordstatus
 */
class Host extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Host the static model class
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
		return 'host';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hostname, ipclient, recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('hostname', 'length', 'max'=>50),
			array('ipclient', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hostid, hostname, ipclient, recordstatus', 'safe', 'on'=>'search'),
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
			'hostid' => 'Hostid',
			'hostname' => 'Hostname',
			'ipclient' => 'Ipclient',
			'recordstatus' => 'Recordstatus',
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

		$criteria->compare('hostid',$this->hostid);
		$criteria->compare('hostname',$this->hostname,true);
		$criteria->compare('ipclient',$this->ipclient,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
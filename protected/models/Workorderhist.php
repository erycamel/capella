<?php

/**
 * This is the model class for table "workorderhist".
 *
 * The followings are the available columns in table 'workorderhist':
 * @property integer $workorderhist
 * @property integer $workorderid
 * @property string $statusdate
 * @property integer $workorderstatusid
 *
 * The followings are the available model relations:
 * @property Workorder $workorder
 * @property Workorderstatus $workorderstatus
 */
class Workorderhist extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Workorderhist the static model class
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
		return 'workorderhist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workorderid, workorderstatusid', 'required'),
			array('workorderid, workorderstatusid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('workorderhist, workorderid, statusdate, workorderstatusid', 'safe', 'on'=>'search'),
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
			'workorder' => array(self::BELONGS_TO, 'Workorder', 'workorderid'),
			'workorderstatus' => array(self::BELONGS_TO, 'Workorderstatus', 'workorderstatusid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'workorderhist' => 'Workorderhist',
			'workorderid' => 'Workorderid',
			'statusdate' => 'Statusdate',
			'workorderstatusid' => 'Workorderstatusid',
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
		 $criteria->with=array('workorder','workorderstatus');
		$criteria->compare('workorderhist',$this->workorderhist);
		$criteria->compare('workorder.workorderid',$this->workorderid,true);
		$criteria->compare('statusdate',$this->statusdate,true);
		$criteria->compare('workorderstatus.workorderstatusid',$this->workorderstatusid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
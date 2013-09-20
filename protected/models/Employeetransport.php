<?php

/**
 * This is the model class for table "employeetransport".
 *
 * The followings are the available columns in table 'employeetransport':
 * @property integer $employeetransportid
 * @property integer $employeeid
 * @property integer $transunitpriceid
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Transunitprice $transunitprice
 */
class Employeetransport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeetransport the static model class
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
		return 'employeetransport';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, transunitpriceid, recordstatus', 'required'),
			array('employeeid, transunitpriceid, recordstatus', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeetransportid, employeeid, transunitpriceid, recordstatus', 'safe', 'on'=>'search'),
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
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
			'transunitprice' => array(self::BELONGS_TO, 'Transunitprice', 'transunitpriceid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeetransportid' => 'ID',
			'employeeid' => 'Employee',
			'transunitpriceid' => 'Trans Unit Price',
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
		$criteria->compare('employeetransportid',$this->employeetransportid);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('transunitpriceid',$this->transunitpriceid);
		$criteria->compare('t.recordstatus',$this->recordstatus);
		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
				),
			'criteria'=>$criteria,
		));
	}

	public function searchwstatus()
	{
		$criteria=new CDbCriteria;
		$criteria->condition='t.recordstatus=1';
		$criteria->compare('employeetransportid',$this->employeetransportid);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('transunitpriceid',$this->transunitpriceid);
		$criteria->compare('t.recordstatus',$this->recordstatus);
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
<?php

/**
 * This is the model class for table "projectstatus".
 *
 * The followings are the available columns in table 'projectstatus':
 * @property string $projectstatusid
 * @property string $projectstatuscode
 * @property string $description
 * @property integer $recordstatus
 */
class Projectstatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Projectstatus the static model class
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
		return 'projectstatus';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projectstatuscode, description, recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('projectstatuscode', 'length', 'max'=>10),
			array('description', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('projectstatusid, projectstatuscode, description, recordstatus', 'safe', 'on'=>'search'),
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
			'projectstatusid' => 'ID',
			'projectstatuscode' => 'Code',
			'description' => 'Description',
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

		$criteria->compare('projectstatusid',$this->projectstatusid,true);
		$criteria->compare('projectstatuscode',$this->projectstatuscode,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->condition='t.recordstatus=1';
		$criteria->compare('projectstatusid',$this->projectstatusid,true);
		$criteria->compare('projectstatuscode',$this->projectstatuscode,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
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
<?php

/**
 * This is the model class for table "maritalstatus".
 *
 * The followings are the available columns in table 'maritalstatus':
 * @property integer $maritalstatusid
 * @property string $maritalstatusname
 * @property integer $recordstatus
 */
class Maritalstatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Maritalstatus the static model class
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
		return 'maritalstatus';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('maritalstatusname, recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('maritalstatusname', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('maritalstatusid, maritalstatusname, recordstatus', 'safe', 'on'=>'search'),
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
			'maritalstatusid' => 'ID',
			'maritalstatusname' => 'Marital Status ',
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
		$criteria->compare('maritalstatusid',$this->maritalstatusid);
		$criteria->compare('maritalstatusname',$this->maritalstatusname,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

  /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
    $criteria->condition='recordstatus=1';
		$criteria->compare('maritalstatusid',$this->maritalstatusid);
		$criteria->compare('maritalstatusname',$this->maritalstatusname,true);

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
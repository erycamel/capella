<?php

/**
 * This is the model class for table "lockerkey".
 *
 * The followings are the available columns in table 'lockerkey':
 * @property integer $lockerkeyid
 * @property string $keynum
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Lockercheck[] $lockerchecks
 * @property Lockerreturn[] $lockerreturns
 * @property Lockertake[] $lockertakes
 */
class Lockerkey extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lockerkey the static model class
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
		return 'lockerkey';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keynum, recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('keynum', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lockerkeyid, keynum, recordstatus', 'safe', 'on'=>'search'),
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
			'lockerchecks' => array(self::HAS_MANY, 'Lockercheck', 'lockerkeyid'),
			'lockerreturns' => array(self::HAS_MANY, 'Lockerreturn', 'lockerkeyid'),
			'lockertakes' => array(self::HAS_MANY, 'Lockertake', 'lockerkeyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lockerkeyid' => 'ID',
			'keynum' => 'Key No',
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
		$criteria->compare('lockerkeyid',$this->lockerkeyid);
		$criteria->compare('keynum',$this->keynum,true);

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
		$criteria->compare('lockerkeyid',$this->lockerkeyid);
		$criteria->compare('keynum',$this->keynum,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

	public function searchkeyempty()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
    $criteria->condition='t.lockerkeyid not in (select lockerkeyid from employeekey a where a.recordstatus=1)';
		$criteria->compare('t.lockerkeyid',$this->lockerkeyid);
		$criteria->compare('t.keynum',$this->keynum,true);

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
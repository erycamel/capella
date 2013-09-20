<?php

/**
 * This is the model class for table "judgerule".
 *
 * The followings are the available columns in table 'judgerule':
 * @property integer $judgeruleid
 * @property integer $statin
 * @property integer $statout
 * @property string $statjudge
 */
class Judgerule extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Judgerule the static model class
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
		return 'judgerule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('statin, statout, statjudge', 'required'),
			array('statin, statout', 'numerical', 'integerOnly'=>true),
			array('statjudge', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('judgeruleid, statin, statout, statjudge', 'safe', 'on'=>'search'),
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
      'statind' => array(self::BELONGS_TO, 'Absstatus', 'statin'),
      'statoutd' => array(self::BELONGS_TO, 'Absstatus', 'statout'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'judgeruleid' => 'ID',
			'statin' => 'Status In',
			'statout' => 'Status Out',
			'statjudge' => 'Status Judge',
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
    $criteria->with=array('statind','statoutd');
		$criteria->compare('judgeruleid',$this->judgeruleid);
		$criteria->compare('statind.shortstat',$this->statin,true);
		$criteria->compare('statoutd.shortstat',$this->statout,true);
		$criteria->compare('statjudge',$this->statjudge,true);

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
    $criteria->with=array('statind','statoutd');
		$criteria->compare('judgeruleid',$this->judgeruleid);
		$criteria->compare('statind.shortstat',$this->statin,true);
		$criteria->compare('statoutd.shortstat',$this->statout,true);
		$criteria->compare('statjudge',$this->statjudge,true);

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
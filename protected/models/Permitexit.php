<?php

/**
 * This is the model class for table "permitexit".
 *
 * The followings are the available columns in table 'permitexit':
 * @property integer $permitexitid
 * @property string $permitexitname
 * @property integer $recordstatus
 */
class Permitexit extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Permitexit the static model class
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
		return 'permitexit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permitexitname, recordstatus', 'required'),
			array('recordstatus,snroid', 'numerical', 'integerOnly'=>true),
			array('permitexitname', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permitexitid, permitexitname, recordstatus', 'safe', 'on'=>'search'),
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
			'snro' => array(self::BELONGS_TO, 'Snro', 'snroid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permitexitid' => 'ID',
			'permitexitname' => 'Permit Exit',
			'snroid' => 'Snro',
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

		$criteria->compare('permitexitid',$this->permitexitid);
		$criteria->compare('permitexitname',$this->permitexitname,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition='recordstatus=1';
		$criteria->compare('permitexitid',$this->permitexitid);
		$criteria->compare('permitexitname',$this->permitexitname,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
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
<?php

/**
 * This is the model class for table "prodtranstype".
 *
 * The followings are the available columns in table 'prodtranstype':
 * @property integer $prodtranstypeid
 * @property string $prodtranscode
 * @property string $description
 * @property string $modulename
 * @property integer $recordstatus
 */
class Prodtranstype extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Prodtranstype the static model class
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
		return 'prodtranstype';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prodtranscode, description, modulename, recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('prodtranscode', 'length', 'max'=>5),
			array('description, modulename', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prodtranstypeid, prodtranscode, description, modulename, recordstatus', 'safe', 'on'=>'search'),
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
			'prodtranstypeid' => 'ID',
			'prodtranscode' => 'Transaction Code',
			'description' => 'Description',
			'modulename' => 'Module ',
			'snroid'=>'Snro',
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

		$criteria->compare('prodtranstypeid',$this->prodtranstypeid);
		$criteria->compare('prodtranscode',$this->prodtranscode,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('modulename',$this->modulename,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}

	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->conditon='recordstatus=1';
		$criteria->compare('prodtranstypeid',$this->prodtranstypeid);
		$criteria->compare('prodtranscode',$this->prodtranscode,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('modulename',$this->modulename,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
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
<?php

/**
 * This is the model class for table "servicetype".
 *
 * The followings are the available columns in table 'servicetype':
 * @property integer $servicetypeid
 * @property integer $sosnroid
 * @property string $servicetypename
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property City[] $cities
 * @property Country $sosnro
 */
class Servicetype extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Servicetype the static model class
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
		return 'servicetype';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sosnroid, servicetypename, srfsnroid, recordstatus', 'required'),
			array('sosnroid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('servicetypename', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('servicetypeid, sosnroid, servicetypename, recordstatus', 'safe', 'on'=>'search'),
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
			'sosnro' => array(self::BELONGS_TO, 'Snro', 'sosnroid'),
			'srfsnro' => array(self::BELONGS_TO, 'Snro', 'srfsnroid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'servicetypeid' => 'ID',
			'sosnroid' => 'SO SNRO',
			'srfsnroid' => 'SRF SNRO',
			'servicetypename' => 'Service Type ',
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
    $criteria->with=array('sosnro','srfsnro');
		$criteria->compare('t.servicetypeid',$this->servicetypeid);
		$criteria->compare('sosnro.formatdoc',$this->sosnroid,true);
		$criteria->compare('srfsnro.formatdoc',$this->srfsnroid,true);
		$criteria->compare('t.servicetypename',$this->servicetypename,true);

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
    $criteria->with=array('sosnro','srfsnro');
    $criteria->condition='t.recordstatus=1';
		$criteria->compare('t.servicetypeid',$this->servicetypeid);
		$criteria->compare('sosnro.formatdoc',$this->sosnroid);
		$criteria->compare('srfsnro.formatdoc',$this->srfsnroid);
		$criteria->compare('t.servicetypename',$this->servicetypename,true);

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
<?php

/**
 * This is the model class for table "sourceformat".
 *
 * The followings are the available columns in table 'sourceformat':
 * @property integer $sourceformatid
 * @property integer $vouchersourceid
 * @property string $format
 * @property integer $isrequest
 * @property integer $recordstatus
 */
class Sourceformat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Sourceformat the static model class
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
		return 'sourceformat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vouchersourceid, format', 'required'),
			array('vouchersourceid, isrequest, recordstatus', 'numerical', 'integerOnly'=>true),
			array('format', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sourceformatid, vouchersourceid, format, isrequest, recordstatus', 'safe', 'on'=>'search'),
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
			'vouchersource' => array(self::BELONGS_TO, 'Vouchersource', 'vouchersourceid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sourceformatid' => 'ID',
			'vouchersourceid' => 'Voucher Source',
			'format' => 'Format',
			'isrequest' => 'Is Request',
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
    $criteria->with=array('vouchersource');
		$criteria->compare('sourceformatid',$this->sourceformatid);
		$criteria->compare('vouchersource.description',$this->vouchersourceid,true);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('isrequest',$this->isrequest);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
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
    $criteria->with=array('vouchersource');
    $criteria->condition='t.recordstatus=1';
		$criteria->compare('sourceformatid',$this->sourceformatid);
		$criteria->compare('vouchersource.description',$this->vouchersourceid,true);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('isrequest',$this->isrequest);

		return new CActiveDataProvider(get_class($this), array(
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
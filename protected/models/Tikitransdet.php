<?php

/**
 * This is the model class for table "tikitransdet".
 *
 * The followings are the available columns in table 'tikitransdet':
 * @property integer $tikitransdetid
 * @property integer $airwaybillno
 * @property string $description
 * @property integer $pieces
 * @property string $weight
 * @property integer $length
 * @property string $width
 * @property string $height
 * @property string $weightvol
 * @property integer $recordstatus
 */
class Tikitransdet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tikitransdet the static model class
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
		return 'tikitransdet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('airwaybillno, recordstatus', 'required'),
			array('airwaybillno, pieces, length, recordstatus', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>50),
			array('weight, width, height, weightvol', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tikitransdetid, airwaybillno, description, pieces, weight, length, width, height, weightvol, recordstatus', 'safe', 'on'=>'search'),
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
			'tikitransdetid' => 'ID',
			'airwaybillno' => 'Airway Bill No',
			'description' => 'Description',
			'pieces' => 'Pieces',
			'weight' => 'Weight',
			'length' => 'Length',
			'width' => 'Width',
			'height' => 'Height',
			'weightvol' => 'Weight Vol',
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

		$criteria->compare('tikitransdetid',$this->tikitransdetid);
		$criteria->compare('airwaybillno',$this->airwaybillno);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('pieces',$this->pieces);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('length',$this->length);
		$criteria->compare('width',$this->width,true);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('weightvol',$this->weightvol,true);
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
		$criteria->condition='recordstatus=1';
		$criteria->compare('tikitransdetid',$this->tikitransdetid);
		$criteria->compare('airwaybillno',$this->airwaybillno);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('pieces',$this->pieces);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('length',$this->length);
		$criteria->compare('width',$this->width,true);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('weightvol',$this->weightvol,true);
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
            'application.behaviors.ActiveRecordLogableBehavior',
    );
  }
}
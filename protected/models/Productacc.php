<?php

/**
 * This is the model class for table "productacc".
 *
 * The followings are the available columns in table 'productacc':
 * @property integer $productaccid
 * @property integer $productid
 * @property integer $isasset
 * @property integer $isbuilding
 *
 * The followings are the available model relations:
 * @property Product $product
 */
class Productacc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Productacc the static model class
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
		return 'productacc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('productid', 'required'),
			array('productid, isasset, isbuilding, recordstatus', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('productaccid, productid, isasset, isbuilding, recordstatus', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'productaccid' => 'ID',
			'productid' => 'Product',
			'isasset' => 'Is Asset ?',
			'isbuilding' => 'Is Building ?',
			'recordstatus' => 'Record Status'
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

		$criteria->compare('productaccid',$this->productaccid);
		$criteria->compare('productid',$this->productid);
		$criteria->compare('isasset',$this->isasset);
		$criteria->compare('isbuilding',$this->isbuilding);
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
        $criteria->with=array('product');
		$criteria->condition='recordstatus=1';
		$criteria->compare('productaccid',$this->productaccid);
		$criteria->compare('product.productname',$this->productid,true);
		$criteria->compare('isasset',$this->isasset);
		$criteria->compare('isbuilding',$this->isbuilding);
		$criteria->compare('t.recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    

	public function behaviors()
  {
    return array(
        // Classproductname => path to Class
        'ActiveRecordLogableBehavior'=>
            'application.behaviors.ActiveRecordLogableBehavior'
    );
  }
}
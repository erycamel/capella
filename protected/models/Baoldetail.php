<?php

/**
 * This is the model class for table "baoldetail".
 *
 * The followings are the available columns in table 'baoldetail':
 * @property integer $baoldetailid
 * @property integer $baolid
 * @property integer $projectid
 * @property double $poqty
 * @property integer $unitofmeasureid
 * @property string $delvdate
 * @property double $netprice
 * @property integer $currencyid
 * @property integer $slocid
 * @property integer $taxid
 *
 * The followings are the available model relations:
 * @property Poheader $baol
 * @property Product $product
 * @property Unitofmeasure $unitofmeasure
 * @property Currency $currency
 * @property Sloc $sloc
 * @property Tax $tax
 */
class Baoldetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Baoldetail the static model class
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
		return 'baoldetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('baolid, projectid ', 'required'),
			array('baolid, projectid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('baoldetailid, baolid, projectid', 'safe', 'on'=>'search'),
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
			'baol' => array(self::BELONGS_TO, 'Baol', 'baolid'),
			'project' => array(self::BELONGS_TO, 'Project', 'projectid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'baoldetailid' => 'ID',
			'baolid' => 'Header',
			'projectid' => 'SRF',
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
		$criteria->with=array('baol','project');
        if (isset($_GET['Baoldetail'])) {
			$criteria->condition='t.baolid='.$_GET['Baoldetail']['baolid'];
		} else {
			$criteria->condition='t.baolid=0';
		}
		$criteria->compare('baoldetailid',$this->baoldetailid);
		$criteria->compare('baol.baolid',$this->baolid,true);
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
<?php

/**
 * This is the model class for table "sptwil".
 *
 * The followings are the available columns in table 'sptwil':
 * @property integer $sptwilid
 * @property integer $kelurahanid
 * @property string $kdwil
 * @property string $kpp
 */
class Sptwil extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Sptwil the static model class
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
		return 'sptwil';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelurahanid, kdwil, kpp', 'required'),
			array('kelurahanid', 'numerical', 'integerOnly'=>true),
			array('kdwil', 'length', 'max'=>15),
			array('kpp', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sptwilid, kelurahanid, kdwil, kpp', 'safe', 'on'=>'search'),
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
		        'kelurahan' => array(self::BELONGS_TO, 'Kelurahan', 'kelurahanid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sptwilid' => 'ID',
			'kelurahanid' => 'Subdistrict',
			'kdwil' => 'Kdwil',
			'kpp' => 'Kpp',
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
		$criteria->with=array('kelurahan');
		$criteria->compare('sptwilid',$this->sptwilid);
		$criteria->compare('kelurahan.kelurahanname',$this->kelurahanid,true);
		$criteria->compare('kdwil',$this->kdwil,true);
		$criteria->compare('kpp',$this->kpp,true);

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
            'application.behaviors.ActiveRecordLogableBehavior',
    );
  }
}
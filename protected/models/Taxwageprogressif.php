<?php

/**
 * This is the model class for table "taxwageprogressif".
 *
 * The followings are the available columns in table 'taxwageprogressif':
 * @property integer $taxwageprogressifid
 * @property string $taxwageprogressifname
 * @property integer $recordstatus
 */
class Taxwageprogressif extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Taxwageprogressif the static model class
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
		return 'taxwageprogressif';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, minvalue,maxvalue,valuepercent', 'required'),
			array('description', 'length', 'max'=>50),
            array('minvalue,maxvalue,valuepercent,recordstatus', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('taxwageprogressifid, description, recordstatus', 'safe', 'on'=>'search'),
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
			'taxwageprogressifid' => 'ID',
			'description' => 'Description',
            'minvalue'=>'Min Value',
            'maxvalue'=>'Max Value',
            'valuepercent'=>'Value (Percent)',
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
		$criteria->compare('taxwageprogressifid',$this->taxwageprogressifid);
		$criteria->compare('description',$this->description,true);

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
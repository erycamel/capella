<?php

/**
 * This is the model class for table "employeefacilitydet".
 *
 * The followings are the available columns in table 'employeefacilitydet':
 * @property string $employeefacilitydetid
 * @property string $employeefacilityid
 * @property string $facilitytypeid
 * @property string $startdate
 * @property string $enddate
 *
 * The followings are the available model relations:
 * @property Employeefacility $employeefacility
 * @property Facilitytype $facilitytype
 */
class Employeefacilitydet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Employeefacilitydet the static model class
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
		return 'employeefacilitydet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeefacilityid, facilitytypeid, startdate, enddate', 'required'),
			array('employeefacilityid, facilitytypeid', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeefacilitydetid, employeefacilityid, facilitytypeid, startdate, enddate', 'safe', 'on'=>'search'),
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
			'employeefacility' => array(self::BELONGS_TO, 'Employeefacility', 'employeefacilityid'),
			'facilitytype' => array(self::BELONGS_TO, 'Facilitytype', 'facilitytypeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeefacilitydetid' => 'ID',
			'employeefacilityid' => 'Employeefacilityid',
			'facilitytypeid' => 'Facility Type',
			'startdate' => 'Start Date',
			'enddate' => 'End Date',
		);
	}
  
  public function beforeSave()
    {
      $this->startdate = date(Yii::app()->params['datetodb'], strtotime($this->startdate));
      $this->enddate = date(Yii::app()->params['datetodb'], strtotime($this->enddate));
      return parent::beforeSave();
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
if (isset($_GET['Employeefacilitydet'])) {
$model=new Employeefacilitydet('search');
$model->attributes = $_GET['Employeefacilitydet'];
$criteria->condition='t.employeefacilityid='.$model->employeefacilityid;
} else {
$criteria->condition='t.employeefacilityid=0';
}
		$criteria->compare('employeefacilitydetid',$this->employeefacilitydetid,true);
		$criteria->compare('t.employeefacilityid',$this->employeefacilityid,true);
		$criteria->compare('t.facilitytypeid',$this->facilitytypeid,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
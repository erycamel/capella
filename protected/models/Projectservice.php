<?php

/**
 * This is the model class for table "projectservice".
 *
 * The followings are the available columns in table 'projectservice':
 * @property string $projectserviceid
 * @property string $projectid
 *
 * The followings are the available model relations:
 * @property Project $project
 */
class Projectservice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Projectservice the static model class
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
		return 'projectservice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projectid', 'required'),
			array('requestforid,contracttermid', 'numerical'),
			array('dateofdelivery,dateofdeliverydevice,estimatedelivery,installdate,onlinedate', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('projectserviceid, projectid, description,dateofdelivery,dateofdeliverydevice,requestforid,contracttermid', 'safe', 'on'=>'search'),
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
			'project' => array(self::BELONGS_TO, 'Project', 'projectid'),
			'contractterm' => array(self::BELONGS_TO, 'Contractterm', 'contracttermid'),
			'requestfor' => array(self::BELONGS_TO, 'Requestfor', 'requestforid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'projectserviceid' => 'ID',
			'projectid' => 'Header',
			'dateofdelivery' => 'Date of Delivery',
			'dateofdeliverydevice'=>'Date of Delivery Device',
			'requestforid'=>'Request For',
			'estimatedelivery'=>'Estimate Delivery',
			'installdate'=>'Install Date',
			'onlinedate'=>'Online Date',
			'contracttermid'=>'Contract Term'
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
        $criteria->with=array('project','contractterm','requestfor');
if (isset($_GET['Projectservice'])) {
$model=new Projectservice('search');
$model->attributes = $_GET['Projectservice'];
$criteria->condition='t.projectid='.$model->projectid;
} else {
$criteria->condition='t.projectid=0';
}
		$criteria->compare('projectserviceid',$this->projectserviceid,true);
		$criteria->compare('t.projectid',$this->projectid,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave()
    {
      $this->dateofdelivery = date(Yii::app()->params['datetodb'], strtotime($this->dateofdelivery));
      $this->dateofdeliverydevice = date(Yii::app()->params['datetodb'], strtotime($this->dateofdeliverydevice));
      $this->estimatedelivery = date(Yii::app()->params['datetodb'], strtotime($this->estimatedelivery));
      $this->onlinedate = date(Yii::app()->params['datetodb'], strtotime($this->onlinedate));
      $this->installdate = date(Yii::app()->params['datetodb'], strtotime($this->installdate));
      return parent::beforeSave();
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
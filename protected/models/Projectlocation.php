<?php

/**
 * This is the model class for table "projectlocation".
 *
 * The followings are the available columns in table 'projectlocation':
 * @property string $projectlocationid
 * @property string $projectid
 *
 * The followings are the available model relations:
 * @property Project $project
 */
class Projectlocation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Projectlocation the static model class
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
		return 'projectlocation';
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
			array('originaddress,destaddress,originbuilding,destbuilding,originid,destid,origincityid,destcityid', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('projectlocationid, projectid, originaddress,destaddress,originbuilding,destbuilding,originid,destid,origincityid,destcityid', 'safe', 'on'=>'search'),
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
			'origin' => array(self::BELONGS_TO, 'Addressbook', 'originid'),
			'dest' => array(self::BELONGS_TO, 'Addressbook', 'destid'),
			'origincity' => array(self::BELONGS_TO, 'City', 'origincityid'),
			'destcity' => array(self::BELONGS_TO, 'City', 'destcityid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'projectlocationid' => 'ID',
			'projectid' => 'Header',
			'originid' => 'Original Company',
			'destid'=>'Destination Company',
			'origincityid'=>'Original City',
			'destcityid'=>'Destination City',
			'originaddress'=>'Original Address',
			'destaddress'=>'Destination Address',
			'originbuilding'=>'Original Building',
			'destbuilding'=>'Destination Building'
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
        $criteria->with=array('project','origin','dest','origincity','destcity');
if (isset($_GET['Projectlocation'])) {
$model=new Projectlocation('search');
$model->attributes = $_GET['Projectlocation'];
$criteria->condition='t.projectid='.$model->projectid;
} else {
$criteria->condition='t.projectid=0';
}
		$criteria->compare('projectlocationid',$this->projectlocationid,true);
		$criteria->compare('t.projectid',$this->projectid,true);
		$criteria->compare('origin.fullname',$this->originid,true);
		$criteria->compare('dest.fullname',$this->destid,true);
		$criteria->compare('origincity.cityname',$this->origincityid,true);
		$criteria->compare('destcity.cityname',$this->destcityid,true);
		$criteria->compare('destaddress',$this->destaddress,true);
		$criteria->compare('originaddress',$this->originaddress,true);		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchw()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('project','origin','dest','origincity','destcity');
		$criteria->compare('projectlocationid',$this->projectlocationid,true);
		$criteria->compare('project.serviceno',$this->projectid,true);
		$criteria->compare('origin.fullname',$this->originid,true);
		$criteria->compare('dest.fullname',$this->destid,true);
		$criteria->compare('origincity.cityname',$this->origincityid,true);
		$criteria->compare('destcity.cityname',$this->destcityid,true);
		$criteria->compare('destaddress',$this->destaddress,true);
		$criteria->compare('originaddress',$this->originaddress,true);
		return new CActiveDataProvider($this, array(
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
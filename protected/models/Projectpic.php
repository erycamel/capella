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
class Projectpic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Projectpic the static model class
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
		return 'projectpic';
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
			array('picname,picemail,picdept,pictelp,picfunction', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('projectpicid, projectid, picname,picemail,picdept,pictelp,picfunction', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'projectpicid' => 'ID',
			'projectid' => 'Header',
			'picname' => 'PIC Name',
			'picemail'=>'PIC Email',
			'picdept'=>'PIC Department',
			'pictelp'=>'PIC Phone No',
			'picfunction'=>'PIC Function',
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
        $criteria->with=array('project');
if (isset($_GET['Projectpic'])) {
$model=new Projectpic('search');
$model->attributes = $_GET['Projectpic'];
$criteria->condition='t.projectid='.$model->projectid;
} else {
$criteria->condition='t.projectid=0';
}
		$criteria->compare('projectpicid',$this->projectpicid,true);
		$criteria->compare('t.projectid',$this->projectid,true);
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
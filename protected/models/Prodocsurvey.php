<?php

/**
 * This is the model class for table "prodocsurvey".
 *
 * The followings are the available columns in table 'prodocsurvey':
 * @property string $prodocsurveyid
 * @property string $documentname
 * @property string $filename
 * @property string $uploaddate
 * @property integer $recordstatus
 * @property string $statusdate
 * @property string $projectid
 */
class Prodocsurvey extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Prodocsurvey the static model class
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
		return 'prodocsurvey';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('documentname,filename', 'length', 'max'=>50),
			array('projectid', 'length', 'max'=>10),
			array('uploaddate, statusdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prodocsurveyid, documentname, filename, uploaddate, recordstatus, statusdate, projectid', 'safe', 'on'=>'search'),
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
			'prodocsurveyid' => 'Prodocsurveyid',
			'documentname' => 'Document ',
			'filename' => 'Filename',
			'uploaddate' => 'Upload Date',
			'recordstatus' => 'Record Status',
			'statusdate' => 'Status Date',
			'projectid' => 'Project',
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
                if (isset($_GET['Prodocsurvey'])) {
$model=new Prodocsurvey('search');
$model->attributes = $_GET['Prodocsurvey'];
$criteria->condition='t.projectid='.$model->projectid;
} else {
$criteria->condition='t.projectid=0';
}
		$criteria->compare('prodocsurveyid',$this->prodocsurveyid,true);
		$criteria->compare('documentname',$this->documentname,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('uploaddate',$this->uploaddate,true);
		$criteria->compare('recordstatus',$this->recordstatus);
		$criteria->compare('statusdate',$this->statusdate,true);
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
            'application.behaviors.ActiveRecordLogableBehavior'
    );
  }
}
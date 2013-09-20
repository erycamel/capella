<?php

/**
 * This is the model class for table "troubleticket".
 *
 * The followings are the available columns in table 'troubleticket':
 * @property integer $troubleticketid
 * @property string $shortstat
 * @property string $longstat
 * @property integer $isin
 * @property integer $priority
 * @property integer $recordstatus
 */
class Troubleticketdetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Troubleticket the static model class
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
		return 'troubleticketdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('useraccessid,description,startdate,enddate,woino,filename,troubleticketstatusid', 'length'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('useraccessid,description,startdate,enddate,woino,filename,troubleticketstatusid', 'safe', 'on'=>'search'),
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
			'troubleticket' => array(self::BELONGS_TO, 'Troubleticket', 'troubleticketid'),
			'userku' => array(self::BELONGS_TO, 'Useraccess', 'useraccessid'),
			'troubleticketstatus' => array(self::BELONGS_TO, 'Troubleticketstatus', 'troubleticketstatusid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'troubleticketdetailid' => 'ID',
			'troubleticketid' => 'Trouble Ticket No',
			'description' => 'Description',
			'useraccessid' => 'Assign To',
			'startdate' => 'Start Date',
			'enddate'=> 'End Date',
			'woino' => 'WOI No',
			'filename' => 'File Name',
			'troubleticketstatusid'=>'Trouble Ticket Status',
			'uploaddate' => 'Upload Date'
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
		$criteria->with=array('troubleticket','troubleticketstatus');
		if (isset($_GET['Troubleticketdetail'])) {
			$criteria->condition='t.troubleticketid ='.$_GET['Troubleticketdetail']['troubleticketid'];
		} else {
			$criteria->condition='t.troubleticketid=0';
		}
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
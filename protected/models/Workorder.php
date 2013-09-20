<?php

/**
 * This is the model class for table "workorder".
 *
 * The followings are the available columns in table 'workorder':
 * @property integer $workorderid
 * @property integer $productid
 * @property string $workstartdate
 * @property string $worktargetdate
 * @property integer $workorderstaffid
 * @property string $description
 * @property string $workorderstatus
 * @property integer $eventrequestid
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Workorderstaff $workorderstaff
 * @property Eventrequest $eventrequest
 * @property Product $product
 */
class Workorder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Workorder the static model class
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
		return 'workorder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workstartdate, worktargetdate, description, recordstatus', 'required'),
			array('productid, workorderstaffid, eventrequestid, workorderstatusid,recordstatus', 'numerical', 'integerOnly'=>true),
			array('workorderstatus', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('workorderid, productid, workstartdate, worktargetdate, workorderstaffid, description, workorderstatusid, eventrequestid, recordstatus', 'safe', 'on'=>'search'),
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
			'workorderstaff' => array(self::BELONGS_TO, 'Workorderstaff', 'workorderstaffid'),
			'eventrequest' => array(self::BELONGS_TO, 'Eventrequest', 'eventrequestid'),
			'product' => array(self::BELONGS_TO, 'Product', 'productid'),
			'workorderstatus' => array(self::BELONGS_TO, 'Workorderstatus', 'workorderstatusid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'workorderid' => 'ID',
			'productid' => 'Product',
			'workstartdate' => 'Start Date',
			'worktargetdate' => 'Target Date',
			'workorderstaffid' => 'Staff',
			'description' => 'Description',
			'workorderstatusid' => 'Work Order Status',
			'eventrequestid' => 'Event Request',
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

		$criteria->compare('workorderid',$this->workorderid);
		$criteria->compare('productid',$this->productid);
		$criteria->compare('workstartdate',$this->workstartdate,true);
		$criteria->compare('worktargetdate',$this->worktargetdate,true);
		$criteria->compare('workorderstaffid',$this->workorderstaffid);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('workorderstatusid',$this->workorderstatusid,true);
		$criteria->compare('eventrequestid',$this->eventrequestid);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
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
            'application.behaviors.ActiveRecordLogableBehavior'
    );
  }
}
<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 */
class Project extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Project the static model class
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
		return 'project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('soheaderid,recordstatus', 'numerical', 'integerOnly'=>true),
			array('projectnote,priceotr,priceotc', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('projectid, projectno, soheaderid,
              recordstatus,projectnote', 'safe', 'on'=>'search'),
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
			'soheader' => array(self::BELONGS_TO, 'Soheader', 'soheaderid'),
			'projectlocation' => array(self::HAS_MANY, 'Projectlocation', 'projectid'),
			'projectnetwork' => array(self::HAS_MANY, 'Projectnetwork', 'projectid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'projectid' => 'ID',
			'projectno' => 'SRF No',
            'soheaderid' => 'Sales Order',
			'recordstatus' => 'Record Status',
            'projectnote'=>'Note',
			'serviceno'=>'Service No',
			'priceotr'=>'Price Recurring',
			'priceotc'=>'Price One Time',
			'onlinedate'=>'Online Date',
			'projectdate'=>'SRF Date',
		);
	}
	
	public function beforeSave()
    {
      $this->projectdate = date(Yii::app()->params['datetimetodb'], strtotime($this->projectdate));
      $this->onlinedate = date(Yii::app()->params['datetodb'], strtotime($this->onlinedate));
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
        $criteria->with=array('soheader');
		$criteria->compare('t.projectid',$this->projectid,true);
		$criteria->compare('projectno',$this->projectno,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);
		$criteria->compare('projectnote',$this->projectnote,true);
		$criteria->compare('soheader.addressbook.fullname',$this->soheaderid,true);
		$criteria->compare('soheader.sono',$this->soheaderid,true);

		return new CActiveDataProvider($this, array('pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
        public function searchwfstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('soheader','projectlocation');
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listproject') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('projectid',$this->projectid,true);
		$criteria->compare('projectno',$this->projectno,true);
		$criteria->compare('soheader.sono',$this->soheaderid,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);
		$criteria->compare('projectnote',$this->projectnote,true);
		$criteria->compare('soheader.sono',$this->soheaderid,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	

	public function searchsdstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('soheader');
$criteria->condition="t.projectno <> '' and t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listproject') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('t.projectid',$this->projectid,true);
		$criteria->compare('projectno',$this->projectno,true);
		$criteria->compare('soheader.sono',$this->soheaderid,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);
		$criteria->compare('projectnote',$this->projectnote,true);
		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
	public $dest_address;
	public $dest_customer;
	public $dest_ip_address;
	
	public function searchttstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('soheader');
$criteria->condition="t.projectno <> '' and t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listproject') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('t.projectid',$this->projectid,true);
		$criteria->compare('projectno',$this->projectno,true);
		$criteria->compare('soheader.sono',$this->soheaderid,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);
		$criteria->compare('projectnote',$this->projectnote,true);
		$criteria->compare('projectlocation.destaddress',$this->dest_address,true);
		$criteria->compare('projectlocation.destaddress',$this->dest_address,true);
		$criteria->compare('projectnetwork.destipaddress',$this->dest_ip_address,true);
        $criteria->with=array('soheader','projectlocation','projectnetwork');
		$criteria->together=true;
		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
	public function searchwfgstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('soheader');
		$criteria->condition="t.projectno <> '' and t.recordstatus = 10 and 
			t.projectid not in 
			(select projectid from baoldetail z 
				inner join baol y on y.baolid = z.baolid  
				where y.recordstatus = 2
			) zy ";
		$criteria->compare('projectid',$this->projectid,true);
		$criteria->compare('projectno',$this->projectno,true);
		$criteria->compare('soheader.sono',$this->soheaderid,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);
		$criteria->compare('projectnote',$this->projectnote,true);

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
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
class Troubleticket extends CActiveRecord
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
		return 'troubleticket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customername,unitkerja,phoneno,mobilephoneno,customeraddress,
			description,useraccessid,startdate,enddate,troubleticketstatusid', 'required'),
			array('troubleticketno,customername,unitkerja,phoneno,mobilephoneno,customeraddress,
			description,useraccessid,startdate,enddate,troubleticketstatusid,serviceno', 'length'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('troubleticketno,customername,unitkerja,phoneno,mobilephoneno,customeraddress,
			description,useraccessid,startdate,enddate,troubleticketstatusid,serviceno', 'safe', 'on'=>'search'),
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
			'troubleticketid' => 'ID',
			'troubleticketno' => 'Trouble Ticket No',
			'customername' => 'Person (orang yang melaporkan)',
			'unitkerja' => 'Branch (Unit Kerja)',
			'phoneno' => 'Phone No',
			'mobilephoneno' => 'Mobile Phone No',
			'customeraddress' => 'Customer Address',
			'description' => 'Description',
			'useraccessid' => 'Assign To',
			'serviceno' => 'Service No',
			'recordstatus' => 'Record Status',
			'troubleticketstatusid'=>'Status',
			'startdate'=>'Start DateTime',
			'enddate'=>'End DateTime'
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
		$criteria->with=array('userku','troubleticketstatus');
		$criteria->compare('troubleticketid',$this->troubleticketid);
		$criteria->compare('userku.username',$this->useraccessid,true);
		$criteria->compare('troubleticketno',$this->troubleticketno,true);
		$criteria->compare('phoneno',$this->phoneno,true);
		$criteria->compare('mobilephoneno',$this->mobilephoneno,true);
		$criteria->compare('customeraddress',$this->customeraddress,true);
		$criteria->compare('serviceno',$this->serviceno,true);
		$criteria->compare('customername',$this->customername,true);
		$criteria->compare('unitkerja',$this->unitkerja,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('troubleticketstatus.troublecode',$this->troubleticketstatusid,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('userku','troubleticketstatus');
		$criteria->condition="t.recordstatus > 0 and t.useraccessid in (select gm.menuvalueid from groupmenuauth gm
inner join menuauth ma on ma.menuauthid = gm.menuauthid
inner join groupaccess c on c.groupaccessid = gm.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(e.username)=upper('".Yii::app()->user->name."') and
upper(ma.menuobject) = upper('useraccess') and gm.groupaccessid = c.groupaccessid)";	
		$criteria->compare('troubleticketid',$this->troubleticketid);
		$criteria->compare('userku.username',$this->useraccessid,true);
		$criteria->compare('troubleticketno',$this->troubleticketno,true);
		$criteria->compare('phoneno',$this->phoneno,true);
		$criteria->compare('mobilephoneno',$this->mobilephoneno,true);
		$criteria->compare('customeraddress',$this->customeraddress,true);
		$criteria->compare('serviceno',$this->serviceno,true);
		$criteria->compare('customername',$this->customername,true);
		$criteria->compare('unitkerja',$this->unitkerja,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('troubleticketstatus.troublecode',$this->troubleticketstatusid,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
	        public function beforeSave()
    {
      $this->startdate = date(Yii::app()->params['datetimetodb'], strtotime($this->startdate));
      $this->enddate = date(Yii::app()->params['datetimetodb'], strtotime($this->enddate));
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
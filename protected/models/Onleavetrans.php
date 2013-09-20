<?php

/**
 * This is the model class for table "onleavetrans".
 *
 * The followings are the available columns in table 'onleavetrans':
 * @property integer $onleavetransid
 * @property string $onleavedate
 * @property integer $employeeid
 * @property integer $onleavetypeid
 * @property string $datefrom
 * @property string $dateto
 * @property string $reason
 * @property string $nodocument
 * @property integer $recordstatus
 */
class Onleavetrans extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Onleavetrans the static model class
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
		return 'onleavetrans';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('onleavedate, employeeid, onleavetypeid, datefrom, dateto, nodocument, recordstatus', 'required'),
			array('employeeid, onleavetypeid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('reason, nodocument', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('onleavetransid, onleavedate, employeeid, onleavetypeid, datefrom, dateto, reason, nodocument, recordstatus', 'safe', 'on'=>'search'),
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
			'onleavetype' => array(self::BELONGS_TO, 'Onleavetype', 'onleavetypeid'),
      'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'onleavetransid' => 'ID',
			'onleavedate' => 'Onleave Date',
			'employeeid' => 'Employee',
			'onleavetypeid' => 'Onleave Type',
			'datefrom' => 'Date From',
			'dateto' => 'Date To',
			'reason' => 'Reason',
			'nodocument' => 'No Document',
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
$criteria->with=array('employee','onleavetype');
		$criteria->compare('onleavetransid',$this->onleavetransid);
		$criteria->compare('onleavedate',$this->onleavedate,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('onleavetypeid',$this->onleavetypeid);
		$criteria->compare('datefrom',$this->datefrom,true);
		$criteria->compare('dateto',$this->dateto,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('nodocument',$this->nodocument,true);
		$criteria->compare('recordstatus',$this->recordstatus);

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
$criteria->with=array('employee','onleavetype');
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listonleavetrans') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('onleavetransid',$this->onleavetransid);
		$criteria->compare('onleavedate',$this->onleavedate,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('onleavetypeid',$this->onleavetypeid);
		$criteria->compare('datefrom',$this->datefrom,true);
		$criteria->compare('dateto',$this->dateto,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('nodocument',$this->nodocument,true);
		$criteria->compare('recordstatus',$this->recordstatus);

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
            'application.behaviors.ActiveRecordLogableBehavior'
    );
  }
}
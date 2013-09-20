<?php

/**
 * This is the model class for table "permitexittrans".
 *
 * The followings are the available columns in table 'permitexittrans':
 * @property integer $permitexittransid
 * @property string $permitexitdate
 * @property integer $employeeid
 * @property integer $permitexitid
 * @property string $nodocument
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Permitexit $permitexit
 * @property Employee $employee
 */
class Permitexittrans extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Permitexittrans the static model class
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
		return 'permitexittrans';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permitexitdate, employeeid, permitexitid, nodocument, recordstatus', 'required'),
			array('employeeid, permitexitid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('nodocument', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permitexittransid, permitexitdate, employeeid, permitexitid, nodocument, recordstatus', 'safe', 'on'=>'search'),
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
			'permitexit' => array(self::BELONGS_TO, 'Permitexit', 'permitexitid'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permitexittransid' => 'ID',
			'permitexitdate' => 'Permit Exit Date',
			'employeeid' => 'Employee',
			'permitexitid' => 'Permit Exit',
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
$criteria->with=array('employee','permitexit');
		$criteria->compare('permitexittransid',$this->permitexittransid);
		$criteria->compare('permitexitdate',$this->permitexitdate,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('permitexit.permitexitname',$this->permitexitid,true);
		$criteria->compare('nodocument',$this->nodocument,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}

	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('employee','permitexit');
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listpermitexittrans') and upper(e.username)=upper('".Yii::app()->user->name."'))";      
		$criteria->compare('permitexittransid',$this->permitexittransid);
		$criteria->compare('permitexitdate',$this->permitexitdate,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('permitexit.permitexitname',$this->permitexitid,true);
		$criteria->compare('nodocument',$this->nodocument,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
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
<?php

/**
 * This is the model class for table "sicktrans".
 *
 * The followings are the available columns in table 'sicktrans':
 * @property integer $sicktransid
 * @property string $sickdate
 * @property integer $employeeid
 * @property integer $hospitalid
 * @property string $doctorname
 * @property string $doctordatefrom
 * @property string $doctordateto
 * @property string $takedatefrom
 * @property string $takedateto
 * @property string $diagnosa
 * @property string $nodocument
 * @property integer $recordstatus
 */
class Sicktrans extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Sicktrans the static model class
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
		return 'sicktrans';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sickdate, employeeid, takedatefrom, takedateto', 'required'),
			array('employeeid, hospitalid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('doctorname, diagnosa, nodocument', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sicktransid, sickdate, employeeid, hospitalid, doctorname, takedatefrom, takedateto, diagnosa, nodocument, recordstatus', 'safe', 'on'=>'search'),
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
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
			'hospital' => array(self::BELONGS_TO, 'Hospital', 'hospitalid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sicktransid' => 'ID',
			'sickdate' => 'Sick Date',
			'employeeid' => 'Employee',
			'hospitalid' => 'Hospital',
			'doctorname' => 'Doctor ',
			'takedatefrom' => 'Take Date From',
			'takedateto' => 'Take Date To',
			'diagnosa' => 'Diagnose',
			'nodocument' => 'Document No',
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
      $criteria->order = 'sicktransid desc';
		$criteria->compare('sicktransid',$this->sicktransid);
		$criteria->compare('sickdate',$this->sickdate,true);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('hospitalid',$this->hospitalid);
		$criteria->compare('doctorname',$this->doctorname,true);
		$criteria->compare('takedatefrom',$this->takedatefrom,true);
		$criteria->compare('takedateto',$this->takedateto,true);
		$criteria->compare('diagnosa',$this->diagnosa,true);
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
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listsicktrans') and upper(e.username)=upper('".Yii::app()->user->name."'))";
      $criteria->order = 'sicktransid desc';
		$criteria->compare('sicktransid',$this->sicktransid);
		$criteria->compare('sickdate',$this->sickdate,true);
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('hospitalid',$this->hospitalid);
		$criteria->compare('doctorname',$this->doctorname,true);
		$criteria->compare('takedatefrom',$this->takedatefrom,true);
		$criteria->compare('takedateto',$this->takedateto,true);
		$criteria->compare('diagnosa',$this->diagnosa,true);
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
<?php

/**
 * This is the model class for table "genjournal".
 *
 * The followings are the available columns in table 'genjournal':
 * @property integer $genjournalid
 * @property string $pocno
 * @property string $journaldate
 * @property string $journalnote
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Journaldetail[] $journaldetails
 */
class Pocheader extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Genjournal the static model class
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
		return 'pocheader';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recordstatus', 'required'),
			array('recordstatus,projecttypeid', 'numerical', 'integerOnly'=>true),
			array('pocno,sono,woino,contractno,piccust,phoneno', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pocheaderid, pocno, pocdate,postdate, recordstatus,sono,woino,contractno', 'safe', 'on'=>'search'),
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
			'pocdetail' => array(self::HAS_MANY, 'Pocdetail', 'pocheaderid'),
      'customer' => array(self::BELONGS_TO, 'Customer', 'addressbookid'),
      'projecttype' => array(self::BELONGS_TO, 'Projecttype', 'projecttypeid'),
		);
	}

        public function beforeSave() {
    if ($this->isNewRecord) {
        $this->postdate = new CDbExpression('NOW()');
    }
    return parent::beforeSave();
}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pocheaderid' => 'ID',
			'pocno' => 'POC No',
			'pocdate' => 'POC Date',
			'postdate' => 'Post Date',
			'addressbookid'=>'Customer',
			'recordstatus' => 'Record Status',
            'sono'=>'Sales Order',
            'contractno'=>'Contract No',
            'woino'=>'Work Order Internal',
            'piccust'=>'Project Team Leader',
            'phoneno'=>'Phone No',
            'projecttypeid'=>'Project Type'
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
$criteria->with=array('customer','projecttype');
		$criteria->compare('pocheaderid',$this->pocheaderid);
		$criteria->compare('pocno',$this->pocno,true);
		$criteria->compare('sono',$this->sono,true);
		$criteria->compare('contractno',$this->contractno,true);
		$criteria->compare('woino',$this->woino,true);
		$criteria->compare('piccust',$this->piccust,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('projecttype.description',$this->projecttypeid,true);
		$criteria->compare('phoneno',$this->phoneno,true);
		$criteria->compare('pocdate',$this->pocdate,true);
		$criteria->compare('postdate',$this->postdate,true);
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
		$criteria->condition='recordstatus=1';
$criteria->with=array('customer','projecttype');
		$criteria->compare('pocheaderid',$this->pocheaderid);
		$criteria->compare('pocno',$this->pocno,true);
		$criteria->compare('sono',$this->sono,true);
		$criteria->compare('contractno',$this->contractno,true);
		$criteria->compare('woino',$this->woino,true);
		$criteria->compare('piccust',$this->piccust,true);
		$criteria->compare('phoneno',$this->phoneno,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('projecttype.description',$this->projecttypeid,true);
		$criteria->compare('pocdate',$this->pocdate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
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
$criteria->with=array('customer','projecttype');
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listpoc') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('pocheaderid',$this->pocheaderid);
		$criteria->compare('pocno',$this->pocno,true);
		$criteria->compare('sono',$this->sono,true);
		$criteria->compare('contractno',$this->contractno,true);
		$criteria->compare('woino',$this->woino,true);
		$criteria->compare('customer.fullname',$this->addressbookid,true);
		$criteria->compare('projecttype.description',$this->projecttypeid,true);
		$criteria->compare('piccust',$this->piccust,true);
		$criteria->compare('phoneno',$this->phoneno,true);
		$criteria->compare('pocdate',$this->pocdate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);

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
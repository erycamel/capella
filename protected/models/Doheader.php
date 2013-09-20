<?php

/**
 * This is the model class for table "genjournal".
 *
 * The followings are the available columns in table 'genjournal':
 * @property integer $genjournalid
 * @property string $dono
 * @property string $journaldate
 * @property string $journalnote
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Journaldetail[] $journaldetails
 */
class Doheader extends CActiveRecord
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
		return 'doheader';
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
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('dono', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('doheaderid, dono, dodate,postdate, recordstatus', 'safe', 'on'=>'search'),
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
			'dodetail' => array(self::HAS_MANY, 'Dodetail', 'doheaderid'),
      'customer' => array(self::BELONGS_TO, 'Customer', 'addressbookid'),
      'soheader' => array(self::BELONGS_TO, 'Soheader', 'soheaderid'),
      'project' => array(self::BELONGS_TO, 'Project', 'projectid'),
		);
	}

        public function beforeSave() {
    if ($this->isNewRecord) {
        $this->dodate = new CDbExpression('NOW()');
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
			'doheaderid' => 'ID',
			'dono' => 'DO No',
			'dodate' => 'DO Date',
			'postdate' => 'Post Date',
			'addressbookid'=>'Customer',
                    'soheaderid'=>'SO No',
            'projectid'=>'Project',
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

		$criteria->compare('doheaderid',$this->doheaderid);
		$criteria->compare('dono',$this->dono,true);
		$criteria->compare('dodate',$this->dodate,true);
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
		$criteria->compare('doheaderid',$this->doheaderid);
		$criteria->compare('dono',$this->dono,true);
		$criteria->compare('dodate',$this->dodate,true);
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
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listdo') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('doheaderid',$this->doheaderid);
		$criteria->compare('dono',$this->dono,true);
		$criteria->compare('dodate',$this->dodate,true);
		$criteria->compare('postdate',$this->postdate,true);
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
            'application.behaviors.ActiveRecordLogableBehavior',
    );
  }
}
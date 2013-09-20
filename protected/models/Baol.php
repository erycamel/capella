<?php

/**
 * This is the model class for table "baol".
 *
 * The followings are the available columns in table 'baol':
 */
class Baol extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Baol the static model class
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
		return 'baol';
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
			array('baolno,baoldate,pic,jabatan,piccust,jabatancust', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('baolid, baolno, soheaderid,
              recordstatus,baolno,baoldate,pic,jabatan,piccust,jabatancust', 'safe', 'on'=>'search'),
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
		);
	}
	
	public function beforeSave()
    {
      $this->baoldate = date(Yii::app()->params['datetodb'], strtotime($this->baoldate));
      return parent::beforeSave();
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'baolid' => 'ID',
			'baolno' => 'SRF No',
            'soheaderid' => 'SPK/Contract',
			'recordstatus' => 'Record Status',
            'baolno'=>'BAOL No',
			'baoldate'=>'BAOL Date',
			'pic'=>'PIC',
			'jabatan'=>'Position',
			'piccust'=>'PIC Customer',
			'jabatancust'=>'Customer Position'
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
        $criteria->with=array('soheader');
		$criteria->compare('t.baolid',$this->baolid,true);
		$criteria->compare('baolno',$this->baolno,true);
		$criteria->compare('t.recordstatus',$this->recordstatus);
		$criteria->compare('baoldate',$this->baoldate,true);
		$criteria->compare('soheader.contractno',$this->soheaderid,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('jabatan',$this->jabatan,true);
		$criteria->compare('piccust',$this->piccust,true);
		$criteria->compare('jabatancust',$this->jabatancust,true);

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
        $criteria->with=array('soheader');
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listbaol') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('baolid',$this->baolid,true);
		$criteria->compare('baolno',$this->baolno,true);
		$criteria->compare('soheader.contractno',$this->soheaderid,true);
		$criteria->compare('baoldate',$this->baoldate,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('jabatan',$this->jabatan,true);
		$criteria->compare('piccust',$this->piccust,true);
		$criteria->compare('jabatancust',$this->jabatancust,true);

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
$criteria->condition="t.baolno <> '' and t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listbaol') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('baolid',$this->baolid,true);
		$criteria->compare('baolno',$this->baolno,true);
		$criteria->compare('soheader.contractno',$this->soheaderid,true);
		$criteria->compare('baoldate',$this->baoldate,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('jabatan',$this->jabatan,true);
		$criteria->compare('piccust',$this->piccust,true);
		$criteria->compare('jabatancust',$this->jabatancust,true);

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
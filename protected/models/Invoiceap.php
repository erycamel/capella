<?php

/**
 * This is the model class for table "invoiceap".
 *
 * The followings are the available columns in table 'invoiceap':
 * @property string $invoiceapid
 * @property string $doheaderid
 * @property string $invoiceno
 * @property string $projectid
 * @property string $invoicedate
 * @property integer $recordstatus
 * @property string $addressbookid
 */
class Invoiceap extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Invoiceap the static model class
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
		return 'invoiceap';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recordstatus,addressbookid', 'numerical', 'integerOnly'=>true),
			array('poheaderid', 'length', 'max'=>10),
			array('invoiceno,invoicedate', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoiceapid, poheaderid, invoiceno, invoicedate, recordstatus, addressbookid', 'safe', 'on'=>'search'),
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
			'poheader' => array(self::BELONGS_TO, 'Poheader', 'poheaderid'),
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'addressbookid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invoiceapid' => 'ID',
			'poheaderid' => 'PO No',
			'invoiceno' => 'Invoice No',
			'invoicedate' => 'Invoice Date',
			'recordstatus' => 'Record Status',
			'payaccount' => 'Bank Account for Payment',
			'taxid' => 'Tax',
			'addressid' => 'Address',
			'addressbookid' => 'Supplier',
			'totalinvoice'=> 'Total Invoice'
		);
	}
	
	public function beforeSave() {
        $this->invoicedate = ($this->invoicedate!==null)?($this->invoicedate!=="")?date(Yii::app()->params['datetodb'], strtotime($this->invoicedate)):null:null;
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
		
		$criteria->compare('poheader.pocno',$this->poheaderid,true);

		return new CActiveDataProvider($this, array(
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
		 $criteria->with=array('poheader','supplier');
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listinvoice') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('poheader.pocno',$this->poheaderid,true);
		$criteria->compare('supplier.fullname',$this->addressbookid,true);

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
            'application.behaviors.ActiveRecordLogableBehavior',
    );
  }
}
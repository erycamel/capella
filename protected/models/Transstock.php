<?php

/**
 * This is the model class for table "transstock".
 *
 * The followings are the available columns in table 'transstock':
 * @property string $transstockid
 * @property string $transstockno
 * @property string $slocfrom
 * @property string $slocto
 * @property string $docdate
 * @property string $postdate
 * @property integer $recordstatus
 */
class Transstock extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Transstock the static model class
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
		return 'transstock';
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
			array('transstockno', 'length', 'max'=>50),
			array('slocfromid, sloctoid', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('transstockid, transstockno, slocfromid, sloctoid, docdate, postdate, recordstatus', 'safe', 'on'=>'search'),
		);
	}

    public function beforeSave() {
    if ($this->isNewRecord)
        $this->docdate = new CDbExpression('NOW()');
        $this->postdate = new CDbExpression('NOW()');

    return parent::beforeSave();
}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'slocfrom' => array(self::BELONGS_TO, 'Sloc', 'slocfromid'),
			'slocto' => array(self::BELONGS_TO, 'Sloc', 'sloctoid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transstockid' => 'ID',
			'transstockno' => 'Transfer Stock No',
			'slocfromid' => 'Sloc From',
			'sloctoid' => 'Sloc To',
			'docdate' => 'Doc Date',
			'postdate' => 'Post Date',
            'headernote'=> 'Note',
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

		$criteria->compare('transstockid',$this->transstockid,true);
		$criteria->compare('transstockno',$this->transstockno,true);
		$criteria->compare('slocfromid',$this->slocfromid,true);
		$criteria->compare('sloctoid',$this->sloctoid,true);
		$criteria->compare('docdate',$this->docdate,true);
		$criteria->compare('postdate',$this->postdate,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchwfstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('slocfrom','slocto');
$criteria->condition="t.recordstatus in (select b.wfbefstat
from workflow a
inner join wfgroup b on b.workflowid = a.workflowid
inner join groupaccess c on c.groupaccessid = b.groupaccessid
inner join usergroup d on d.groupaccessid = c.groupaccessid
inner join useraccess e on e.useraccessid = d.useraccessid
where upper(a.wfname) = upper('listts') and upper(e.username)=upper('".Yii::app()->user->name."'))";
		$criteria->compare('transstockid',$this->transstockid,true);
		$criteria->compare('transstockno',$this->transstockno,true);
		$criteria->compare('slocfromid',$this->slocfromid,true);
		$criteria->compare('sloctoid',$this->sloctoid,true);
		$criteria->compare('docdate',$this->docdate,true);
		$criteria->compare('postdate',$this->postdate,true);
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
            'application.behaviors.ActiveRecordLogableBehavior',
    );
  }
}
<?php

/**
 * This is the model class for table "applicantjamsostek".
 *
 * The followings are the available columns in table 'applicantjamsostek':
 * @property integer $applicantjamsostekid
 * @property integer $applicantid
 * @property string $jamsostekdate
 * @property string $jamsostekno
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Applicant $applicant
 */
class Applicantjamsostek extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Applicantjamsostek the static model class
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
		return 'employeejamsostek';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeeid, jamsostekno, recordstatus', 'required'),
			array('employeeid, recordstatus', 'numerical', 'integerOnly'=>true),
			array('jamsostekno', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('applicantjamsostekid, employeeid, jamsostekdate, jamsostekno, recordstatus', 'safe', 'on'=>'search'),
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
			'applicant' => array(self::BELONGS_TO, 'Applicant', 'employeeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeejamsostekid' => 'ID',
			'employeeid' => 'Employee',
			'jamsostekdate' => 'Jamsostek Date',
			'jamsostekno' => 'Jamsostek No',
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
		$criteria->with=array('applicant.addressbook');
		$criteria->condition='addressbook.isemployee=0 and addressbook.isapplicant=1';
		$criteria->compare('employeejamsostekid',$this->employeejamsostekid);
		$criteria->compare('applicant.fullname',$this->employeeid,true);
		$criteria->compare('jamsostekdate',$this->jamsostekdate,true);
		$criteria->compare('jamsostekno',$this->jamsostekno,true);
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
		$criteria->with=array('applicant.addressbook');
		$criteria->condition='t.recordstatus=1 and addressbook.isemployee=1 and addressbook.isapplicant=0';
		$criteria->compare('employeejamsostekid',$this->employeejamsostekid);
		$criteria->compare('applicant.fullname',$this->employeeid,true);
		$criteria->compare('jamsostekdate',$this->jamsostekdate,true);
		$criteria->compare('jamsostekno',$this->jamsostekno,true);
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

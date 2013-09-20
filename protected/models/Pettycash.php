<?php

/**
 * This is the model class for table "pettycash".
 *
 * The followings are the available columns in table 'pettycash':
 * @property string $pettycashid
 * @property string $pettycashno
 * @property string $pettycashdate
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 */
class Pettycash extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pettycash the static model class
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
		return 'pettycash';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recordstatus,currencyid, employeeid', 'numerical', 'integerOnly'=>true),
			array('pettycashno', 'length', 'max'=>50),
                    array('pettycashval', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pettycashid, pettycashno, pettycashdate, employeeid, recordstatus', 'safe', 'on'=>'search'),
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
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employeeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pettycashid' => 'ID',
			'pettycashno' => 'Petty Cash No',
			'pettycashdate' => 'Petty Cash Date',
                        'currencyid' => 'Currency',
                        'pettycashval' => 'Value',
            'pettynote' => 'Petty Note',
			'recordstatus' => 'Record Status',
            'employeeid'=>'Employee'
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
$criteria->with=array('employee','currency');
		$criteria->compare('pettycashid',$this->pettycashid,true);
		$criteria->compare('pettycashno',$this->pettycashno,true);
		$criteria->compare('pettycashdate',$this->pettycashdate,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('recordstatus',$this->recordstatus);

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
		$criteria->with=array('employee','currency');
		$criteria->compare('pettycashid',$this->pettycashid,true);
		$criteria->compare('pettycashno',$this->pettycashno,true);
		$criteria->compare('pettycashdate',$this->pettycashdate,true);
		$criteria->compare('employee.fullname',$this->employeeid,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
            'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

     public function beforeSave() {
    if ($this->isNewRecord) {
        $this->pettycashdate = new CDbExpression('NOW()');
        $this->postdate = new CDbExpression('NOW()');
    }
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
<?php

/**
 * This is the model class for table "wagetype".
 *
 * The followings are the available columns in table 'wagetype':
 * @property integer $wagetypeid
 * @property string $wagename
 * @property integer $recordstatus
 */
class Wagetype extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Wagetype the static model class
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
		return 'wagetype';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wagename, recordstatus', 'required'),
			array('recordstatus,ispph,ispph,isprint,currencyid,paidbycompany,pphbycompany', 'numerical', 'integerOnly'=>true),
			array('wagename', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('wagetypeid, wagename, recordstatus', 'safe', 'on'=>'search'),
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
      			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wagetypeid' => 'ID',
			'wagename' => 'Benefit & Wage',
			'recordstatus' => 'Record Status',
            'ispph'=>'Is Tax',
            'ispayroll'=>'Is Payroll',
            'isprint'=>'Is Print',
            'maxvalue'=>'Max Value',
            'currencyid'=>'Currency',
			'paidbycompany'=>'Paid By Company',
			'pphbycompany'=>'PPh By Company'
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
        $criteria->with=array('currency');
		$criteria->compare('wagetypeid',$this->wagetypeid);
		$criteria->compare('wagename',$this->wagename,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

  /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('currency');
    $criteria->condition='t.recordstatus=1';
		$criteria->compare('wagetypeid',$this->wagetypeid);
		$criteria->compare('wagename',$this->wagename,true);
		$criteria->compare('currency.currencyname',$this->currencyid,true);

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
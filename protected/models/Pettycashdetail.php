<?php

/**
 * This is the model class for table "pettycashdet".
 *
 * The followings are the available columns in table 'pettycashdet':
 * @property string $pettycashdetid
 * @property string $pettycashid
 * @property string $accountid
 * @property string $debet
 * @property string $credit
 * @property string $currencyid
 * @property string $itemnote
 *
 * The followings are the available model relations:
 * @property Pettycash $pettycash
 */
class Pettycashdetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Pettycashdet the static model class
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
		return 'pettycashdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pettycashid, accountid, debit, credit, currencyid', 'required'),
			array('pettycashid, accountid, currencyid', 'length', 'max'=>10),
			array('debit, credit', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pettycashdetailid, pettycashid, accountid, debit, credit, currencyid, itemnote', 'safe', 'on'=>'search'),
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
			'pettycash' => array(self::BELONGS_TO, 'Pettycash', 'pettycashid'),
			'project' => array(self::BELONGS_TO, 'Project', 'projectid'),
			'account' => array(self::BELONGS_TO, 'Account', 'accountid'),
			'currency' => array(self::BELONGS_TO, 'Currency', 'currencyid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pettycashdetailid' => 'Id',
			'pettycashid' => 'Petty Cash',
			'accountid' => 'Account',
			'debet' => 'Debet',
			'credit' => 'Credit',
			'currencyid' => 'Currency',
			'itemnote' => 'Item Note',
            'projectid' => 'Project'
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
        $criteria->with=array('project','pettycash');
        if (isset($_GET['Pettycashdetail'])) {
            $model=new Pettycash('search');
            $model->attributes = $_GET['Pettycashdetail'];
            if ($model->pettycashid != null)
            {
              $criteria->condition='t.pettycashid='.$model->pettycashid;
            } else 
            {
              $criteria->condition='t.projectid='.$model->projectid;
            }
        }
		$criteria->compare('pettycashdetailid',$this->pettycashdetailid,true);
		$criteria->compare('pettycash.pettycashno',$this->pettycashid,true);
		$criteria->compare('accountid',$this->accountid,true);
		$criteria->compare('debit',$this->debit,true);
		$criteria->compare('credit',$this->credit,true);
		$criteria->compare('currencyid',$this->currencyid,true);
		$criteria->compare('itemnote',$this->itemnote,true);
		$criteria->compare('project.projectno',$this->projectid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
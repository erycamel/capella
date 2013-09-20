<?php

/**
 * This is the model class for table "projectdoc".
 *
 * The followings are the available columns in table 'projectdoc':
 * @property string $projectdocid
 * @property string $projectid
 * @property string $prodoctemplateid
 * @property integer $recordstatus
 */
class Projectdoc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Projectdoc the static model class
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
		return 'projectdoc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projectid, prodoctemplateid, recordstatus', 'required'),
			array('recordstatus', 'numerical', 'integerOnly'=>true),
			array('projectid, prodoctemplateid', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('projectdocid, projectid, prodoctemplateid, recordstatus', 'safe', 'on'=>'search'),
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
		);
	}

    public function beforeSave() {
    if ($this->recordstatus == 1)
        $this->docdate = new CDbExpression('NOW()');

    return parent::beforeSave();
}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'projectdocid' => 'Projectdocid',
			'projectid' => 'Projectid',
			'prodoctemplateid' => 'Prodoctemplateid',
			'recordstatus' => 'Recordstatus',
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

		$criteria->compare('projectdocid',$this->projectdocid,true);
		$criteria->compare('projectid',$this->projectid,true);
		$criteria->compare('prodoctemplateid',$this->prodoctemplateid,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "prodoctemplate".
 *
 * The followings are the available columns in table 'prodoctemplate':
 * @property string $prodoctemplateid
 * @property string $projecttypeid
 * @property string $documentname
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property Projecttype $projecttype
 */
class Prodoctemplate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Prodoctemplate the static model class
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
		return 'prodoctemplate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projecttypeid, documentname, recordstatus', 'required'),
			array('recordstatus,projecttypeid,documenttypeid', 'numerical', 'integerOnly'=>true),
			array('documentname', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prodoctemplateid, projecttypeid, documentname, recordstatus', 'safe', 'on'=>'search'),
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
			'projecttype' => array(self::BELONGS_TO, 'Projecttype', 'projecttypeid'),
			'documenttype' => array(self::BELONGS_TO, 'Documenttype', 'documenttypeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prodoctemplateid' => 'ID',
			'projecttypeid' => 'Project Type',
			'documentname' => 'Document ',
			'recordstatus' => 'Record Status',
            'documenttypeid'=>'Document Type'
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
$criteria->with=array('projecttype','documenttype');
		$criteria->compare('prodoctemplateid',$this->prodoctemplateid,true);
		$criteria->compare('projecttype.description',$this->projecttypeid,true);
		$criteria->compare('documenttype.documenttypename',$this->documenttypeid,true);
		$criteria->compare('documentname',$this->documentname,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),			'criteria'=>$criteria,
		));
	}

    public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
$criteria->with=array('projecttype','documenttype');
$criteria->condition='t.recordstatus=1';
		$criteria->compare('prodoctemplateid',$this->prodoctemplateid,true);
		$criteria->compare('projecttype.description',$this->projecttypeid,true);
		$criteria->compare('documenttype.documenttypename',$this->documenttypeid,true);
		$criteria->compare('documentname',$this->documentname,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider($this, array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),			'criteria'=>$criteria,
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
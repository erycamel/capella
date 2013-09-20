<?php

/**
 * This is the model class for table "cateringmenu".
 *
 * The followings are the available columns in table 'cateringmenu':
 * @property integer $cateringmenuid
 * @property integer $addressbookid
 * @property string $datefrom
 * @property string $dateto
 * @property integer $istestfood
 * @property integer $catmenutypeid
 * @property string $foodmenu
 * @property integer $recordstatus
 */
class Cateringmenu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Cateringmenu the static model class
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
		return 'cateringmenu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addressbookid, datefrom, dateto, istestfood, catmenutypeid, foodmenu, recordstatus', 'required'),
			array('addressbookid, istestfood, catmenutypeid, recordstatus', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cateringmenuid, addressbookid, datefrom, dateto, istestfood, catmenutypeid, foodmenu, recordstatus', 'safe', 'on'=>'search'),
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
			'addressbook' => array(self::BELONGS_TO, 'Catering', 'addressbookid'),
			'catmenutype' => array(self::BELONGS_TO, 'Catmenutype', 'catmenutypeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cateringmenuid' => 'ID',
			'addressbookid' => 'Catering',
			'datefrom' => 'Date From',
			'dateto' => 'Date To',
			'istestfood' => 'Is Test Food',
			'catmenutypeid' => 'Catering Menu Type',
			'foodmenu' => 'Food Menu',
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

		$criteria->compare('cateringmenuid',$this->cateringmenuid);
		$criteria->compare('addressbookid',$this->addressbookid);
		$criteria->compare('datefrom',$this->datefrom,true);
		$criteria->compare('dateto',$this->dateto,true);
		$criteria->compare('istestfood',$this->istestfood);
		$criteria->compare('catmenutypeid',$this->catmenutypeid);
		$criteria->compare('foodmenu',$this->foodmenu,true);
		$criteria->compare('recordstatus',$this->recordstatus);

		return new CActiveDataProvider(get_class($this), array(
			'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),'criteria'=>$criteria,
		));
	}

	public function searchwstatus()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition='recordstatus=1';
		$criteria->compare('cateringmenuid',$this->cateringmenuid);
		$criteria->compare('addressbookid',$this->addressbookid);
		$criteria->compare('datefrom',$this->datefrom,true);
		$criteria->compare('dateto',$this->dateto,true);
		$criteria->compare('istestfood',$this->istestfood);
		$criteria->compare('catmenutypeid',$this->catmenutypeid);
		$criteria->compare('foodmenu',$this->foodmenu,true);
		$criteria->compare('recordstatus',$this->recordstatus);

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
            'application.behaviors.ActiveRecordLogableBehavior'
    );
  }
}
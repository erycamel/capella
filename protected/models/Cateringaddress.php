<?php

/**
 * This is the model class for table "address".
 *
 * The followings are the available columns in table 'address':
 * @property integer $addressid
 * @property integer $addressbookid
 * @property integer $addresstypeid
 * @property string $addressname
 * @property string $rt
 * @property string $rw
 * @property integer $cityid
 * @property integer $kelurahanid
 * @property integer $subdistrictid
 * @property integer $recordstatus
 *
 * The followings are the available model relations:
 * @property CateringAddressbook $addressbook
 * @property City $city
 * @property Subdistrict $subdistrict
 * @property CateringAddresstype $addresstype
 */
class Cateringaddress extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Cateringaddress the static model class
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
		return 'address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addressbookid, addresstypeid, addressname, cityid', 'required'),
			array('addressbookid, addresstypeid, cityid, kelurahanid, subdistrictid', 'numerical', 'integerOnly'=>true),
			array('addressname', 'length', 'max'=>50),
			array('rt, rw', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('addressid, addressbookid, addresstypeid, addressname, rt, rw, cityid, kelurahanid, subdistrictid', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'City', 'cityid'),
			'kelurahan' => array(self::BELONGS_TO, 'Kelurahan', 'kelurahanid'),
			'subdistrict' => array(self::BELONGS_TO, 'Subdistrict', 'subdistrictid'),
			'addresstype' => array(self::BELONGS_TO, 'Addresstype', 'addresstypeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'addressid' => 'ID',
			'addressbookid' => 'Header',
			'addresstypeid' => 'Address Type',
			'addressname' => 'Address',
			'rt' => 'RT',
			'rw' => 'RW',
			'cityid' => 'City',
			'kelurahanid' => 'Sub subdistrict',
			'subdistrictid' => 'Sub District'
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
    $criteria->with=array('addressbook','addresstype','city','kelurahan','subdistrict');
	if (isset($_GET['Cateringaddress'])) {
$model=new Cateringaddress('search');
$model->attributes = $_GET['Cateringaddress'];
$criteria->condition='addressbook.iscatering=1 and t.addressbookid='.$model->addressbookid;
} else {
$criteria->condition='addressbook.iscatering=1 and t.addressbookid=0';
}
		$criteria->compare('addressid',$this->addressid);
		$criteria->compare('addressbook.addressbookid',$this->addressbookid,true);
		$criteria->compare('addresstype.addresstypename',$this->addresstypeid,true);
		$criteria->compare('addressname',$this->addressname,true);
		$criteria->compare('rt',$this->rt,true);
		$criteria->compare('rw',$this->rw,true);
		$criteria->compare('city.cityname',$this->cityid,true);
		$criteria->compare('kelurahan.kelurahanname',$this->kelurahanid,true);
		$criteria->compare('subdistrict.subdistrictname',$this->subdistrictid,true);

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
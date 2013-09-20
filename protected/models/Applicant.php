<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property integer $employeeid
 * @property integer $addressbookid
 * @property string $oldnik
 * @property string $newnik
 * @property integer $orgstructureid
 * @property integer $positionid
 * @property integer $employeetypeid
 * @property integer $sexid
 * @property integer $bloodtypeid
 * @property integer $birthcityid
 * @property string $birthdate
 * @property integer $religionid
 * @property integer $maritalstatusid
 * @property integer $tribeid
 * @property string $referenceby
 * @property string $joindate
 * @property integer $employeestatusid
 * @property integer $istrial
 * @property string $barcode
 * @property string $photo
 * @property integer $bodyheight
 * @property integer $bodyweight
 * @property string $dresssize
 * @property string $resigndate
 * @property string $shoesize
 *
 * The followings are the available model relations:
 * @property Abstrans[] $abstrans
 * @property Addressbook $addressbook
 * @property Applicanteducation[] $employeeeducations
 * @property Applicantfamily[] $employeefamilys
 * @property Applicantjamsostek[] $employeejamsosteks
 * @property Applicantschedule[] $employeeschedules
 * @property Lockercheck[] $lockerchecks
 * @property Lockerreturn[] $lockerreturns
 * @property Lockertake[] $lockertakes
 */
class Applicant extends CActiveRecord
{
  public $imagephoto,$imagebarcode;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Applicant the static model class
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
		return 'employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fullname,orgstructureid, positionid, employeetypeid, sexid, bloodtypeid, birthcityid, religionid, maritalstatusid, tribeid,  employeestatusid', 'required'),
			array('orgstructureid, positionid, employeetypeid, sexid, bloodtypeid, birthcityid, religionid, maritalstatusid, tribeid, employeestatusid, istrial, bodyheight, bodyweight', 'numerical', 'integerOnly'=>true),
			array('photo,barcode, fullname,addressbookid,oldnik, newnik, referenceby', 'length', 'max'=>50),
			array('dresssize, shoesize', 'length', 'max'=>10),
      array('imagephoto,imagebarcode', 'file', 'types'=>'jpg, gif, png'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeeid, addressbookid, oldnik, newnik, orgstructureid, positionid, employeetypeid, sexid, bloodtypeid, birthcityid, birthdate, religionid, maritalstatusid, tribeid, referenceby, joindate, employeestatusid, istrial, barcode, photo, bodyheight, bodyweight, dresssize, resigndate, shoesize', 'safe', 'on'=>'search'),
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
			'abstrans' => array(self::HAS_MANY, 'Abstrans', 'employeeid'),
			'addressbook' => array(self::BELONGS_TO, 'Addressbook', 'addressbookid'),
			'employeeeducations' => array(self::HAS_MANY, 'Applicanteducation', 'employeeid'),
			'employeefamilys' => array(self::HAS_MANY, 'Applicantfamily', 'employeeid'),
			'employeejamsosteks' => array(self::HAS_MANY, 'Applicantjamsostek', 'employeeid'),
			'employeeschedules' => array(self::HAS_MANY, 'Applicantschedule', 'employeeid'),
			'lockerchecks' => array(self::HAS_MANY, 'Lockercheck', 'employeeid'),
			'lockerreturns' => array(self::HAS_MANY, 'Lockerreturn', 'employeeid'),
			'lockertakes' => array(self::HAS_MANY, 'Lockertake', 'employeeid'),
			'orgstructure' => array(self::BELONGS_TO, 'Orgstructure', 'orgstructureid'),
			'position' => array(self::BELONGS_TO, 'Position', 'positionid'),
			'employeetype' => array(self::BELONGS_TO, 'Employeetype', 'employeetypeid'),
			'sex' => array(self::BELONGS_TO, 'Sex', 'sexid'),
			'bloodtype' => array(self::BELONGS_TO, 'Bloodtype', 'bloodtypeid'),
			'religion' => array(self::BELONGS_TO, 'Religion', 'religionid'),
			'maritalstatus' => array(self::BELONGS_TO, 'Maritalstatus', 'maritalstatusid'),
			'tribe' => array(self::BELONGS_TO, 'Tribe', 'tribeid'),
			'employeestatus' => array(self::BELONGS_TO, 'Employeestatus', 'employeestatusid'),
			'birthcity' => array(self::BELONGS_TO, 'City', 'birthcityid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'employeeid' => 'ID',
			'fullname'=>'Name ',
			'addressbookid' => 'Name ',
			'oldnik' => 'Old NIK',
			'newnik' => 'New NIK',
			'orgstructureid' => 'Structure',
			'positionid' => 'Position',
			'employeetypeid' => 'Applicant Type',
			'sexid' => 'Sex',
			'bloodtypeid' => 'Blood Type',
			'birthcityid' => 'Birth City',
			'birthdate' => 'Birth Date',
			'religionid' => 'Religion',
			'maritalstatusid' => 'Marital Status',
			'tribeid' => 'Tribe',
			'referenceby' => 'Reference By',
			'joindate' => 'Join Date',
			'employeestatusid' => 'Applicant Status',
			'istrial' => 'Trial?',
			'barcode' => 'Barcode',
			'photo' => 'Photo',
			'bodyheight' => 'Body Height',
			'bodyweight' => 'Body Weight',
			'dresssize' => 'Dress Size',
			'resigndate' => 'Resign Date',
			'shoesize' => 'Shoe Size',
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
	  $criteria->with=array('addressbook','orgstructure','position','employeetype',
		'sex','bloodtype','birthcity','religion','maritalstatus','tribe',
		'employeestatus');
	  $criteria->condition='addressbook.isapplicant=1 and addressbook.isemployee=0';
	  $criteria->compare('employeeid',$this->employeeid);
	  $criteria->compare('t.fullname',$this->fullname,true);
	  $criteria->compare('oldnik',$this->oldnik,true);
	  $criteria->compare('newnik',$this->newnik,true);
	  $criteria->compare('orgstructure.structurename',$this->orgstructureid,true);
	  $criteria->compare('position.positionname',$this->positionid,true);
	  $criteria->compare('employeetype.employeetypename',$this->employeetypeid,true);
	  $criteria->compare('sex.sexname',$this->sexid,true);
	  $criteria->compare('bloodtype.bloodtypename',$this->bloodtypeid,true);
	  $criteria->compare('birthcity.cityname',$this->birthcityid,true);
	  $criteria->compare('birthdate',$this->birthdate,true);
	  $criteria->compare('religion.religionname',$this->religionid,true);
	  $criteria->compare('maritalstatus.maritalstatusname',$this->maritalstatusid,true);
	  $criteria->compare('tribe.tribename',$this->tribeid,true);
	  $criteria->compare('referenceby',$this->referenceby,true);
	  $criteria->compare('joindate',$this->joindate,true);
	  $criteria->compare('employeestatus.employeestatusname',$this->employeestatusid,true);
	  $criteria->compare('istrial',$this->istrial);
	  $criteria->compare('barcode',$this->barcode,true);
	  $criteria->compare('photo',$this->photo,true);
	  $criteria->compare('bodyheight',$this->bodyheight);
	  $criteria->compare('bodyweight',$this->bodyweight);
	  $criteria->compare('dresssize',$this->dresssize,true);
	  $criteria->compare('resigndate',$this->resigndate,true);
	  $criteria->compare('shoesize',$this->shoesize,true);

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
    $criteria->with=array('addressbook','orgstructure','position','employeetype',
      'sex','bloodtype','birthcity','religion','maritalstatus','tribe',
      'employeestatus');
    $criteria->condition='addressbook.isapplicant=1 and addressbook.recordstatus=1  and addressbook.isemployee=0';
		$criteria->compare('t.employeeid',$this->employeeid);
		$criteria->compare('t.fullname',$this->fullname,true);
		$criteria->compare('t.oldnik',$this->oldnik,true);
		$criteria->compare('t.newnik',$this->newnik,true);
		$criteria->compare('orgstructure.structurename',$this->orgstructureid,true);
		$criteria->compare('position.positionname',$this->positionid,true);
		$criteria->compare('employeetype.employeetypename',$this->employeetypeid,true);
		$criteria->compare('sex.sexname',$this->sexid,true);
		$criteria->compare('bloodtype.bloodtypename',$this->bloodtypeid,true);
		$criteria->compare('birthcity.cityname',$this->birthcityid,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('religion.religionname',$this->religionid,true);
		$criteria->compare('maritalstatus.maritalstatusname',$this->maritalstatusid,true);
		$criteria->compare('tribe.tribename',$this->tribeid,true);
		$criteria->compare('referenceby',$this->referenceby,true);
		$criteria->compare('joindate',$this->joindate,true);
		$criteria->compare('employeestatus.employeestatusname',$this->employeestatusid,true);
		$criteria->compare('t.istrial',$this->istrial);
		$criteria->compare('t.barcode',$this->barcode,true);
		$criteria->compare('t.photo',$this->photo,true);
		$criteria->compare('t.bodyheight',$this->bodyheight);
		$criteria->compare('t.bodyweight',$this->bodyweight);
		$criteria->compare('t.dresssize',$this->dresssize,true);
		$criteria->compare('t.resigndate',$this->resigndate,true);
		$criteria->compare('t.shoesize',$this->shoesize,true);


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
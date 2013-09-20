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
 * @property integer $Ethnicid
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
 * @property Employeeeducation[] $employeeeducations
 * @property Employeefamily[] $employeefamilys
 * @property Employeejamsostek[] $employeejamsosteks
 * @property Employeeschedule[] $employeeschedules
 * @property Lockercheck[] $lockerchecks
 * @property Lockerreturn[] $lockerreturns
 * @property Lockertake[] $lockertakes
 */
class Employee extends CActiveRecord
{
  public $imagephoto,$imagebarcode;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Employee the static model class
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
			array('fullname,orgstructureid, positionid, employeetypeid, sexid, birthcityid,  maritalstatusid,employeestatusid,birthdate,joindate', 'required'),
			array('orgstructureid, positionid, employeetypeid, sexid, 
              birthcityid, religionid, maritalstatusid, employeestatusid, istrial,
             levelorgid', 'numerical', 'integerOnly'=>true),
			array('photo,barcode, fullname,addressbookid,oldnik, newnik, referenceby,
              email,phoneno,alternateemail,hpno,taxno', 'length', 'max'=>50),
			array('dplkno', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employeeid, addressbookid, oldnik, newnik, orgstructureid, positionid, employeetypeid, 
              sexid, bloodtypeid, birthcityid, birthdate, religionid, maritalstatusid, referenceby,
              joindate, employeestatusid, istrial, barcode, photo, dplkno,
              resigndate, taxno', 'safe', 'on'=>'search'),
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
			'employeeeducations' => array(self::HAS_MANY, 'Employeeeducation', 'employeeid'),
			'employeefamilys' => array(self::HAS_MANY, 'Employeefamily', 'employeeid'),
			'employeejamsosteks' => array(self::HAS_MANY, 'Employeejamsostek', 'employeeid'),
			'employeeschedules' => array(self::HAS_MANY, 'Employeeschedule', 'employeeid'),
			'orgstructure' => array(self::BELONGS_TO, 'Orgstructure', 'orgstructureid'),
      'position' => array(self::BELONGS_TO, 'Position', 'positionid'),
      'employeetype' => array(self::BELONGS_TO, 'Employeetype', 'employeetypeid'),
      'sex' => array(self::BELONGS_TO, 'Sex', 'sexid'),
      'religion' => array(self::BELONGS_TO, 'Religion', 'religionid'),
      'maritalstatus' => array(self::BELONGS_TO, 'Maritalstatus', 'maritalstatusid'),
      'employeestatus' => array(self::BELONGS_TO, 'Employeestatus', 'employeestatusid'),
      'birthcity' => array(self::BELONGS_TO, 'City', 'birthcityid'),
      'levelorg' => array(self::BELONGS_TO, 'Levelorg', 'levelorgid'),
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
			'oldnik' => 'NIP',
			'newnik' => 'New NIP',
			'orgstructureid' => 'Department',
			'positionid' => 'Position',
			'employeetypeid' => 'Employee Type',
			'sexid' => 'Sex',
			'birthcityid' => 'Birth City',
			'birthdate' => 'Birth Date',
			'religionid' => 'Religion',
			'maritalstatusid' => 'Marital Status',
			'referenceby' => 'Reference By',
			'joindate' => 'Join Date',
			'employeestatusid' => 'PTKP',
			'istrial' => 'Trial?',
			'barcode' => 'Barcode',
			'photo' => 'Photo',
			'dplkno' => 'DPLK',
			'resigndate' => 'Resign Date',
            'levelorgid'=>'Level Org ',
            'email'=>'Email',
            'phoneno'=>'Phone No',
            'alternateemail'=>'Alternate Email',
            'hpno'=>'HP No',
            'taxno'=>'NPWP',
			'hpno2'=>'HP No 2',
        'accountno'=>'Account No'
		);
	}

	public function getTotals()
	{
		$total=0;
		$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'select count(1) as total from soexpense where soheaderid = '.$this->soheaderid;
				$command=$connection->createCommand($sql);
				$row = $command->queryRow();
				$total = $row['total'];
				return $total;
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				return $total;
			}
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
      'sex','birthcity','religion','maritalstatus',
      'employeestatus','levelorg');
    $criteria->condition='addressbook.isemployee=1';
		$criteria->compare('employeeid',$this->employeeid);
		$criteria->compare('addressbook.fullname',$this->fullname,true);
		$criteria->compare('oldnik',$this->oldnik,true);
		$criteria->compare('newnik',$this->newnik,true);
		$criteria->compare('orgstructure.structurename',$this->orgstructureid,true);
		$criteria->compare('position.positionname',$this->positionid,true);
		$criteria->compare('employeetype.employeetypename',$this->employeetypeid,true);
		$criteria->compare('sex.sexname',$this->sexid,true);
		$criteria->compare('birthcity.cityname',$this->birthcityid,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('religion.religionname',$this->religionid,true);
		$criteria->compare('maritalstatus.maritalstatusname',$this->maritalstatusid,true);
		$criteria->compare('referenceby',$this->referenceby,true);
		$criteria->compare('joindate',$this->joindate,true);
		$criteria->compare('employeestatus.employeestatusname',$this->employeestatusid,true);
		$criteria->compare('istrial',$this->istrial);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('dplkno',$this->dplkno);
		$criteria->compare('resigndate',$this->resigndate,true);
		$criteria->compare('levelorg.levelorgname',$this->levelorgid,true);
		$criteria->compare('taxno',$this->taxno,true);
		$criteria->compare('t.accountno',$this->accountno,true);

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
      'sex','birthcity','religion','maritalstatus',
      'employeestatus','levelorg');
    $criteria->condition='addressbook.isemployee=1 and addressbook.recordstatus=1';
		$criteria->compare('t.employeeid',$this->employeeid);
		$criteria->compare('addressbook.fullname',$this->fullname,true);
		$criteria->compare('t.oldnik',$this->oldnik,true);
		$criteria->compare('t.newnik',$this->newnik,true);
		$criteria->compare('orgstructure.structurename',$this->orgstructureid,true);
		$criteria->compare('position.positionname',$this->positionid,true);
		$criteria->compare('employeetype.employeetypename',$this->employeetypeid,true);
		$criteria->compare('sex.sexname',$this->sexid,true);
		$criteria->compare('birthcity.cityname',$this->birthcityid,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('religion.religionname',$this->religionid,true);
		$criteria->compare('maritalstatus.maritalstatusname',$this->maritalstatusid,true);
		$criteria->compare('referenceby',$this->referenceby,true);
		$criteria->compare('joindate',$this->joindate,true);
		$criteria->compare('employeestatus.employeestatusname',$this->employeestatusid,true);
		$criteria->compare('t.istrial',$this->istrial);
		$criteria->compare('t.barcode',$this->barcode,true);
		$criteria->compare('t.photo',$this->photo,true);
		$criteria->compare('t.dplkno',$this->dplkno,true);
		$criteria->compare('t.resigndate',$this->resigndate,true);
		$criteria->compare('levelorg.levelorgname',$this->levelorgid,true);
		$criteria->compare('t.accountno',$this->accountno,true);


		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}

    public function searchwakun()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
    $criteria->with=array('addressbook','orgstructure','position','employeetype',
      'sex','birthcity','religion','maritalstatus',
      'employeestatus');
    $criteria->condition='addressbook.isemployee=1 and addressbook.recordstatus=1 and t.employeeid in (select employeeid from employeeakun)';
		$criteria->compare('t.employeeid',$this->employeeid);
		$criteria->compare('addressbook.fullname',$this->fullname,true);
		$criteria->compare('t.oldnik',$this->oldnik,true);
		$criteria->compare('t.newnik',$this->newnik,true);
		$criteria->compare('orgstructure.structurename',$this->orgstructureid,true);
		$criteria->compare('position.positionname',$this->positionid,true);
		$criteria->compare('employeetype.employeetypename',$this->employeetypeid,true);
		$criteria->compare('sex.sexname',$this->sexid,true);
		$criteria->compare('birthcity.cityname',$this->birthcityid,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('religion.religionname',$this->religionid,true);
		$criteria->compare('maritalstatus.maritalstatusname',$this->maritalstatusid,true);
		$criteria->compare('referenceby',$this->referenceby,true);
		$criteria->compare('joindate',$this->joindate,true);
		$criteria->compare('employeestatus.employeestatusname',$this->employeestatusid,true);
		$criteria->compare('t.istrial',$this->istrial);
		$criteria->compare('t.barcode',$this->barcode,true);
		$criteria->compare('t.photo',$this->photo,true);
		$criteria->compare('t.dplkno',$this->dplkno,true);
		$criteria->compare('t.resigndate',$this->resigndate,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    ),
			'criteria'=>$criteria,
		));
	}
	
	public function searchultah()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
    $criteria->with=array('addressbook','orgstructure','position','employeetype',
      'sex','birthcity','religion','maritalstatus',
      'employeestatus');
    $criteria->condition='month(t.birthdate) = month(now())';
	$criteria->order='day(birthdate) asc';
		$criteria->compare('t.employeeid',$this->employeeid);
		$criteria->compare('addressbook.fullname',$this->fullname,true);
		$criteria->compare('t.oldnik',$this->oldnik,true);
		$criteria->compare('t.newnik',$this->newnik,true);
		$criteria->compare('orgstructure.structurename',$this->orgstructureid,true);
		$criteria->compare('position.positionname',$this->positionid,true);
		$criteria->compare('employeetype.employeetypename',$this->employeetypeid,true);
		$criteria->compare('sex.sexname',$this->sexid,true);
		$criteria->compare('birthcity.cityname',$this->birthcityid,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('religion.religionname',$this->religionid,true);
		$criteria->compare('maritalstatus.maritalstatusname',$this->maritalstatusid,true);
		$criteria->compare('referenceby',$this->referenceby,true);
		$criteria->compare('joindate',$this->joindate,true);
		$criteria->compare('employeestatus.employeestatusname',$this->employeestatusid,true);
		$criteria->compare('t.istrial',$this->istrial);
		$criteria->compare('t.barcode',$this->barcode,true);
		$criteria->compare('t.photo',$this->photo,true);
		$criteria->compare('t.dplkno',$this->dplkno,true);
		$criteria->compare('t.resigndate',$this->resigndate,true);

		return new CActiveDataProvider(get_class($this), array(
'pagination'=>array(
        'pageSize'=> 2,
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
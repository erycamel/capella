<?php

class EmployeeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'employee';

	public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
			}
		}
	  parent::actionHelp();
	}
	
	public $orgstructure,$position,$employeetype,$sex,$bloodtype,$birthcity,
		$religion,$maritalstatus,$tribe,$employeestatus,$levelorg;

	public function lookupdata()
	{
	  $this->orgstructure=new Orgstructure('searchwstatus');
	  $this->orgstructure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Orgstructure']))
		$this->orgstructure->attributes=$_GET['Orgstructure'];

	  $this->position=new Position('searchwstatus');
	  $this->position->unsetAttributes();  // clear any default values
	  if(isset($_GET['Position']))
		$this->position->attributes=$_GET['Position'];

      $this->levelorg=new Levelorg('searchwstatus');
	  $this->levelorg->unsetAttributes();  // clear any default values
	  if(isset($_GET['Levelorg']))
		$this->levelorg->attributes=$_GET['Levelorg'];

	  $this->employeetype=new Employeetype('searchwstatus');
	  $this->employeetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeetype']))
		$this->employeetype->attributes=$_GET['Employeetype'];

	  $this->sex=new Sex('searchwstatus');
	  $this->sex->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sex']))
		$this->sex->attributes=$_GET['Sex'];

	  $this->bloodtype=new Bloodtype('searchwstatus');
	  $this->bloodtype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Bloodtype']))
		$this->bloodtype->attributes=$_GET['Bloodtype'];

	  $this->birthcity=new City('searchwstatus');
	  $this->birthcity->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$this->birthcity->attributes=$_GET['City'];

	  $this->religion=new Religion('searchwstatus');
	  $this->religion->unsetAttributes();  // clear any default values
	  if(isset($_GET['Religion']))
		$this->religion->attributes=$_GET['Religion'];

	  $this->maritalstatus=new Maritalstatus('searchwstatus');
	  $this->maritalstatus->unsetAttributes();  // clear any default values
	  if(isset($_GET['Maritalstatus']))
		$this->maritalstatus->attributes=$_GET['Maritalstatus'];

	  $this->tribe=new Tribe('searchwstatus');
	  $this->tribe->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tribe']))
		$this->tribe->attributes=$_GET['Tribe'];

	  $this->employeestatus=new Employeestatus('searchwstatus');
	  $this->employeestatus->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeestatus']))
		$this->employeestatus->attributes=$_GET['Employeestatus'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
      $this->lookupdata();
      $model=new Employee;

	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			'status'=>'success',
			'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
			  'orgstructure'=>$this->orgstructure,
			  'position'=>$this->position,
			  'employeetype'=>$this->employeetype,
			  'sex'=>$this->sex,
			  'bloodtype'=>$this->bloodtype,
			  'birthcity'=>$this->birthcity,
			  'religion'=>$this->religion,
			  'maritalstatus'=>$this->maritalstatus,
			  'tribe'=>$this->tribe,
			  'employeestatus'=>$this->employeestatus,
                'levelorg'=>$this->levelorg), true)
			));
		Yii::app()->end();
	  }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
	  parent::actionUpdate();
	  $this->lookupdata();
	  $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
	  if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'employeeid'=>$model->employeeid,
			  'addressbookid'=>$model->addressbookid,
			  'fullname'=>$model->fullname,
			  'oldnik'=>$model->oldnik,
			  'newnik'=>$model->newnik,
			  'orgstructureid'=>$model->orgstructureid,
			  'structurename'=>($model->orgstructure!==null)?$model->orgstructure->structurename:"",
			  'positionid'=>$model->positionid,
			  'positionname'=>($model->position!==null)?$model->position->positionname:"",
			  'employeetypeid'=>$model->employeetypeid,
			  'employeetypename'=>($model->employeetype!==null)?$model->employeetype->employeetypename:"",
			  'sexid'=>$model->sexid,
			  'sexname'=>($model->sex!==null)?$model->sex->sexname:"",
			  'birthcityid'=>$model->birthcityid,
			  'birthcityname'=>($model->birthcity!==null)?$model->birthcity->cityname:"",
			  'birthdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->birthdate)),
			  'religionid'=>$model->religionid,
			  'religionname'=>($model->religion!==null)?$model->religion->religionname:"",
			  'maritalstatusid'=>$model->maritalstatusid,
			  'maritalstatusname'=>($model->maritalstatus!==null)?$model->maritalstatus->maritalstatusname:"",
			  'referenceby'=>$model->referenceby,
			  'joindate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->joindate)),
			  'employeestatusid'=>$model->employeestatusid,
			  'employeestatusname'=>($model->employeestatus!==null)?$model->employeestatus->employeestatusname:"",
			  'istrial'=>$model->istrial,
			  'dplkno'=>$model->dplkno,
			  'resigndate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->resigndate)),
			  'levelorgid'=>$model->levelorgid,
			  'levelorgname'=>($model->levelorg!==null)?$model->levelorg->levelorgname:"",
			  'email'=>$model->email,
			  'phoneno'=>$model->phoneno,
			  'alternateemail'=>$model->alternateemail,
			  'hpno'=>$model->hpno,
              'taxno'=>$model->taxno,
			  'hpno2'=>$model->hpno2,
			  'medical'=>$model->medical,
			  'accountno'=>$model->accountno,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'orgstructure'=>$this->orgstructure,
				  'position'=>$this->position,
				  'employeetype'=>$this->employeetype,
				  'sex'=>$this->sex,
				  'birthcity'=>$this->birthcity,
				  'religion'=>$this->religion,
				  'maritalstatus'=>$this->maritalstatus,
				  'employeestatus'=>$this->employeestatus,
                'levelorg'=>$this->levelorg), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employee'],
              $_POST['Employee']['employeeid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employee']))
	  {
        $birthdate = date(Yii::app()->params['datetodb'], strtotime($_POST['Employee']['birthdate']));
        $joindate = date(Yii::app()->params['datetodb'], strtotime($_POST['Employee']['joindate']));
        $resigndate = date(Yii::app()->params['datetodb'], strtotime($_POST['Employee']['resigndate']));
        $messages = $this->ValidateData(
          array(array($_POST['Employee']['fullname'],'heeemptyfullname','emptystring'),
                array($_POST['Employee']['orgstructureid'],'heeemptyorgstructureid','emptystring'),
                array($_POST['Employee']['positionid'],'heeemptypositionid','emptystring'),
              array($_POST['Employee']['employeetypeid'],'heeemptyemployeetypeid','emptystring'),
              array($_POST['Employee']['sexid'],'heeemptysexid','emptystring'),
              array($_POST['Employee']['birthcityid'],'heeemptybirthcityid','emptystring'),
              array($_POST['Employee']['birthdate'],'heeemptybirthdate','emptystring'),
              array($_POST['Employee']['maritalstatusid'],'heeemptymaritalstatusid','emptystring'),
              array($_POST['Employee']['joindate'],'heeemptyjoindate','emptystring'),
              array($_POST['Employee']['employeestatusid'],'heeemptyemployeestatusid','emptystring'),
          ));
        if ($messages == '') {
		  //$dataku->attributes=$_POST['Employee'];
		  if ((int)$_POST['Employee']['employeeid'] > 0)
		  {
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
			  $sql = 'call UpdateEmployee(:vemployeeid,:vemployeename,
				:vorgstructureid,:vpositionid,:vemployeetypeid,
				:vsexid, :vbirthcityid, :vbirthdate,
				:vreligionid, :vmaritalstatusid, :vreferenceby,
				:vjoindate, :vemployeestatusid, :vistrial, :vdplkno,
                :vlastupdateby,:vlevelorg,:vemail,:vphoneno,:valternateemail,
                :vhpno,:vtaxno,:vhpno2,:vmedical,:vaccountno,:vresigndate,:voldnik)';
			  $command=$connection->createCommand($sql);
			  $command->bindParam(':vemployeeid',$_POST['Employee']['employeeid'],PDO::PARAM_INT);
			  $command->bindParam(':vemployeename',$_POST['Employee']['fullname'],PDO::PARAM_STR);
			  $command->bindParam(':vorgstructureid',$_POST['Employee']['orgstructureid'],PDO::PARAM_INT);
			  $command->bindParam(':vpositionid',$_POST['Employee']['positionid'],PDO::PARAM_INT);
			  $command->bindParam(':vemployeetypeid',$_POST['Employee']['employeetypeid'],PDO::PARAM_INT);
			  $command->bindParam(':vsexid',$_POST['Employee']['sexid'],PDO::PARAM_INT);
			  $command->bindParam(':vbirthcityid',$_POST['Employee']['birthcityid'],PDO::PARAM_INT);
			  $command->bindParam(':vbirthdate',$birthdate,PDO::PARAM_STR);
			  $command->bindParam(':vreligionid',$_POST['Employee']['religionid'],PDO::PARAM_INT);
			  $command->bindParam(':vmaritalstatusid',$_POST['Employee']['maritalstatusid'],PDO::PARAM_INT);
			  $command->bindParam(':vreferenceby',$_POST['Employee']['referenceby'],PDO::PARAM_INT);
			  $command->bindParam(':vjoindate',$joindate,PDO::PARAM_STR);
			  $command->bindParam(':vemployeestatusid',$_POST['Employee']['employeestatusid'],PDO::PARAM_INT);
			  $command->bindParam(':vistrial',$_POST['Employee']['istrial'],PDO::PARAM_STR);
			  $command->bindParam(':vdplkno',$_POST['Employee']['dplkno'],PDO::PARAM_STR);
			  $command->bindParam(':vlevelorg',$_POST['Employee']['levelorgid'],PDO::PARAM_INT);
			  $command->bindParam(':vemail',$_POST['Employee']['email'],PDO::PARAM_STR);
			  $command->bindParam(':vphoneno',$_POST['Employee']['phoneno'],PDO::PARAM_STR);
			  $command->bindParam(':valternateemail',$_POST['Employee']['alternateemail'],PDO::PARAM_STR);
			  $command->bindParam(':vhpno',$_POST['Employee']['hpno'],PDO::PARAM_STR);
			  $command->bindParam(':vtaxno',$_POST['Employee']['taxno'],PDO::PARAM_STR);
			  $command->bindParam(':vhpno2',$_POST['Employee']['hpno2'],PDO::PARAM_STR);
			  $command->bindParam(':vmedical',$_POST['Employee']['medical'],PDO::PARAM_STR);
			  $command->bindParam(':vaccountno',$_POST['Employee']['accountno'],PDO::PARAM_STR);
			  $command->bindParam(':vresigndate',$resigndate,PDO::PARAM_STR);
			  $command->bindParam(':voldnik',$_POST['Employee']['oldnik'],PDO::PARAM_STR);
			  $post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
			  $command->bindParam(':vlastupdateby', $post,PDO::PARAM_INT);
			  $command->execute();
			  $transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Employee']['employeeid']);
			  $this->GetSMessage('hrapinsertsuccess');
			}
			catch(Exception $e) // an exception is raised if a query fails
			{
				$transaction->rollBack();
				$this->GetMessage($e->getMessage());
			}
		  }
		  else
		  {
			$model = new Employee();
			$model->attributes=$_POST['Employee'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
			  $sql = 'call InsertEmployee(:vemployeename,
				:vorgstructureid,:vpositionid,:vemployeetypeid,
				:vsexid, :vbirthcityid, :vbirthdate,
				:vreligionid, :vmaritalstatusid, :vreferenceby,
				:vjoindate, :vemployeestatusid, :vistrial, :vdplkno,
				:vcreatedby, :vlevelorg,:vemail,:vphoneno,:valternateemail,:vhpno,:vtaxno,
        :vhpno2,:vmedical,:vaccountno,:vresigndate,:voldnik)';
			  $command=$connection->createCommand($sql);
			  			  $command->bindParam(':vemployeename',$_POST['Employee']['fullname'],PDO::PARAM_STR);
			  $command->bindParam(':vorgstructureid',$_POST['Employee']['orgstructureid'],PDO::PARAM_INT);
			  $command->bindParam(':vpositionid',$_POST['Employee']['positionid'],PDO::PARAM_INT);
			  $command->bindParam(':vemployeetypeid',$_POST['Employee']['employeetypeid'],PDO::PARAM_INT);
			  $command->bindParam(':vsexid',$_POST['Employee']['sexid'],PDO::PARAM_INT);
			  $command->bindParam(':vbirthcityid',$_POST['Employee']['birthcityid'],PDO::PARAM_INT);
			  $command->bindParam(':vbirthdate',$birthdate,PDO::PARAM_STR);
			  $command->bindParam(':vreligionid',$_POST['Employee']['religionid'],PDO::PARAM_INT);
			  $command->bindParam(':vmaritalstatusid',$_POST['Employee']['maritalstatusid'],PDO::PARAM_INT);
			  $command->bindParam(':vreferenceby',$_POST['Employee']['referenceby'],PDO::PARAM_INT);
			  $command->bindParam(':vjoindate',$joindate,PDO::PARAM_STR);
			  $command->bindParam(':vemployeestatusid',$_POST['Employee']['employeestatusid'],PDO::PARAM_INT);
			  $command->bindParam(':vistrial',$_POST['Employee']['istrial'],PDO::PARAM_INT);
			  $command->bindParam(':vdplkno',$_POST['Employee']['dplkno'],PDO::PARAM_STR);
			  $command->bindParam(':vlevelorg',$_POST['Employee']['levelorgid'],PDO::PARAM_INT);
			  $command->bindParam(':vemail',$_POST['Employee']['email'],PDO::PARAM_STR);
			  $command->bindParam(':vphoneno',$_POST['Employee']['phoneno'],PDO::PARAM_STR);
			  $command->bindParam(':valternateemail',$_POST['Employee']['alternateemail'],PDO::PARAM_STR);
			  $command->bindParam(':vhpno',$_POST['Employee']['hpno'],PDO::PARAM_STR);
			  $command->bindParam(':vtaxno',$_POST['Employee']['taxno'],PDO::PARAM_STR);
			  $command->bindParam(':vhpno2',$_POST['Employee']['hpno2'],PDO::PARAM_STR);
			  $command->bindParam(':vmedical',$_POST['Employee']['medical'],PDO::PARAM_STR);
			  $command->bindParam(':vaccountno',$_POST['Employee']['accountno'],PDO::PARAM_STR);
			  $command->bindParam(':vresigndate',$resigndate,PDO::PARAM_STR);
			  $command->bindParam(':voldnik',$_POST['Employee']['oldnik'],PDO::PARAM_STR);
			  $post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
			  $command->bindParam(':vcreatedby', $post,PDO::PARAM_INT);
			  $command->execute();
			  $transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Employee']['employeeid']);
			  $this->GetSMessage('heeinsertsuccess');
			}
			catch (Exception $e)
			{
			  $transaction->rollBack();
			  $this->GetMessage($e->getMessage());
			}
		  }
		}
      }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
	  parent::actionDelete();
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=$this->loadModel($ids);
      $addressbook = Addressbook::model()->findbypk($model->addressbookid);
		  $addressbook->recordstatus=0;
		  $addressbook->save();
      $connection=Yii::app()->db;
      $sql = 'update employee 
        set resigndate = now()
        where employeeid = '.$ids;
       $command=$connection->createCommand($sql);
        $command->execute();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();
	  $model=new Employee('searchwstatus');
		$model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		  $model->attributes=$_GET['Employee'];
      	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
			'model'=>$model,
			'orgstructure'=>$this->orgstructure,
			'position'=>$this->position,
			'employeetype'=>$this->employeetype,
			'sex'=>$this->sex,
			'bloodtype'=>$this->bloodtype,
			'birthcity'=>$this->birthcity,
			'religion'=>$this->religion,
			'maritalstatus'=>$this->maritalstatus,
			'tribe'=>$this->tribe,
			'employeestatus'=>$this->employeestatus,
                'levelorg'=>$this->levelorg
		));
	}

	public function actionUpload()
	{
		parent::actionUpload();
		$folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploadgambar']['name']); 
		if (move_uploaded_file($_FILES['uploadgambar']['tmp_name'], $file)) { 
			echo "success"; 
			$row = 0;
			if (($handle = fopen($file, "r")) !== FALSE) {
			  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				if ($row>0) {
				  $employee = Employee::model()->findbyattributes(array('oldnik'=>$data[1]));
				  if ($employee == null)
				  {
					$addressbook = new Addressbook();
					$employee = new Employee();
				  }
				  else
				  {
					$addressbook = Addressbook::model()->findbypk($employee->addressbookid);
				  }
				  $addressbook->fullname = $data[0];
				  $addressbook->isapplicant=0;
				  $addressbook->isemployee=1;
				  $addressbook->recordstatus=1;
				  if ($addressbook->save())
				  {
					$employee->addressbookid = $addressbook->addressbookid;
				  }
				  $employee->fullname = $data[0];
				  $employee->oldnik = $data[1];
				  $structure = Orgstructure::model()->findbyattributes(array('structurename'=>$data[2]));
				  if ($structure != null)
				  {
					$employee->orgstructureid = $structure->orgstructureid; 
				  }
				  $position = Position::model()->findbyattributes(array('positionname'=>$data[3]));
				  if ($position != null)
				  {
					$employee->positionid = $position->positionid;
				  }
				  $employeetype = Employeetype::model()->findbyattributes(array('employeetypename'=>$data[4]));
				  if ($employeetype != null)
				  {
					$employee->employeetypeid = $employeetype->employeetypeid;
				  }
				  $sex = Sex::model()->findbyattributes(array('sexname'=>$data[5]));
				  if ($sex != null)
				  {
					$employee->sexid = $sex->sexid;
				  }
				  $birthcity = City::model()->findbyattributes(array('cityname'=>$data[6]));
				  if ($birthcity != null)
				  {
					$employee->birthcityid = $birthcity->cityid;
				  }
				  $employee->birthdate=$data[7];
				  $religion = Religion::model()->findbyattributes(array('religionname'=>$data[8]));
				  if ($religion != null)
				  {
					$employee->religionid = $religion->religionid;
				  }
				  $maritalstatus = Maritalstatus::model()->findbyattributes(array('maritalstatusname'=>$data[9]));
				  if ($maritalstatus != null)
				  {
					$employee->maritalstatusid = $maritalstatus->maritalstatusid;
				  }
				  $employee->referenceby = $data[10];
				  $employee->joindate=$data[11];
				  $employeestatus = Employeestatus::model()->findbyattributes(array('employeestatusname'=>$data[12]));
				  if ($employeestatus != null)
				  {
					$employee->employeestatusid = $employeestatus->employeestatusid;
				  }
				  $employee->istrial = $data[13];
				  $employee->barcode=$data[14];
				  $employee->photo=$data[15];
				  $levelorg = Levelorg::model()->findbyattributes(array('levelorgname'=>$data[17]));
				  if ($levelorg != null)
				  {
					$employee->levelorgid = $levelorg->levelorgid;
				  }
				  $employee->email = $data[18];
				  $employee->phoneno = $data[19];
				  $employee->alternateemail = $data[20];
				  $employee->hpno = $data[21];
				  $employee->taxno = $data[22];
				  $employee->dplkno = $data[23];
				  $employee->accountno = $data[24];
				  
				  try
				  {
					if(!$employee->save())
					{
					  echo $employee->getErrors();
					}
				  }
				  catch (Exception $e)
				  {
					echo $e->getMessage();;
				  }
				}
				$row++;
			  }
			  fclose($handle);
			}
		} else {
			echo "error";
		}	  
	}

	public function actionUploadphoto()
	{
		parent::actionUpload();
		$folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploadgambar']['name']); 
		if (move_uploaded_file($_FILES['uploadgambar']['tmp_name'], $file)) { 
			echo "success"; 
		} else {
			echo "error";
		}
	}

	public function actionDownload()
	{
	  parent::actionDownload();
	   $sql = "select a.employeeid,a.fullname, a.oldnik, b.levelorgname, c.structurename,d.positionname,e.employeetypename,
        f.sexname,joindate,email,phoneno,alternateemail,hpno,a.addressbookid,a.accountno,a.taxno,g.maritalstatusname,
        h.religionname,a.birthdate,i.cityname
      from employee a
      left join levelorg b on b.levelorgid = a.levelorgid
      left join orgstructure c on c.orgstructureid = a.orgstructureid
      left join position d on d.positionid = a.positionid
      left join employeetype e on e.employeetypeid = a.employeetypeid
      left join sex f on f.sexid = a.sexid
      left join maritalstatus g on g.maritalstatusid = a.maritalstatusid
      left join religion h on h.religionid = a.religionid
      left join city i on i.cityid = a.birthcityid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.employeeid = ".$_GET['id'];
		}
		$sql = $sql . " order by employeeid";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->title='Employee List';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',12);

	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    foreach($dataReader as $row)
    {
      if (file_exists($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'.$row['oldnik'].'.jpg'))
      {
        $this->pdf->Image($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'. $row['oldnik'] .'.jpg',10,30,30);
      }
      $this->pdf->setFont('Arial','B',10);
      $this->pdf->text(50,30,'Nama: '.$row['fullname']);
      $this->pdf->setFont('Arial','',8);
      $this->pdf->text(50,35,'Posisi: '.$row['positionname']);
      $this->pdf->text(50,40,'Struktur: '.$row['structurename']);
      $this->pdf->text(50,45,'Golongan: '.$row['levelorgname']);
      $this->pdf->text(50,50,'Tempat Tanggal Lahir: '.$row['cityname'].', '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['birthdate'])));
      $this->pdf->text(50,55,'Jenis Kelamin: '.$row['sexname']);
      $this->pdf->text(50,60,'Marital Status: '.$row['maritalstatusname']);
      $this->pdf->text(50,65,'Agama: '.$row['religionname']);
      $this->pdf->text(50,70,'Telp: '.$row['phoneno']);
      $this->pdf->text(50,75,'No HP: '.$row['hpno']);
      $this->pdf->text(50,80,'Email Utama: '.$row['email']);
      $this->pdf->text(50,85,'Email ke-2: '.$row['alternateemail']);
      $this->pdf->text(50,90,'No Rekening: '.$row['accountno']);
      $this->pdf->text(50,95,'NPWP: '.$row['taxno']);

      $sql1 = "select b.addresstypename, a.addressname, c.cityname, a.phoneno
        from address a
        left join addresstype b on b.addresstypeid = a.addresstypeid
        left join city c on c.cityid = a.cityid
        where addressbookid = ".$row['addressbookid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->text(10,100,'Address List');
      $this->pdf->SetY(105);
      $this->pdf->setaligns(array('C','C','C','C'));
      $this->pdf->setwidths(array(50,50,50,30));
      $this->pdf->Row(array('Address Type','Address','City','Phone No'));
      $this->pdf->setaligns(array('L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['addresstypename'],$row1['addressname'],$row1['cityname'],$row1['phoneno']));
      }

      $sql1 = "select b.educationname, a.schoolname, a.schooldegree, c.cityname, a.yeargraduate
        from employeeeducation a
        left join education b on b.educationid = a.educationid
        left join city c on c.cityid = a.cityid
        where employeeid = ".$row['employeeid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->text(10,$this->pdf->gety()+10,'Education List');
      $this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->setaligns(array('C','C','C','C','C'));
      $this->pdf->setwidths(array(50,50,30,30,30));
      $this->pdf->Row(array('Degree','School/Institut','Education Major','City','Year Graduate'));
      $this->pdf->setaligns(array('L','L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['educationname'],$row1['schoolname'],$row1['schooldegree'],$row1['cityname'],$row1['yeargraduate']));
      }
      
      $sql1 = "select a.informalname,a.organizer,a.period
        from employeeinformal a
        where employeeid = ".$row['employeeid']." and iswo=0";
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->text(10,$this->pdf->gety()+10,'Informal List');
      $this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->setaligns(array('C','C','C','C'));
      $this->pdf->setwidths(array(60,40,50));
      $this->pdf->Row(array('Course / Training / Skill', 'Organizer', 'Period'));
      $this->pdf->setaligns(array('L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['informalname'],$row1['organizer'],$row1['period']));
      }
      
      $sql1 = "select a.informalname,a.organizer,a.period,a.sponsoredby
        from employeeinformal a
        where employeeid = ".$row['employeeid']." and iswo=1";
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->text(10,$this->pdf->gety()+10,'Working Experience List');
      $this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->setaligns(array('C','C','C','C'));
      $this->pdf->setwidths(array(80,30,30,50));
      $this->pdf->Row(array('Company', 'Golongan','Position', 'Period'));
      $this->pdf->setaligns(array('L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['informalname'],$row1['sponsoredby'],$row1['organizer'],$row1['period']));
      }
      
      $sql1 = "select b.familyrelationname, a.familyname, c.cityname,
        d.sexname, a.birthdate, e.educationname, f.occupationname
        from employeefamily a
        left join familyrelation b on b.familyrelationid = a.familyrelationid
        left join city c on c.cityid = a.cityid
        left join sex d on d.sexid = a.sexid
        left join education e on e.educationid = a.educationid
        left join occupation f on f.occupationid = a.occupationid
        where employeeid = ".$row['employeeid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->text(10,$this->pdf->gety()+10,'Family Member');
      $this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->setaligns(array('C','C','C','C'));
      $this->pdf->setwidths(array(50,40,30,40,30,30,30));
      $this->pdf->Row(array('Family Relation', 'Family Name', 'Sex', 'Occupation','Birth Date'));
      $this->pdf->setaligns(array('L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['familyrelationname'],$row1['familyname'],$row1['sexname'],$row1['occupationname'],
date(Yii::app()->params['dateviewfromdb'], strtotime($row1['birthdate']))
	));
      }
      
      $sql1 = "select b.identitytypename, a.identityname
        from employeeidentity a
        left join identitytype b on b.identitytypeid = a.identitytypeid
        where a.employeeid = ".$row['employeeid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->text(10,$this->pdf->gety()+10,'Identity List');
      $this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->setaligns(array('C','C','C','C'));
      $this->pdf->setwidths(array(60,50));
      $this->pdf->Row(array('Identity Type', 'Identity Name'));
      $this->pdf->setaligns(array('L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['identitytypename'],$row1['identityname']));
      }
      
      $sql1 = "select b.languagename,c.languagevaluename
        from employeeforeignlanguage a
        left join language b on b.languageid = a.languageid
        left join languagevalue c on c.languagevalueid = a.languagevalueid
        where a.employeeid = ".$row['employeeid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->text(10,$this->pdf->gety()+10,'Language Skill');
      $this->pdf->sety($this->pdf->gety()+15);
      $this->pdf->setaligns(array('C','C','C','C'));
      $this->pdf->setwidths(array(60,50));
      $this->pdf->Row(array('Language', 'Language Value'));
      $this->pdf->setaligns(array('L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['languagename'],$row1['languagevaluename']));
      }
      $this->pdf->AddPage('P');
    }
	  $this->pdf->Output();
	  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Employee::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='employee-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

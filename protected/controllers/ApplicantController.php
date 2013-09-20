<?php

class ApplicantController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'applicant';

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
		$religion,$maritalstatus,$tribe,$employeestatus;
	
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
	  $model=new Applicant;
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
				'employeestatus'=>$this->employeestatus), true)
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
			  'orgstructureid'=>$model->orgstructureid,
			  'structurename'=>($model->orgstructure!==null)?$model->orgstructure->structurename:"",
			  'positionid'=>$model->positionid,
			  'positionname'=>($model->position!==null)?$model->position->positionname:"",
			  'employeetypeid'=>$model->employeetypeid,
			  'employeetypename'=>($model->employeetype!==null)?$model->employeetype->employeetypename:"",
			  'sexid'=>$model->sexid,
			  'sexname'=>($model->sex!==null)?$model->sex->sexname:"",
			  'bloodtypeid'=>$model->bloodtypeid,
			  'bloodtypename'=>($model->bloodtype!==null)?$model->bloodtype->bloodtypename:"",
			  'birthcityid'=>$model->birthcityid,
			  'birthcityname'=>($model->birthcity!==null)?$model->birthcity->cityname:"",
			  'birthdate'=>$model->birthdate,
			  'religionid'=>$model->religionid,
			  'religionname'=>($model->religion!==null)?$model->religion->religionname:"",
			  'maritalstatusid'=>$model->maritalstatusid,
			  'maritalstatusname'=>($model->maritalstatus!==null)?$model->maritalstatus->maritalstatusname:"",
			  'tribeid'=>$model->tribeid,
			  'tribename'=>($model->tribe!==null)?$model->tribe->tribename:"",
			  'referenceby'=>$model->referenceby,
			  'joindate'=>$model->joindate,
			  'employeestatusid'=>$model->employeestatusid,
			  'employeestatusname'=>($model->employeestatus!==null)?$model->employeestatus->employeestatusname:"",
			  'istrial'=>$model->istrial,
			  'bodyheight'=>$model->bodyheight,
			  'bodyweight'=>$model->bodyweight,
			  'dresssize'=>$model->dresssize,
			  'resigndate'=>$model->resigndate,
			  'shoesize'=>$model->shoesize,
			  'recordstatus'=>($model->addressbook!==null)?$model->addressbook->recordstatus:"",
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
				'orgstructure'=>$this->orgstructure,
				'position'=>$this->position,
				'employeetype'=>$this->employeetype,
				'sex'=>$this->sex,
				'bloodtype'=>$this->bloodtype,
				'birthcity'=>$this->birthcity,
				'religion'=>$this->religion,
				'maritalstatus'=>$this->maritalstatus,
				'tribe'=>$this->tribe,
				'employeestatus'=>$this->employeestatus), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Applicant'], $_POST['Applicant']['employeeid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Applicant']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Applicant']['fullname'],'hrapemptyfullname','emptystring'),
                    array($_POST['Applicant']['orgstructureid'],'hrapemptyorgstructureid','emptystring'),
                    array($_POST['Applicant']['positionid'],'hrapemptypositionid','emptystring'),
            )
        );
        if ($messages == '') {
		  //$dataku->attributes=$_POST['Applicant'];
		  if ((int)$_POST['Applicant']['employeeid'] > 0)
		  {
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
			  $sql = 'call UpdateApplicant(:vemployeeid,:vemployeename,
				:voldnik,:vorgstructureid,:vpositionid,:vemployeetypeid,
				:vsexid, :vbloodtypeid, :vbirthcityid, :vbirthdate,
				:vreligionid, :vmaritalstatusid, :vtribeid, :vreferenceby,
				:vjoindate, :vemployeestatusid, :vistrial, :vbodyheight, :vbodyweight, :vdresssize,
				:vshoesize, :vlastupdateby)';
			  $command=$connection->createCommand($sql);
			  $command->bindParam(':vemployeeid',$_POST['Applicant']['employeeid'],PDO::PARAM_INT);
			  $command->bindParam(':vemployeename',$_POST['Applicant']['fullname'],PDO::PARAM_STR);
			  $command->bindParam(':voldnik',$_POST['Applicant']['oldnik'],PDO::PARAM_INT);
			  $command->bindParam(':vorgstructureid',$_POST['Applicant']['orgstructureid'],PDO::PARAM_INT);
			  $command->bindParam(':vpositionid',$_POST['Applicant']['positionid'],PDO::PARAM_INT);
			  $command->bindParam(':vemployeetypeid',$_POST['Applicant']['employeetypeid'],PDO::PARAM_INT);
			  $command->bindParam(':vsexid',$_POST['Applicant']['sexid'],PDO::PARAM_INT);
			  $command->bindParam(':vbloodtypeid',$_POST['Applicant']['bloodtypeid'],PDO::PARAM_INT);
			  $command->bindParam(':vbirthcityid',$_POST['Applicant']['birthcityid'],PDO::PARAM_INT);
			  $command->bindParam(':vbirthdate',$_POST['Applicant']['birthdate'],PDO::PARAM_STR);
			  $command->bindParam(':vreligionid',$_POST['Applicant']['religionid'],PDO::PARAM_INT);
			  $command->bindParam(':vmaritalstatusid',$_POST['Applicant']['maritalstatusid'],PDO::PARAM_INT);
			  $command->bindParam(':vtribeid',$_POST['Applicant']['tribeid'],PDO::PARAM_INT);
			  $command->bindParam(':vreferenceby',$_POST['Applicant']['referenceby'],PDO::PARAM_INT);
			  $command->bindParam(':vjoindate',$_POST['joindate'],PDO::PARAM_STR);
			  $command->bindParam(':vemployeestatusid',$_POST['Applicant']['employeestatusid'],PDO::PARAM_INT);
			  $command->bindParam(':vistrial',$_POST['Applicant']['istrial'],PDO::PARAM_INT);
			  $command->bindParam(':vbodyheight',$_POST['Applicant']['bodyheight'],PDO::PARAM_INT);
			  $command->bindParam(':vbodyweight',$_POST['Applicant']['bodyweight'],PDO::PARAM_INT);
			  $command->bindParam(':vdresssize',$_POST['Applicant']['dresssize'],PDO::PARAM_STR);
			  $command->bindParam(':vshoesize',$_POST['Applicant']['shoesize'],PDO::PARAM_STR);
			  $post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
			  $command->bindParam(':vlastupdateby', $post,PDO::PARAM_INT);
			  $command->execute();
			  $transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Applicant']['employeeid']);
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
			$model = new Applicant();
			$model->attributes=$_POST['Applicant'];
			$connection=Yii::app()->db;
			$transaction=$connection->beginTransaction();
			try
			{
			  $sql = 'select InsertApplicant(:vemployeename,
				:voldnik,:vorgstructureid,:vpositionid,:vemployeetypeid,
				:vsexid, :vbloodtypeid, :vbirthcityid, :vbirthdate,
				:vreligionid, :vmaritalstatusid, :vtribeid, :vreferenceby,
				:vjoindate, :vemployeestatusid, :vistrial, :vbodyheight, :vbodyweight, :vdresssize,
				:vshoesize, :vcreatedby)';
			  $command=$connection->createCommand($sql);
			  $command->bindParam(':vemployeename',$_POST['Applicant']['fullname'],PDO::PARAM_STR);
			  $command->bindParam(':voldnik',$_POST['Applicant']['oldnik'],PDO::PARAM_INT);
			  $command->bindParam(':vorgstructureid',$_POST['Applicant']['orgstructureid'],PDO::PARAM_INT);
			  $command->bindParam(':vpositionid',$_POST['Applicant']['positionid'],PDO::PARAM_INT);
			  $command->bindParam(':vemployeetypeid',$_POST['Applicant']['employeetypeid'],PDO::PARAM_INT);
			  $command->bindParam(':vsexid',$_POST['Applicant']['sexid'],PDO::PARAM_INT);
			  $command->bindParam(':vbloodtypeid',$_POST['Applicant']['bloodtypeid'],PDO::PARAM_INT);
			  $command->bindParam(':vbirthcityid',$_POST['Applicant']['birthcityid'],PDO::PARAM_INT);
			  $command->bindParam(':vbirthdate',$_POST['Applicant']['birthdate'],PDO::PARAM_STR);
			  $command->bindParam(':vreligionid',$_POST['Applicant']['religionid'],PDO::PARAM_INT);
			  $command->bindParam(':vmaritalstatusid',$_POST['Applicant']['maritalstatusid'],PDO::PARAM_INT);
			  $command->bindParam(':vtribeid',$_POST['Applicant']['tribeid'],PDO::PARAM_INT);
			  $command->bindParam(':vreferenceby',$_POST['Applicant']['referenceby'],PDO::PARAM_INT);
			  $command->bindParam(':vjoindate',$_POST['joindate'],PDO::PARAM_STR);
			  $command->bindParam(':vemployeestatusid',$_POST['Applicant']['employeestatusid'],PDO::PARAM_INT);
			  $command->bindParam(':vistrial',$_POST['Applicant']['istrial'],PDO::PARAM_INT);
			  $command->bindParam(':vbodyheight',$_POST['Applicant']['bodyheight'],PDO::PARAM_INT);
			  $command->bindParam(':vbodyweight',$_POST['Applicant']['bodyweight'],PDO::PARAM_INT);
			  $command->bindParam(':vdresssize',$_POST['Applicant']['dresssize'],PDO::PARAM_STR);
			  $command->bindParam(':vshoesize',$_POST['Applicant']['shoesize'],PDO::PARAM_STR);
			  $post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
			  $command->bindParam(':vcreatedby', $post,PDO::PARAM_INT);
			  $command->execute();
			  $transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Applicant']['employeeid']);
			  $this->GetSMessage('hrapinsertsuccess');
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
		$model->recordstatus=0;
		$model->save();
	  }
	  echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>'Data deleted'
			  ));
	  Yii::app()->end();
	}

	public function actionApprove()
	{
	  parent::actionApprove();
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=$this->loadModel($ids);
		  $connection=Yii::app()->db;
		  $transaction=$connection->beginTransaction();
		  try
		  {
			$sql = 'call ApplicantGraduation(:vemployeeid, :vlastupdateby)';
			$command=$connection->createCommand($sql);
			$command->bindParam(':vemployeeid',$model->employeeid,PDO::PARAM_INT);
			$command->bindParam(':vlastupdateby', Yii::app()->user->name,PDO::PARAM_STR);
			$command->execute();
			$transaction->commit();
			if (Yii::app()->request->isAjaxRequest)
			{
				echo CJSON::encode(array(
				  'status'=>'success',
				  'div'=>"Data saved"
				));
			}
		  }
		  catch(Exception $e) // an exception is raised if a query fails
		  {
			  $transaction->rollBack();
			  if (Yii::app()->request->isAjaxRequest)
			  {
				  echo CJSON::encode(array(
					'status'=>'failure',
					'div'=>$e->getMessage()
				  ));
			  }
		  }
		}
        Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();

	  $model=new Applicant('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicant']))
		  $model->attributes=$_GET['Applicant'];
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
				'employeestatus'=>$this->employeestatus
	  ));
	}

	public function actionUpload()
	{
      parent::actionUpload();
	  Yii::import("ext.EAjaxUpload.qqFileUploader");
	  $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
	  $allowedExtensions = array("csv");
	  $sizeLimit = (int)Yii::app()->params['sizeLimit'];// maximum file size in bytes
	  $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	  $result = $uploader->handleUpload($folder,true);
	  $row = 0;
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model1=Addressbook::model()->findByPk((int)$data[2]);
			  if ($model1===null){
				$model1=new Addressbook();
			  }
			  $model1->addressbookid=(int)$data[2];
			  $model1->fullname=$data[3];
			  $model1->isapplicant=1;
			  $model1->isemployee=0;
			  $model1->recordstatus=1;
			  $model1->save();

			  $model=Applicant::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Applicant();
			  }
			  $model->employeeid = (int)$data[0];
			  $model->fullname = $data[1];
			  $model->addressbookid = $model1->addressbookid;
			  $model->oldnik = $data[3];
			  $model->newnik = $data[4];
			  $model->orgstructureid = $data[5];
			  $model->positionid = $data[6];
			  $model->employeetypeid = $data[7];
			  $model->sexid = $data[8];
			  $model->bloodtypeid = $data[9];
			  $model->birthcityid = $data[10];
			  $model->birthdate = $data[11];
			  $model->religionid = $data[12];
			  $model->maritalstatusid = $data[13];
			  $model->tribeid = $data[14];
			  $model->referenceby = $data[15];
			  $model->joindate = $data[16];
			  $model->employeestatusid = $data[17];
			  $model->istrial = $data[18];
			  $model->barcode = $data[19];
			  $model->photo = $data[20];
			  $model->bodyheight = $data[21];
			  $model->bodyweight = $data[22];
			  $model->dresssize = $data[23];
			  $model->resigndate = $data[24];
			  $model->shoesize = $data[25];
			  try
			  {
				if(!$model->save())
				{
				  $errormessage=$model->getErrors();
				  if (Yii::app()->request->isAjaxRequest)
				  {
					echo CJSON::encode(array(
					  'status'=>'failure',
					  'div'=>$errormessage
					));
				  }
				}
			  }
			  catch (Exception $e)
			  {
				$errormessage=$e->getMessage();
				if (Yii::app()->request->isAjaxRequest)
				  {
					echo CJSON::encode(array(
					  'status'=>'failure',
					  'div'=>$errormessage
					));
				  }
			  }
			}
			$row++;
		  }
		  fclose($handle);
	  }
	  $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	  echo $result;
  }

	public function actionDownload()
	{
	  parent::actionDownload();
	  Yii::import('application.extensions.fpdf.*');
	  require_once("pdf.php");
	  $pdf = new PDF();
	  $pdf->title='Applicant List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $header = array('No','ID','Full Name','Old Nik','New Nik','Structure');
	  $model=new Applicant('searchwstatus');
	  $dataprovider=$model->searchwstatus();
	  $dataprovider->pagination=false;
	  $data = $dataprovider->getData();
	  $cols = $dataprovider->getKeys();
	  $dataku=array(count($data));
	  //var_dump($dataku);
	  $w= array(10,10,30,40,40,40);

	  $pdf->SetTableHeader();
	  //Header
	  for($i=0;$i<count($header);$i++)
		  $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
	  $pdf->Ln();
	  $pdf->SetTableData();
	  //Data
	  $fill=false;
	  $i=0;
	  foreach($data as $datas)
	  {
		  $i=$i+1;
		  $pdf->Cell($w[0],6,$i,'LR',0,'L',$fill);
		  $pdf->Cell($w[1],6,$datas['employeeid'],'LR',0,'C',$fill);
		  $pdf->Cell($w[2],6,$datas['fullname'],'LR',0,'C',$fill);
		  $pdf->Cell($w[3],6,$datas['oldnik'],'LR',0,'C',$fill);
		  $pdf->Cell($w[4],6,$datas['newnik'],'LR',0,'C',$fill);
		  $pdf->Cell($w[5],6,Orgstructure::model()->findByPk($datas['orgstructureid'])->structurename,'LR',0,'C',$fill);
		  $pdf->Ln();
		  $fill=!$fill;
	  }
	  $pdf->Cell(array_sum($w),0,'','T');


	  // me-render ke browser
	  $pdf->Output();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Applicant::model()->findByPk((int)$id);
    $model->imagephoto = $model->photo;
    $model->imagebarcode = $model->barcode;
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

<?php

class ApplicanteducationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'applicanteducation';

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

	public $employee,$city,$education;
	
	public function lookupdata()
	{
	  $this->employee=new Applicant('searchwstatus');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicant']))
		$this->employee->attributes=$_GET['Applicant'];

	  $this->city=new City('searchwstatus');
	  $this->city->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$this->city->attributes=$_GET['City'];

	  $this->education=new Education('searchwstatus');
	  $this->education->unsetAttributes();  // clear any default values
	  if(isset($_GET['Education']))
		$this->education->attributes=$_GET['Education'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
	  $model=new Applicanteducation;

	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			'status'=>'success',
			'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
			  'employee'=>$this->employee,
			  'city'=>$this->city,
			  'education'=>$this->education), true)
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
			'employeeeducationid'=>$model->employeeeducationid,
			'employeeid'=>$model->employeeid,
			'fullname'=>$model->applicant->fullname,
			'educationid'=>$model->educationid,
			'educationname'=>$model->education->educationname,
			'schoolname'=>$model->schoolname,
			'cityid'=>$model->cityid,
			'cityname'=>$model->city->cityname,
			'yeargraduate'=>$model->yeargraduate,
			'isdiploma'=>$model->isdiploma,
			'recordstatus'=>$model->recordstatus,
			'div'=>$this->renderPartial('_form', array('model'=>$model,
			  'employee'=>$this->employee,
			  'city'=>$this->city,
			  'education'=>$this->education), true)
			));
		Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Applicanteducation'], $_POST['Applicanteducation']['employeeeducationid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Applicanteducation']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Applicanteducation']['employeeid'],'hrapeemptyemployeeid','emptystring'),
                array($_POST['Applicanteducation']['educationid'],'hrapeemptyeducationid','emptystring'),
                array($_POST['Applicanteducation']['schoolname'],'hrapeemptyschoolname','emptystring'),
                array($_POST['Applicanteducation']['cityid'],'hrapeemptycityid','emptystring'),
                array($_POST['Applicanteducation']['yeargraduate'],'hrapeemptyyeargraduate','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Applicanteducation'];
		if ((int)$_POST['Applicanteducation']['employeeeducationid'] > 0)
		{
		  $model=$this->loadModel($_POST['Applicanteducation']['employeeeducationid']);
		  $model->employeeid = $_POST['Applicanteducation']['employeeid'];
		  $model->educationid = $_POST['Applicanteducation']['educationid'];
		  $model->schoolname = $_POST['Applicanteducation']['schoolname'];
		  $model->cityid = $_POST['Applicanteducation']['cityid'];
		  $model->yeargraduate = $_POST['Applicanteducation']['yeargraduate'];
		  $model->isdiploma = $_POST['Applicanteducation']['isdiploma'];
		  $model->recordstatus = $_POST['Applicanteducation']['recordstatus'];
		}
		else
		{
		  $model = new Applicanteducation();
		  $model->attributes=$_POST['Applicanteducation'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Applicanteducation']['employeeeducationid']);
              $this->GetSMessage('hrapeinsertsuccess');
            }
            else
            {
              $this->GetMessage($model->getErrors());
            }
          }
          catch (Exception $e)
          {
            $this->GetMessage($e->getMessage());
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
	  $this->lookupdata();
	  $model=new Applicanteducation('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicanteducation']))
		  $model->attributes=$_GET['Applicanteducation'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
			'model'=>$model,
			  'employee'=>$this->employee,
			  'city'=>$this->city,
			  'education'=>$this->education
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
			  $model=Applicanteducation::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Applicanteducation();
			  }
			  $model->employeeeducationid = (int)$data[0];
			  $model->employeeid = $data[1];
			  $model->educationid = $data[2];
			  $model->schoolname = $data[3];
			  $model->cityid = (int)$data[4];
			  $model->yeargraduate = (int)$data[5];
				$model->isdiploma=(int)$data[6];
				$model->recordstatus=(int)$data[7];
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
	  $pdf->title='Applicant Education List';
	  $pdf->AddPage('L');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $header = array('No','ID','Applicant Name','Education Name','School Name',
		'City Name','Year Graduate','Is Diploma');
	  $model=new Applicanteducation('searchwstatus');
	  $dataprovider=$model->searchwstatus();
	  $dataprovider->pagination=false;
	  $data = $dataprovider->getData();
	  $cols = $dataprovider->getKeys();
	  $dataku=array(count($data));
	  //var_dump($dataku);
	  $w= array(10,10,50,50,40,45,45,20);

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
		  $pdf->Cell($w[1],6,$datas['employeeeducationid'],'LR',0,'C',$fill);
		  $pdf->Cell($w[2],6,Applicant::model()->findByPk($datas['employeeid'])->fullname,'LR',0,'L',$fill);
		  $pdf->Cell($w[3],6,Education::model()->findByPk($datas['educationid'])->educationname,'LR',0,'L',$fill);
		  $pdf->Cell($w[4],6,$datas['schoolname'],'LR',0,'L',$fill);
		  $pdf->Cell($w[5],6,City::model()->findByPk($datas['cityid'])->cityname,'LR',0,'L',$fill);
		  $pdf->Cell($w[6],6,$datas['yeargraduate'],'LR',0,'C',$fill);
		  if ($datas['isdiploma'] == 1) {
				$pdf->Cell($w[7],6,'V','LR',0,'C',$fill);
		  } else {
				$pdf->Cell($w[7],6,'','LR',0,'C',$fill);
			}
		  $pdf->Ln();
		  $fill=!$fill;
	  }
	  $pdf->Cell(array_sum($w),0,'','T');


	  // me-render ke browser
	  $pdf->Output('applicanteducation.pdf','D');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Applicanteducation::model()->findByPk((int)$id);
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
	  if(isset($_POST['ajax']) && $_POST['ajax']==='applicanteducation-form')
	  {
		  echo CActiveForm::validate($model);
		  Yii::app()->end();
	  }
	}
}

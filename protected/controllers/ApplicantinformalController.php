<?php

class ApplicantinformalController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'applicantinformal';

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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
    $applicant=new Applicant('searchwstatus');
    $applicant->unsetAttributes();  // clear any default values
    if(isset($_GET['Applicant']))
      $applicant->attributes=$_GET['Applicant'];

		$model=new Applicantinformal;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
      'applicant'=>$applicant), true)
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
    $applicant=new Applicant('searchwstatus');
    $applicant->unsetAttributes();  // clear any default values
    if(isset($_GET['Applicant']))
      $applicant->attributes=$_GET['Applicant'];

		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'employeeinformalid'=>$model->employeeinformalid,
				'employeeid'=>$model->employeeid,
				'fullname'=>$model->applicant->fullname,
				'informalname'=>$model->informalname,
				'organizer'=>$model->organizer,
				'period'=>$model->period,
				'isdiploma'=>$model->isdiploma,
				'sponsoredby'=>$model->sponsoredby,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
      'applicant'=>$applicant), true)
				));
            Yii::app()->end();
        }
        }
	}

        public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Applicantinformal'], $_POST['Applicantinformal']['employeeinformalid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Applicantinformal']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Applicantinformal']['employeeid'],'hrapinemptyemployeeid','emptystring'),
                array($_POST['Applicantinformal']['informalname'],'hrapinemptyinformalname','emptystring'),
                array($_POST['Applicantinformal']['organizer'],'hrapinemptyorganizer','emptystring'),
                array($_POST['Applicantinformal']['period'],'hrapinemptyperiod','emptystring'),
                array($_POST['Applicantinformal']['sponsoredby'],'hrapinemptysponsoredby','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Applicantinformal'];
		if ((int)$_POST['Applicantinformal']['employeeinformalid'] > 0)
		{
		  $model=$this->loadModel($_POST['Applicantinformal']['employeeinformalid']);
		  $model->employeeid = $_POST['Applicantinformal']['employeeid'];
		  $model->informalname = $_POST['Applicantinformal']['informalname'];
		  $model->organizer = $_POST['Applicantinformal']['organizer'];
		  $model->period = $_POST['Applicantinformal']['period'];
		  $model->isdiploma = $_POST['Applicantinformal']['isdiploma'];
		  $model->sponsoredby = $_POST['Applicantinformal']['sponsoredby'];
		  $model->recordstatus = $_POST['Applicantinformal']['recordstatus'];
		}
		else
		{
		  $model = new Applicantinformal();
		  $model->attributes=$_POST['Applicantinformal'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Applicantinformal']['employeeinformalid']);
              $this->GetSMessage('hrapininsertsuccess');
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
	  $applicant=new Applicant('searchwstatus');
    $applicant->unsetAttributes();  // clear any default values
    if(isset($_GET['Applicant']))
      $applicant->attributes=$_GET['Applicant'];
		$model=new Applicantinformal('searchwstatus');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Applicantiinformal']))
			$model->attributes=$_GET['Applicantiinformal'];
			if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
      'applicant'=>$applicant
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
			  $model=Applicantinformal::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Applicantinformal();
			  }
			  $model->employeeinformalid = (int)$data[0];
			  $model->employeeid = (int)$data[1];
			  $model->informalname = $data[2];
			  $model->organizer = $data[3];
			  $model->period = (int)$data[4];
			  $model->isdiploma = (int)$data[5];
			  $model->sponsoredby = $data[6];
			  $model->recordstatus = (int)$data[7];
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
    $pdf->title='Applicant Informal List';
    $pdf->AddPage('L');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Applicant Name','Informal Name','Organizer','Period','Is Diploma','Sponsored By');
    $model=new Applicantinformal('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($dataku);
    $w= array(20,15,30,40,40,40,40,40);

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
        $pdf->Cell($w[1],6,$datas['employeeinformalid'],'LR',0,'C',$fill);
        $pdf->Cell($w[2],6,Applicant::model()->findByPk($datas['employeeid'])->fullname,'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,$datas['informalname'],'LR',0,'L',$fill);
        $pdf->Cell($w[4],6,$datas['organizer'],'LR',0,'L',$fill);
        $pdf->Cell($w[5],6,$datas['period'],'LR',0,'L',$fill);
        if ($datas['isdiploma'] == 1)
        {
          $pdf->Cell($w[6],6,$pdf->Image('images/approved.jpg',$pdf->GetX()+5,$pdf->GetY()),'LR',0,'L');
        }
        $pdf->Cell($w[7],6,$datas['sponsoredby'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');


    // me-render ke browser
    $pdf->Output('applicantinformal.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Applicantinformal::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeeinformal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

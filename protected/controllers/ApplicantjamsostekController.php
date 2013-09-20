<?php

class ApplicantjamsostekController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'applicantjamsostek';

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

	public $applicant;
	
	public function lookupdata()
	{
	  $this->applicant=new Applicant('searchwstatus');
	  $this->applicant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicant']))
		$this->applicant->attributes=$_GET['Applicant'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
	  $model=new Applicantjamsostek;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
		  'applicant'=>$this->applicant), true)
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
			  'employeejamsostekid'=>$model->employeejamsostekid,
			  'employeeid'=>$model->employeeid,
			  'fullname'=>$model->applicant->fullname,
			  'jamsostekdate'=>$model->jamsostekdate,
			  'jamsostekno'=>$model->jamsostekno,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
		  'applicant'=>$this->applicant), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Applicantjamsostek'], $_POST['Applicantjamsostek']['employeejamsostekid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Applicantjamsostek']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Applicantjamsostek']['employeeid'],'hrapjemptyemployeeid','emptystring'),
                array($_POST['Applicantjamsostek']['jamsostekdate'],'hrapjemptyjamsostekdate','emptystring'),
                array($_POST['Applicantjamsostek']['jamsostekno'],'hrapjemptyjamsostekno','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Applicantjamsostek'];
		if ((int)$_POST['Applicantjamsostek']['employeejamsostekid'] > 0)
		{
		  $model=$this->loadModel($_POST['Applicantjamsostek']['employeejamsostekid']);
		  $model->employeeid = $_POST['Applicantjamsostek']['employeeid'];
		  $model->jamsostekdate = $_POST['Applicantjamsostek']['jamsostekdate'];
		  $model->jamsostekno = $_POST['Applicantjamsostek']['jamsostekno'];
		  $model->recordstatus = $_POST['Applicantjamsostek']['recordstatus'];
		}
		else
		{
		  $model = new Applicantjamsostek();
		  $model->attributes=$_POST['Applicantjamsostek'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Applicantjamsostek']['employeejamsostekid']);
              $this->GetSMessage('hrapjinsertsuccess');
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
	  $model=new Applicantjamsostek('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicantjamsostek']))
			$model->attributes=$_GET['Applicantjamsostek'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		'model'=>$model,
		'applicant'=>$this->applicant
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
			  $model=Applicantjamsostek::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Applicantjamsostek();
			  }
			  $model->employeejamsostekid = (int)$data[0];
			  $model->employeeid = (int)$data[1];
			  $model->jamsostekdate = $data[2];
			  $model->jamsostekno = $data[3];
			  $model->recordstatus = (int)$data[4];
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
    $pdf->title='Applicant Jamsostek List';
    $pdf->AddPage('P');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Applicant Name','Jamsostek Date','Jamsostek No');
    $model=new Applicantjamsostek('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($dataku);
    $w= array(20,25,50,30,50);

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
        $pdf->Cell($w[1],6,$datas['employeejamsostekid'],'LR',0,'L',$fill);
        $pdf->Cell($w[2],6,Applicant::model()->findByPk($datas['employeeid'])->fullname,'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,$datas['jamsostekdate'],'LR',0,'L',$fill);
        $pdf->Cell($w[4],6,$datas['jamsostekno'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');
    // me-render ke browser
    $pdf->Output('applicantjamsostek.pdf','D');
  }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Applicantjamsostek::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='applicantjamsostek-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

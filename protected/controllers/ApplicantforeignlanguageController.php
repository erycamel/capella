<?php

class ApplicantforeignlanguageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'applicantforeignlanguage';

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
	
	public $applicant,$language,$languagevalue;

	public function lookupdata()
	{
	  $this->applicant=new Applicant('searchwstatus');
	  $this->applicant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicant']))
		$this->applicant->attributes=$_GET['Applicant'];

	  $this->language=new Language('searchwstatus');
	  $this->language->unsetAttributes();  // clear any default values
	  if(isset($_GET['Language']))
		$this->language->attributes=$_GET['Language'];

	  $this->languagevalue=new Languagevalue('searchwstatus');
	  $this->languagevalue->unsetAttributes();  // clear any default values
	  if(isset($_GET['Languagevalue']))
		$this->languagevalue->attributes=$_GET['Languagevalue'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
	  $model=new Applicantforeignlanguage;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			'status'=>'success',
			'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
			  'applicant'=>$this->applicant,
			  'language'=>$this->language,
			  'languagevalue'=>$this->languagevalue), true)
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
			'employeeforeignlanguageid'=>$model->employeeforeignlanguageid,
			'employeeid'=>$model->employeeid,
			'fullname'=>$model->applicant->fullname,
			'languageid'=>$model->languageid,
			'languagename'=>$model->language->languagename,
			'languagevalueid'=>$model->languagevalueid,
			'languagevaluename'=>$model->languagevalue->languagevaluename,
			'recordstatus'=>$model->recordstatus,
			'div'=>$this->renderPartial('_form', array('model'=>$model,
			  'applicant'=>$this->applicant,
			  'language'=>$this->language,
			  'languagevalue'=>$this->languagevalue), true)
			));
		Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Applicantforeignlanguage'], $_POST['Applicantforeignlanguage']['employeeid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Applicantforeignlanguage']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Applicantforeignlanguage']['employeeid'],'hrapfremptyemployeeid','emptystring'),
                array($_POST['Applicantforeignlanguage']['languageid'],'hrpafremptylanguageid','emptystring'),
                array($_POST['Applicantforeignlanguage']['languagevalueid'],'hrpafremptylanguagevalueid','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Applicantforeignlanguage'];
		if ((int)$_POST['Applicantforeignlanguage']['employeeforeignlanguageid'] > 0)
		{
		  $model=$this->loadModel($_POST['Applicantforeignlanguage']['employeeforeignlanguageid']);
		  $model->employeeid = $_POST['Applicantforeignlanguage']['employeeid'];
		  $model->languageid = $_POST['Applicantforeignlanguage']['languageid'];
		  $model->languagevalueid = $_POST['Applicantforeignlanguage']['languagevalueid'];
		  $model->recordstatus = $_POST['Applicantforeignlanguage']['recordstatus'];
		}
		else
		{
		  $model = new Applicantforeignlanguage();
		  $model->attributes=$_POST['Applicantforeignlanguage'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Applicantforeignlanguage']['employeeforeignlanguageid']);
              $this->GetSMessage('hrpafrinsertsuccess');
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
	  $model=new Applicantforeignlanguage('searchwstatus');
		$model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicantforeignlanguage']))
		  $model->attributes=$_GET['Applicantforeignlanguage'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		'model'=>$model,
		'applicant'=>$this->applicant,
		'language'=>$this->language,
		'languagevalue'=>$this->languagevalue
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
			  $model=Applicantforeignlanguage::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Applicantforeignlanguage();
			  }
			  $model->employeeforeignlanguageid = (int)$data[0];
			  $model->employeeid = (int)$data[1];
			  $model->languageid = (int)$data[2];
			  $model->languagevalueid = (int)$data[3];
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
	  $pdf->title='Applicant Foreign Language List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $header = array('No','ID','Applicant Name','Language Name','Language Value');
	  $model=new Applicantforeignlanguage('searchwstatus');
	  $dataprovider=$model->searchwstatus();
	  $dataprovider->pagination=false;
	  $data = $dataprovider->getData();
	  $cols = $dataprovider->getKeys();
	  $dataku=array(count($data));
	  //var_dump($dataku);
	  $w= array(10,15,30,40,40);

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
		  $pdf->Cell($w[1],6,$datas['employeeforeignlanguageid'],'LR',0,'C',$fill);
		  $pdf->Cell($w[2],6,Applicant::model()->findByPk($datas['employeeid'])->fullname,'LR',0,'L',$fill);
		  $pdf->Cell($w[3],6,Language::model()->findByPk($datas['languageid'])->languagename,'LR',0,'L',$fill);
		  $pdf->Cell($w[4],6,Languagevalue::model()->findByPk($datas['languagevalue'])->languagevaluename,'LR',0,'L',$fill);
		  $pdf->Ln();
		  $fill=!$fill;
	  }
	  $pdf->Cell(array_sum($w),0,'','T');


	  // me-render ke browser
	  $pdf->Output('applicantforeignlanguage.pdf','D');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Applicantforeignlanguage::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeeforeignlanguage-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

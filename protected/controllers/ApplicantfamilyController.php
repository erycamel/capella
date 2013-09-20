<?php

class ApplicantfamilyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'applicantfamily';

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

	public $applicant,$familyrelation,$sex,$city,$education,$occupation;

	public function lookupdata()
	{
	  $this->applicant=new Applicant('searchwstatus');
	  $this->applicant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicant']))
		$this->applicant->attributes=$_GET['Applicant'];

	  $this->familyrelation=new Familyrelation('searchwstatus');
	  $this->familyrelation->unsetAttributes();  // clear any default values
	  if(isset($_GET['Familyrelation']))
		$this->familyrelation->attributes=$_GET['Familyrelation'];

	  $this->sex=new Sex('searchwstatus');
	  $this->sex->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sex']))
		$this->sex->attributes=$_GET['Sex'];

	  $this->city=new City('searchwstatus');
	  $this->city->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$this->city->attributes=$_GET['City'];

	  $this->education=new Education('searchwstatus');
	  $this->education->unsetAttributes();  // clear any default values
	  if(isset($_GET['Education']))
		$this->education->attributes=$_GET['Education'];

	  $this->occupation=new Occupation('searchwstatus');
	  $this->occupation->unsetAttributes();  // clear any default values
	  if(isset($_GET['Occupation']))
		$this->occupation->attributes=$_GET['Occupation'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
	  $model=new Applicantfamily;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			'status'=>'success',
			'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
			  'applicant'=>$this->applicant,
			  'familyrelation'=>$this->familyrelation,
			  'sex'=>$this->sex,
			  'city'=>$this->city,
			  'education'=>$this->education,
			  'occupation'=>$this->occupation), true)
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
			'employeefamilyid'=>$model->employeefamilyid,
			'employeeid'=>$model->employeeid,
			'employeename'=>$model->applicant->fullname,
			'familyrelationid'=>$model->familyrelationid,
			'familyrelationname'=>$model->familyrelation->familyrelationname,
			'familyname'=>$model->familyname,
			'sexid'=>$model->sexid,
			'sexname'=>$model->sex->sexname,
			'cityid'=>$model->cityid,
			'cityname'=>$model->city->cityname,
			'birthdate'=>$model->birthdate,
			'educationid'=>$model->educationid,
			'educationname'=>$model->education->educationname,
			'occupationid'=>$model->occupationid,
			'occupationname'=>$model->occupation->occupationname,
			'recordstatus'=>$model->recordstatus,
			'div'=>$this->renderPartial('_form', array('model'=>$model,
			  'applicant'=>$this->applicant,
			  'familyrelation'=>$this->familyrelation,
			  'sex'=>$this->sex,
			  'city'=>$this->city,
			  'education'=>$this->education,
			  'occupation'=>$this->occupation), true)
			));
		Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Applicantfamily'], $_POST['Applicantfamily']['employeefamilyid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Applicantfamily']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Applicantfamily']['employeeid'],'hrapfemptyemployeeid','emptystring'),
                array($_POST['Applicantfamily']['familyrelationid'],'hrapfemptyfamilyrelationid','emptystring'),
                array($_POST['Applicantfamily']['familyname'],'hrapfemptyfamilyname','emptystring'),
                array($_POST['Applicantfamily']['sexid'],'hrapfemptysexid','emptystring'),
                array($_POST['Applicantfamily']['cityid'],'hrapfemptycityid','emptystring'),
                array($_POST['Applicantfamily']['birthdate'],'hrapfemptybirthdate','emptystring'),
                array($_POST['Applicantfamily']['educationid'],'hrapfemptyeducationid','emptystring'),
                array($_POST['Applicantfamily']['occupationid'],'hrapfemptyoccupationid','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Applicantfamily'];
		if ((int)$_POST['Applicantfamily']['employeefamilyid'] > 0)
		{
		  $model=$this->loadModel($_POST['Applicantfamily']['employeefamilyid']);
		  $model->employeeid = $_POST['Applicantfamily']['employeeid'];
		  $model->familyrelationid = $_POST['Applicantfamily']['familyrelationid'];
		  $model->familyname = $_POST['Applicantfamily']['familyname'];
		  $model->sexid = $_POST['Applicantfamily']['sexid'];
		  $model->cityid = $_POST['Applicantfamily']['cityid'];
		  $model->birthdate = $_POST['Applicantfamily']['birthdate'];
		  $model->educationid = $_POST['Applicantfamily']['educationid'];
		  $model->occupationid = $_POST['Applicantfamily']['occupationid'];
		  $model->recordstatus = $_POST['Applicantfamily']['recordstatus'];
		}
		else
		{
		  $model = new Applicantfamily();
		  $model->attributes=$_POST['Applicantfamily'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Applicantfamily']['employeefamilyid']);
              $this->GetSMessage('hrapfinsertsuccess');
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
	  $model=new Applicantfamily('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicantfamily']))
		  $model->attributes=$_GET['Applicantfamily'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
			  'model'=>$model,
			  'applicant'=>$this->applicant,
			  'familyrelation'=>$this->familyrelation,
			  'sex'=>$this->sex,
			  'city'=>$this->city,
			  'education'=>$this->education,
			  'occupation'=>$this->occupation
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
			  $model=Applicantfamily::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Applicantfamily();
			  }
			  $model->employeefamilyid = (int)$data[0];
			  $model->employeeid = (int)$data[1];
			  $model->familyrelationid = (int)$data[2];
			  $model->familyname = $data[3];
			  $model->sexid = (int)$data[4];
			  $model->cityid = (int)$data[5];
			  $model->birthdate = $data[6];
			  $model->educationid = (int)$data[7];
			  $model->occupationid = (int)$data[8];
			  $model->recordstatus = (int)$data[9];
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
	  $pdf->title='Applicant Family List';
	  $pdf->AddPage('L');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $header = array('No','ID','Applicant Name','Family Name','Family Relation',
		'Sex Name','City Name','Birth Date','Education Name','Occupation Name');
	  $model=new Applicantfamily('searchwstatus');
	  $dataprovider=$model->searchwstatus();
	  $dataprovider->pagination=false;
	  $data = $dataprovider->getData();
	  $cols = $dataprovider->getKeys();
	  $dataku=array(count($data));
	  //var_dump($dataku);
	  $w= array(10,15,30,30,25,25,40,25,40,40);

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
		  $pdf->Cell($w[1],6,$datas['employeefamilyid'],'LR',0,'C',$fill);
		  $pdf->Cell($w[2],6,Applicant::model()->findByPk($datas['employeeid'])->fullname,'LR',0,'L',$fill);
		  $pdf->Cell($w[3],6,$datas['familyname'],'LR',0,'L',$fill);
		  $pdf->Cell($w[4],6,Familyrelation::model()->findByPk($datas['familyrelationid'])->familyrelationname,'LR',0,'L',$fill);
		  $pdf->Cell($w[5],6,Sex::model()->findByPk($datas['sexid'])->sexname,'LR',0,'L',$fill);
		  $pdf->Cell($w[6],6,City::model()->findByPk($datas['cityid'])->cityname,'LR',0,'L',$fill);
		  $pdf->Cell($w[7],6,$datas['birthdate'],'LR',0,'C',$fill);
		  $pdf->Cell($w[8],6,Education::model()->findByPk($datas['educationid'])->educationname,'LR',0,'L',$fill);
		  $pdf->Cell($w[9],6,Occupation::model()->findByPk($datas['occupationid'])->occupationname,'LR',0,'L',$fill);
		  $pdf->Ln();
		  $fill=!$fill;
	  }
	  $pdf->Cell(array_sum($w),0,'','T');


	  // me-render ke browser
	  $pdf->Output('applicantfamily.pdf','D');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Applicantfamily::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='Applicantfamily-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class ApplicantaddressController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'applicantaddress';

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
	  $model=new Applicantaddress;
	  if (Yii::app()->request->isAjaxRequest)
      {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_form', array('model'=>$model), true)
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

	  $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
		  echo CJSON::encode(array(
			'status'=>'success',
            'addressid'=>$model->addressid,
			'addressbookid'=>$model->addressbookid,
			'fullname'=>($model->addressbook!==null)?$model->addressbook->fullname:"",
			'addresstypeid'=>$model->addresstypeid,
			'addresstypename'=>($model->addresstype!==null)?$model->addresstype->addresstypename:"",
			'addressname'=>$model->addressname,
			'rt'=>$model->rt,
			'rw'=>$model->rw,
			'cityid'=>$model->cityid,
			'cityname'=>($model->city!==null)?$model->city->cityname:"",
			'kelurahanid'=>$model->kelurahanid,
			'kelurahanname'=>($model->kelurahan!==null)?$model->kelurahan->kelurahanname:"",
			'subdistrictid'=>$model->subdistrictid,
			'subdistrictname'=>($model->subdistrict!==null)?$model->subdistrict->subdistrictname:"",
			  'div'=>$this->renderPartial('_form', array('model'=>$model), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Applicantaddress'], $_POST['Applicantaddress']['addressbookid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Applicantaddress']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Applicantaddress']['addresstypeid'],'cobnemptyaddresstype','emptystring'),
                array($_POST['Applicantaddress']['addressname'],'cobnemptyaddressname','emptystring'),
                array($_POST['Applicantaddress']['cityid'],'cobnemptycity','emptystring'),
            )
        );
        if ($messages == '') {
		  //$dataku->attributes=$_POST['Applicantaddress'];
		  if ((int)$_POST['Applicantaddress']['addressid'] > 0)
		{
		  $model=Applicantaddress::model()->findbyPK($_POST['Applicantaddress']['addressid']);
		  $model->addressbookid = $_POST['Applicantaddress']['addressbookid'];
		  $model->addresstypeid = $_POST['Applicantaddress']['addresstypeid'];
		  $model->addressname = $_POST['Applicantaddress']['addressname'];
		  $model->rt = $_POST['Applicantaddress']['rt'];
		  $model->rw = $_POST['Applicantaddress']['rw'];
		  $model->cityid = $_POST['Applicantaddress']['cityid'];
		  $model->kelurahanid = $_POST['Applicantaddress']['kelurahanid'];
		  $model->subdistrictid = $_POST['Applicantaddress']['subdistrictid'];
		}
		else
		{
		  $model = new Applicantaddress();
		  $model->attributes=$_POST['Applicantaddress'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Applicantaddress']['addressid']);
              $this->GetSMessage('cobninsertsuccess');
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

	  $model=new Applicantaddress('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Applicantaddress']))
		  $model->attributes=$_GET['Applicantaddress'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		'model'=>$model
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
			  $model1->isapplicantaddress=1;
			  $model1->isapplicant=0;
			  $model1->recordstatus=1;
			  $model1->save();

			  $model=Applicantaddress::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Applicantaddress();
			  }
			  $model->applicantid = (int)$data[0];
			  $model->fullname = $data[1];
			  $model->addressbookid = $model1->addressbookid;
			  $model->oldnik = $data[3];
			  $model->newnik = $data[4];
			  $model->orgstructureid = $data[5];
			  $model->positionid = $data[6];
			  $model->applicanttypeid = $data[7];
			  $model->sexid = $data[8];
			  $model->bloodtypeid = $data[9];
			  $model->birthcityid = $data[10];
			  $model->birthdate = $data[11];
			  $model->religionid = $data[12];
			  $model->maritalstatusid = $data[13];
			  $model->tribeid = $data[14];
			  $model->referenceby = $data[15];
			  $model->joindate = $data[16];
			  $model->applicantstatusid = $data[17];
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
	  $pdf->title='Applicantaddress List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $header = array('No','ID','Full Name','Old Nik','New Nik','Structure');
	  $model=new Applicantaddress('searchwstatus');
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
		  $pdf->Cell($w[1],6,$datas['applicantid'],'LR',0,'C',$fill);
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
		$model=Applicantaddress::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='applicant-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

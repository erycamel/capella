<?php

class AddressbookController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'addressbook';

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
	  $model=new Addressbook;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			'status'=>'success',
			'div'=>$this->renderPartial('_form', array('model'=>$model), true)
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
			'addressbookid'=>$model->addressbookid,
			'fullname'=>$model->fullname,
			'iscustomer'=>$model->iscustomer,
			'isemployee'=>$model->isemployee,
			'isapplicant'=>$model->isapplicant,
			'isvendor'=>$model->isvendor,
			'isinsurance'=>$model->isinsurance,
			'isbank'=>$model->isbank,
			'ishospital'=>$model->ishospital,
			'iscatering'=>$model->iscatering,
			'recordstatus'=>$model->recordstatus,
            'taxno'=>$model->taxno,
            'abno'=>$model->abno,
            'accpiutangid'=>$model->accpiutangid,
            'acchutangid'=>$model->acchutangid,
			'div'=>$this->renderPartial('_form', array('model'=>$model), true)
			));
		Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Addressbook'], $_POST['Addressbook']['addressbookid']);
    }


	public function actionWrite()
	{
	  if(isset($_POST['Addressbook']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Addressbook']['fullname'],'coabemptyfullname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Addressbook'];
		if ((int)$_POST['Addressbook']['addressbookid'] > 0)
		{
		  $model=$this->loadModel($_POST['Addressbook']['addressbookid']);
		  $model->fullname = $_POST['Addressbook']['fullname'];
		  $model->iscustomer = $_POST['Addressbook']['iscustomer'];
		  $model->isemployee = $_POST['Addressbook']['isemployee'];
		  $model->isapplicant = $_POST['Addressbook']['isapplicant'];
		  $model->isvendor = $_POST['Addressbook']['isvendor'];
		  $model->isinsurance = $_POST['Addressbook']['isinsurance'];
		  $model->isbank = $_POST['Addressbook']['isbank'];
		  $model->ishospital = $_POST['Addressbook']['ishospital'];
		  $model->iscatering = $_POST['Addressbook']['iscatering'];
		  $model->recordstatus = $_POST['Addressbook']['recordstatus'];
		}
		else
		{
		  $model = new Addressbook();
		  $model->attributes=$_POST['Addressbook'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Addressbook']['addressbookid']);
              $this->GetSMessage('coabinsertsuccess');
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
	  $model=new Addressbook('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Addressbook']))
			$model->attributes=$_GET['Addressbook'];
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
			  $model=$this->loadModel((int)$data[0]);
			  if ($model=== null) {
				$model = new Addressbook();
			  }
			  $model->fullname = $data[1];
			  $model->iscustomer = (int)$data[2];
			  $model->isemployee = (int)$data[3];
			  $model->isapplicant = (int)$data[4];
			  $model->isvendor = (int)$data[5];
			  $model->isinsurance = (int)$data[6];
			  $model->isbank = (int)$data[7];
			  $model->ishospital = (int)$data[8];
			  $model->iscatering = (int)$data[9];
			  $model->recordstatus = (int)$data[10];
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
      if ($this->CheckAccess($this->menuname, $this->isdownload)) {
    Yii::import('application.extensions.fpdf.*');
    require_once("pdf.php");
    $pdf = new PDF();
    $pdf->title='Address Book List';
    $pdf->AddPage('L');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Full Name','Customer','Employee','Applicant',
	  'Vendor','Insurance','Bank','Hospital','Catering');
    $dataprovider=Addressbook::model()->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($data);
    $w= array(10,10,70,20,20,20,20,20,20,20,20);

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
        $pdf->Cell($w[1],6,$datas['addressbookid'],'LR',0,'C',$fill);
        $pdf->Cell($w[2],6,$datas['fullname'],'LR',0,'L',$fill);
		if ((int)$datas['iscustomer']==1) {
		  $pdf->Cell($w[3],6,'V','LR',0,'C',$fill);
		} else {
		  $pdf->Cell($w[3],6,'','LR',0,'C',$fill);
		}
		if ($datas['isemployee']==1) {
		  $pdf->Cell($w[4],6,'V','LR',0,'C',$fill);
		} else {
		  $pdf->Cell($w[4],6,'','LR',0,'C',$fill);
		}
		if ($datas['isapplicant']==1) {
		  $pdf->Cell($w[5],6,'V','LR',0,'C',$fill);
		} else {
		  $pdf->Cell($w[5],6,'','LR',0,'C',$fill);
		}
		if ($datas['isvendor']==1) {
		  $pdf->Cell($w[6],6,'V','LR',0,'C',$fill);
		} else {
		  $pdf->Cell($w[6],6,'','LR',0,'C',$fill);
		}
		if ($datas['isinsurance']==1) {
		  $pdf->Cell($w[7],6,'V','LR',0,'C',$fill);
		} else {
		  $pdf->Cell($w[7],6,'V','LR',0,'C',$fill);
		}
		if ($datas['isbank']==1) {
		  $pdf->Cell($w[8],6,'V','LR',0,'C',$fill);
		} else {
		  $pdf->Cell($w[8],6,'','LR',0,'C',$fill);
		}
		if ($datas['ishospital']==1) {
		  $pdf->Cell($w[9],6,'V','LR',0,'C',$fill);
		} else {
		  $pdf->Cell($w[9],6,'','LR',0,'C',$fill);
		}
		if ($datas['iscatering']==1) {
		  $pdf->Cell($w[10],6,'V','LR',0,'C',$fill);
		} else {
		  $pdf->Cell($w[10],6,'','LR',0,'C',$fill);
		}
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');


    // me-render ke browser
    $pdf->Output('addressbook.pdf','D');
      }
  }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Addressbook::model()->findByPk((int)$id);
		//if($model===null)
		//	throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='addressbook-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

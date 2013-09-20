<?php

class AssphonegroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'assphonegroup';

public function actionHelp()
	{
	  $txt = '';
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $txt = '_help'; break;
				case 2 : $txt = '_helpmodif'; break;
			}
		}
	  parent::actionHelp($txt);
	}

	public $phonegroup,$voucheragent;
	public function lookupdata()
	{
	  $this->phonegroup=new Phonegroup('searchwstatus');
	  $this->phonegroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Phonegroup']))
		$this->phonegroup->attributes=$_GET['Phonegroup'];
	  $this->voucheragent=new Voucheragent('searchwstatus');
	  $this->voucheragent->unsetAttributes();  // clear any default values
	  if(isset($_GET['Voucheragent']))
		$this->voucheragent->attributes=$_GET['Voucheragent'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
	  $model=new Assphonegroup;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			'status'=>'success',
			'div'=>$this->renderPartial('_form', array('model'=>$model,
			  'phonegroup'=>$this->phonegroup,
			  'voucheragent'=>$this->voucheragent), true)
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
	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			'status'=>'success',
			'assphonegroupid'=>$model->assphonegroupid,
			'phonegroupid'=>$model->phonegroupid,
			'groupname'=>$model->phonegroup->groupname,
			'fullname'=>$model->voucheragent->addressbook->fullname,
			'voucheragentid'=>$model->voucheragentid,
			'div'=>$this->renderPartial('_form', array('model'=>$model,
				'phonegroup'=>$this->phonegroup,
				'voucheragent'=>$this->voucheragent), true)
			));
		Yii::app()->end();
	  }
	}

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Assphonegroup']))
	  {
		$dataku->attributes=$_POST['Assphonegroup'];
		if ((int)$dataku->attributes['assphonegroupid'] > 0)
		{
		  $model=$this->loadModel($dataku->attributes['assphonegroupid']);
		  $model->phonegroupid = $dataku->attributes['phonegroupid'];
		  $model->voucheragentid = $dataku->attributes['voucheragentid'];
		}
		else
		{
		  $model = new Assphonegroup();
		  $model->attributes=$_POST['Assphonegroup'];
		}
		try
		{
		  if($model->save())
		  {
			if (Yii::app()->request->isAjaxRequest)
			  {
				echo CJSON::encode(array(
				  'status'=>'success',
				  'div'=>"Data saved"
				));
			  }
		  }
		  else
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
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		parent::actionDelete();
	  $id=$_POST['id'];
	  foreach($id as $ids)
	  {
		$model=$this->loadModel($ids);
		$model->delete();
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
		$model=new Assphonegroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Assphonegroup']))
			$model->attributes=$_GET['Assphonegroup'];
	  if (isset($_GET['pageSize']))
			{
			  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
			}
		$this->render('index',array(
			'model'=>$model,
			  'phonegroup'=>$this->phonegroup,
			  'voucheragent'=>$this->voucheragent
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
				$model = new Assphonegroup();
			  }
			  $model->phonegroupid = (int)$data[1];
			  $model->voucheragentid = (int)$data[2];
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
    $pdf->title='Phone Group Assignment List';
    $pdf->AddPage('P');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','SMS Member','Group Name');
    $model=new Assphonegroup('search');
    $dataprovider=$model->search();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($dataku);
    $w= array(10,15,70,70);

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
        $pdf->Cell($w[1],6,$datas['assphonegroupid'],'LR',0,'L',$fill);
        $pdf->Cell($w[2],6,Voucheragent::model()->findbypk($datas['voucheragentid'])->addressbook->fullname,'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,Phonegroup::model()->findbypk($datas['phonegroupid'])->groupname,'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');
    // me-render ke browser
    $pdf->Output('assphonegroup.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Assphonegroup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='assphonegroup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

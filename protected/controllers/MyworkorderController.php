<?php

class MyworkorderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname='myworkorder';
	public $workorderstaff,$eventrequest,$product;

	public function lookupdata()
	{
	  $this->workorderstaff=new Workorderstaff('searchwstatus');
	  $this->workorderstaff->unsetAttributes();  // clear any default values
	  if(isset($_GET['Workorderstaff']))
		$this->workorderstaff->attributes=$_GET['Workorderstaff'];

	  $this->eventrequest=new Eventrequest('searchwstatus');
	  $this->eventrequest->unsetAttributes();  // clear any default values
	  if(isset($_GET['Eventrequest']))
		$this->eventrequest->attributes=$_GET['Eventrequest'];

	  $this->product=new Product('searchwstatus');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];
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
			  'workorderid'=>$model->workorderid,
			  'productid'=>$model->productid,
			  'productname'=>$model->product->productname,
			  'workstartdate'=>$model->workstartdate,
			  'worktargetdate'=>$model->worktargetdate,
			  'workorderstaffid'=>$model->workorderstaffid,
			  'useraccessid'=>$model->workorderstaff->useraccessid,
			  'realname'=>$model->workorderstaff->useraccess->realname,
			  'description'=>$model->description,
			  'workorderstatus'=>$model->workorderstatus->statusname,
			  'eventrequestid'=>$model->eventrequestid,
			  'eventtitle'=>$model->eventrequest->eventtitle,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
		'workorderstaff'=>$this->workorderstaff,
		'eventrequest'=>$this->eventrequest,
		'product'=>$this->product), true)
			  ));
		  Yii::app()->end();
	  }
	}

	public function actionView()
	{
	  parent::actionIndex();
	  $id=$_POST['id'];
	  $workorderhist=Workorderhist::model();
	  $workorderhist->workorderid = $id[0];
	  $workorderhist->search();
		
	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>$this->renderPartial('_formhist', array('workorderhist'=>$workorderhist), true)));
		Yii::app()->end();
	  }
	}

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['MyWorkorder']))
	  {
		$dataku->attributes=$_POST['MyWorkorder'];
		if ((int)$dataku->attributes['workorderid'] > 0)
		{
		  $model=$this->loadModel($dataku->attributes['workorderid']);
		  $model->productid = $dataku->attributes['productid'];
		  $model->workstartdate = $dataku->attributes['workstartdate'];
		  $model->worktargetdate = $dataku->attributes['worktargetdate'];
		  $model->workorderstaffid = $dataku->attributes['workorderstaffid'];
		  $model->description = $dataku->attributes['description'];
		  $model->workorderstatusid = $dataku->attributes['workorderstatusid'];
		  $model->eventrequestid = $dataku->attributes['eventrequestid'];
		  $model->recordstatus = $dataku->attributes['recordstatus'];
		  $model->save();

		  $workorderhist = new Workorderhist();
		  $workorderhist->workorderid = $model->workorderid;
		  $workorderhist->workorderstatusid = $model->workorderstatusid;
		}
		try
		{
		  if($workorderhist->save())
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
			$errormessage=$workorderhist->getErrors();
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
		$model=new MyWorkorder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MyWorkorder']))
			$model->attributes=$_GET['MyWorkorder'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		'workorderstaff'=>$this->workorderstaff,
		'eventrequest'=>$this->eventrequest,
		'product'=>$this->product
		));
	}
	
public function actionUpload()
	{
      parent::actionUpload();
	  $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
	  $allowedExtensions = array("csv");
	  $sizeLimit = (int)Yii::app()->params['sizeLimit'];// maximum file size in bytes
	  $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	  $result = $uploader->handleUpload($folder,true);
	  $row = 0;
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Myworkorder::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Myworkorder();
			  }
			  $model->absstatusid = (int)$data[0];
			  $model->shortstat = $data[1];
			  $model->longstat = $data[2];
			  $model->isin = (int)$data[3];
			  $model->priority = (int)$data[4];
			  $model->recordstatus = (int)$data[5];
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
    $pdf = new PDF();
    $pdf->title='My Workorder List';
    $pdf->AddPage('P');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Short Status','Long Status','Priority');
    $model=new Myworkorder('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($dataku);
    $w= array(20,25,30,40,50);

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
        $pdf->Cell($w[1],6,$datas['absstatusid'],'LR',0,'L',$fill);
        $pdf->Cell($w[2],6,$datas['shortstat'],'LR',0,'C',$fill);
        $pdf->Cell($w[3],6,$datas['longstat'],'LR',0,'L',$fill);
        $pdf->Cell($w[4],6,$datas['priority'],'LR',0,'C',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');
    // me-render ke browser
    $pdf->Output('absencestatus.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Workorder::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='workorder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

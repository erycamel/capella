<?php

class LockerboxController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'lockerbox';

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
		$model=new Lockerbox;

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
				'lockerboxid'=>$model->lockerboxid,
				'lockerboxname'=>$model->lockerboxname,
				'description'=>$model->description,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Lockerbox'], $_POST['Lockerbox']['lockerboxid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Lockerbox']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Lockerbox']['lockerboxname'],'hfllbemptylockerboxname','emptystring'),
            array($_POST['Lockerbox']['description'],'hfllbemptydescription','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Lockerbox'];
		if ((int)$_POST['Lockerbox']['lockerboxid'] > 0)
		{
		  $model=$this->loadModel($_POST['Lockerbox']['lockerboxid']);
		  $model->lockerboxname = $_POST['Lockerbox']['lockerboxname'];
		  $model->description = $_POST['Lockerbox']['description'];
		  $model->recordstatus = $_POST['Lockerbox']['recordstatus'];
		}
		else
		{
		  $model = new Lockerbox();
		  $model->attributes=$_POST['Lockerbox'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Company']['companyid']);
              $this->GetSMessage('hfllbinsertsuccess');
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
    $model=new Lockerbox('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Lockerbox']))
			$model->attributes=$_GET['Lockerbox'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
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
			  $model=Lockerbox::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Lockerbox();
			  }
			  $model->lockerboxid = (int)$data[0];
			  $model->lockerboxname = $data[1];
			  $model->description = $data[2];
			  $model->recordstatus = (int)$data[3];
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
    $pdf->title='Locker Box List';
    $pdf->AddPage('P');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Locker Box Name','Description');
    $model=new Lockerbox('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    //var_dump($dataku);
    $w= array(20,25,40,70);

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
        $pdf->Cell($w[1],6,$datas['lockerboxid'],'LR',0,'L',$fill);
        $pdf->Cell($w[2],6,$datas['lockerboxname'],'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,$datas['description'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');


    // me-render ke browser
    $pdf->Output('lockerbox.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Lockerbox::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='lockerbox-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

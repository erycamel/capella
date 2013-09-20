<?php

class ProdoctemplateController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'prodoctemplate';

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

        public $projecttype,$documenttype;

	public function lookupdata()
	{
	  $this->projecttype=new Projecttype('searchwstatus');
	  $this->projecttype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projecttype']))
		$this->projecttype->attributes=$_GET['Projecttype'];
	  $this->documenttype=new Documenttype('searchwstatus');
	  $this->documenttype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Documenttype']))
		$this->documenttype->attributes=$_GET['Documenttype'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
      $this->lookupdata();
      $model=new Prodoctemplate;

      if (Yii::app()->request->isAjaxRequest)
      {
          echo CJSON::encode(array(
              'status'=>'success',
              'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
                  'projecttype'=>$this->projecttype,
                  'documenttype'=>$this->documenttype), true)
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
				'prodoctemplateid'=>$model->prodoctemplateid,
				'projecttypeid'=>$model->projecttypeid,
                'protypedescription'=>($model->projecttype!==null)?$model->projecttype->description:"",
				'documenttypeid'=>$model->documenttypeid,
                'documenttypename'=>($model->documenttype!==null)?$model->documenttype->documenttypename:"",
				'documentname'=>$model->documentname,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
                    'projecttype'=>$this->projecttype,
                  'documenttype'=>$this->documenttype), true)
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Prodoctemplate'], $_POST['Prodoctemplate']['prodoctemplateid']);
    }

	public function actionWrite()
	{
      parent::actionWrite();
	  if(isset($_POST['Prodoctemplate']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Prodoctemplate']['projecttypeid'],'ppdtemptyprojecttype','emptystring'),
            array($_POST['Prodoctemplate']['documentname'],'ppdtemptydocumentname','emptystring'),
            )
        );
        if ($messages == '') {
          if ((int)$_POST['Prodoctemplate']['prodoctemplateid'] > 0)
          {
            $model=$this->loadModel($_POST['Prodoctemplate']['prodoctemplateid']);
            $model->documentname = $_POST['Prodoctemplate']['documentname'];
            $model->projecttypeid = $_POST['Prodoctemplate']['projecttypeid'];
            $model->documenttypeid = $_POST['Prodoctemplate']['documenttypeid'];
            $model->recordstatus = $_POST['Prodoctemplate']['recordstatus'];
          }
          else
          {
            $model = new Prodoctemplate();
            $model->attributes=$_POST['Prodoctemplate'];
          }
          try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Prodoctemplate']['prodoctemplateid']);
              $this->GetSMessage('ppdtinsertsuccess');
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
    $model=new Prodoctemplate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Prodoctemplate']))
			$model->attributes=$_GET['Prodoctemplate'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
                    'projecttype'=>$this->projecttype,
                    'documenttype'=>$this->documenttype
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
			  $model=Prodoctemplate::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Prodoctemplate();
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
    $pdf->title='Prodoctemplate List';
    $pdf->AddPage('L');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Prodoctemplate Name','Address Name','City','Record Status');
    $model=new Prodoctemplate('search');
    $dataprovider=$model->search();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    //var_dump($dataku);
    $w= array(10,15,60,100,50,20);

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
        $pdf->Cell($w[1],6,$datas['prodoctemplateid'],'LR',0,'C',$fill);
        $pdf->Cell($w[2],6,$datas['prodoctemplatename'],'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,$datas['address'],'LR',0,'L',$fill);
        $pdf->Cell($w[4],6,$datas['city'],'LR',0,'L',$fill);
        $pdf->Cell($w[5],6,$datas['recordstatus'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');


    // me-render ke browser
    $pdf->Output('prodoctemplate.pdf','D');
  }

  public function actionPrint()
  {
    var_dump($_POST['id']);
    if (isset($_POST['id']))
    {
      Yii::import('application.extensions.ireport.*');
      $id=$_POST['id'];
      foreach($id as $ids)
      {
        $report = dirname(__FILE__) . '/report/' . 'prodoctemplate.jrxml';
        $AReport = new IReport($report);
        $AReport->parameters = array("prodoctemplateid"=>$ids);
        $AReport->execute();
      }
    }
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Prodoctemplate::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='prodoctemplate-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class ServicetypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'servicetype';

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
      $model=new Servicetype;

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
              'servicetypeid'=>$model->servicetypeid,
              'sosnroid'=>$model->sosnroid,
              'soformatdoc'=>($model->sosnro!==null)?$model->sosnro->formatdoc:"",
              'srfsnroid'=>$model->srfsnroid,
              'srfformatdoc'=>($model->srfsnro!==null)?$model->srfsnro->formatdoc:"",
              'servicetypename'=>$model->servicetypename,
              'recordstatus'=>$model->recordstatus,
              'div'=>$this->renderPartial('_form', array('model'=>$model), true)
              ));
          Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Servicetype'], $_POST['Servicetype']['servicetypeid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Servicetype']))
	  {
        $messages = $this->ValidateData(
                array(
                array($_POST['Servicetype']['servicetypename'],'cpremptyservicetypename','emptystring'),
				array($_POST['Servicetype']['sosnroid'],'cpremptysosnro','emptystring'),
				array($_POST['Servicetype']['srfsnroid'],'cpremptysrfsnro','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Servicetype'];
          if ((int)$_POST['Servicetype']['servicetypeid'] > 0)
          {
            $model=$this->loadModel($_POST['Servicetype']['servicetypeid']);
            $model->servicetypename = $_POST['Servicetype']['servicetypename'];
            $model->sosnroid = $_POST['Servicetype']['sosnroid'];
            $model->srfsnroid = $_POST['Servicetype']['srfsnroid'];
            $model->recordstatus = $_POST['Servicetype']['recordstatus'];
          }
          else
          {
            $model = new Servicetype();
            $model->attributes=$_POST['Servicetype'];
          }
          try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Servicetype']['servicetypeid']);
              $this->GetSMessage('cprinsertsuccess');
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
    $model=new Servicetype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Servicetype']))
			$model->attributes=$_GET['Servicetype'];
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
			  $model=Servicetype::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Servicetype();
			  }
			  $model->servicetypeid = (int)$data[0];
			  $model->sosnroid = $data[1];
			  $model->servicetypename = $data[2];
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
	  $pdf->title='Service Type List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select a.servicetypename,b.formatdoc as sosnro, c.formatdoc as srfsnro
      from servicetype a
	  inner join snro b on b.snroid = a.sosnroid
	  inner join snro c on c.snroid = a.srfsnroid ";
	  if ($_GET['id'] !== '') {
				$sql = $sql . "where a.servicetypeid = ".$_GET['id'];
		}
    $command=$connection->createCommand($sql);
    $dataReader=$command->queryAll();

    $pdf->setaligns(array('C','C','C','C'));
    $pdf->setwidths(array(50,30,30,30));
    $pdf->Row(array('Service Type','SO SNRO','SRF SNRO'));
    $pdf->setaligns(array('L','C','C','C'));
    foreach($dataReader as $row1)
    {
      $pdf->row(array($row1['servicetypename'],$row1['sosnro'],$row1['srfsnro']));
    }
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
		$model=Servicetype::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='servicetype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

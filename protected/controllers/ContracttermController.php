<?php

class ContracttermController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'contractterm';

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
		$model=new Contractterm;
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
			  'contracttermid'=>$model->contracttermid,
			  'contracttermname'=>$model->contracttermname,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

        public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Contractterm'], $_POST['Contractterm']['contracttermid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Contractterm']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Contractterm']['contracttermname'],'hrmbtemptycontracttermname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Contractterm'];
		if ((int)$_POST['Contractterm']['contracttermid'] > 0)
		{
		  $model=$this->loadModel($_POST['Contractterm']['contracttermid']);
		  $model->contracttermname = $_POST['Contractterm']['contracttermname'];
		  $model->recordstatus = $_POST['Contractterm']['recordstatus'];
		}
		else
		{
		  $model = new Contractterm();
		  $model->attributes=$_POST['Contractterm'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Contractterm']['contracttermid']);
              $this->GetSMessage('hrmbtinsertsuccess');
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
	  $model=new Contractterm('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Contractterm']))
		  $model->attributes=$_GET['Contractterm'];
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
			  $model=Contractterm::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Contractterm();
			  }
			  $model->contracttermid = (int)$data[0];
			  $model->contracttermname = $data[1];
			  $model->recordstatus = (int)$data[2];
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
	  $sql = "select a.contracttermname
      from contractterm a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.contracttermid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->title='Contract Term List';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',12);

	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    $this->pdf->setaligns(array('C','C','C','C'));
    $this->pdf->setwidths(array(50,30,30,30));
    $this->pdf->Row(array('Contract Term'));
    $this->pdf->setaligns(array('L','C','C','C'));
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['contracttermname']));
    }
	  // me-render ke browser
	  $this->pdf->Output();
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Contractterm::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='Contractterm-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

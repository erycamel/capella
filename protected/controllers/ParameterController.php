<?php

class ParameterController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'parameter';

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
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
      $model=new Parameter;

      if (Yii::app()->request->isAjaxRequest)
      {
        echo CJSON::encode(array(
            'status'=>'success',
            'divcreate'=>$this->renderPartial('_form', array('model'=>$model), true)
            ));
        Yii::app()->end();
      };
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
				'parameterid'=>$model->parameterid,
				'paramname'=>$model->paramname,
				'paramvalue'=>$model->paramvalue,
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
	  if(isset($_POST['Parameter']))
	  {
        if ((int)$_POST['Parameter']['parameterid'] > 0)
        {
          $this->Deletelock($this->menuname,$_POST['Parameter']['parameterid']);
          echo CJSON::encode(array(
                'status'=>'success',
				));
            Yii::app()->end();
        }
      }
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Parameter']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Parameter']['paramname'],'emptyparamname','emptystring'),
            array($_POST['Parameter']['paramvalue'],'emptyparamvalue','emptystring'),
            array($_POST['Parameter']['description'],'emptydescription','emptystring'),
            )
        );
        if ($messages == '') {
          if ((int)$_POST['Parameter']['parameterid'] > 0)
          {
            $model=$this->loadModel($_POST['Parameter']['parameterid']);
            $model->paramname = $_POST['Parameter']['paramname'];
            $model->paramvalue = $_POST['Parameter']['paramvalue'];
            $model->description = $_POST['Parameter']['description'];
            $model->recordstatus = $_POST['Parameter']['recordstatus'];
          }
          else
          {
            $model = new Parameter();
            $model->attributes=$_POST['Parameter'];
          }
          try
          {
            if($model->save())
            {
              $this->GetSMessage('spinsertsuccess');
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
		$model=new Parameter('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Parameter']))
			$model->attributes=$_GET['Parameter'];
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
			  $model=Parameter::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Parameter();
			  }
			  $model->parameterid = (int)$data[0];
			  $model->paramname = $data[1];
			  $model->paramvalue = $data[2];
			  $model->description = $data[3];
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
		$sql = "select paramname,description,paramvalue
				from parameter a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.parameterid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Parameter List';
		$this->pdf->AddPage('P');
		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(40,70,70));
		$this->pdf->colheader = array('Parameter Name','Description','Parameter Value');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','L');
		$this->pdf->setFont('Arial','',8);
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['paramname'],$row1['description'],$row1['paramvalue']));
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
		$model=Parameter::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='parameter-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

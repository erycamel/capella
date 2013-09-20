<?php

class AbsstatusController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'absstatus';

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
	  $model=new Absstatus;
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

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'absstatusid'=>$model->absstatusid,
			  'shortstat'=>$model->shortstat,
			  'longstat'=>$model->longstat,
			  'isin'=>$model->isin,
			  'priority'=>$model->priority,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model), true)
			  ));
		  Yii::app()->end();
	  }
	}

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Absstatus']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Absstatus']['shortstat'],'hrtasemptyshortstat','emptystring'),
                array($_POST['Absstatus']['longstat'],'hrtasemptylongstat','emptystring'),
                array($_POST['Absstatus']['priority'],'hrtasemptypriority','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Absstatus'];
		if ((int)$_POST['Absstatus']['absstatusid'] > 0)
		{
		  $model=$this->loadModel($_POST['Absstatus']['absstatusid']);
		  $model->shortstat = $_POST['Absstatus']['shortstat'];
		  $model->longstat = $_POST['Absstatus']['longstat'];
		  $model->isin = $_POST['Absstatus']['isin'];
		  $model->priority = $_POST['Absstatus']['priority'];
		  $model->recordstatus = $_POST['Absstatus']['recordstatus'];
		}
		else
		{
		  $model = new Absstatus();
		  $model->attributes=$_POST['Absstatus'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname,$_POST['Absstatus']['absstatusid']);
              $this->GetSMessage('hrtasinsertsuccess');
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
	  $model=new Absstatus('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Absstatus']))
	  	$model->attributes=$_GET['Absstatus'];
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
		$file = $folder . basename($_FILES['uploadfile']['name']); 
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
			echo "success";
			$row=1;			
			if (($handle = fopen($file, "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>1) {
			  $model=Absstatus::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Absstatus();
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
						  echo $model->getErrors();
						}
					  }
					  catch (Exception $e)
					  {
						echo $e->getMessage();;
					  }
					}
					$row++;
				}
				fclose($handle);
			}
		} else {
			echo Yii::t('app','directory permission');
		}	
  }

  public function actionDownload()
	{
	  parent::actionDownload();
	   $sql = "select a.shortstat,a.longstat,a.isin,a.priority
      from absstatus a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.absstatusid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->title='Absence Status List';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',12);

	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    $this->pdf->setaligns(array('C','C','C','C'));
    $this->pdf->setwidths(array(30,50,30,30));
    $this->pdf->Row(array('Short Status','Long Status','Is In','Priority'));
    $this->pdf->setaligns(array('L','L','C','C'));
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['shortstat'],$row1['longstat'],$row1['isin'],$row1['priority']));
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
		$model=Absstatus::model()->findByPk((int)$id);
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
	  if(isset($_POST['ajax']) && $_POST['ajax']==='absstatus-form')
	  {
		  echo CActiveForm::validate($model);
		  Yii::app()->end();
	  }
	}
}

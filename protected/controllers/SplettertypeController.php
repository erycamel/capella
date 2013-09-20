<?php

class SplettertypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'splettertype';

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
		$model=new Splettertype;
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
			  'splettertypeid'=>$model->splettertypeid,
			  'splettername'=>$model->splettername,
			  'description'=>$model->description,
			  'validperiod'=>$model->validperiod,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

        public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Splettertype'], $_POST['Splettertype']['splettertypeid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Splettertype']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Splettertype']['splettername'],'hmsptemptysplettername','emptystring'),
                    array($_POST['Splettertype']['description'],'hmsptemptydescription','emptystring'),
                    array($_POST['Splettertype']['validperiod'],'hmsptemptyvalidperiod','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Splettertype'];
		if ((int)$_POST['Splettertype']['splettertypeid'] > 0)
		{
		  $model=$this->loadModel($_POST['Splettertype']['splettertypeid']);
		  $model->splettername = $_POST['Splettertype']['splettername'];
		  $model->description = $_POST['Splettertype']['description'];
		  $model->validperiod = $_POST['Splettertype']['validperiod'];
		  $model->recordstatus = $_POST['Splettertype']['recordstatus'];
		}
		else
		{
		  $model = new Splettertype();
		  $model->attributes=$_POST['Splettertype'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Splettertype']['splettertypeid']);
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
	  $model=new Splettertype('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Splettertype']))
		  $model->attributes=$_GET['Splettertype'];
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
			  $model=Splettertype::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Splettertype();
			  }
			  $model->splettertypeid = (int)$data[0];
			  $model->splettername = $data[1];
			  $model->description = $data[2];
			  $model->validperiod = $data[3];
			  $model->recordstatus = (int)$data[4];
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
	  $sql = "select splettername, description, validperiod
      from splettertype a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.splettertypeid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

    $this->pdf->title='SP Letter Type List';
    $this->pdf->AddPage('P');
$this->pdf->setFont('Arial','B',8);
    $this->pdf->SetY(45);
    $this->pdf->setaligns(array('C','C','C'));
    $this->pdf->setwidths(array(50,40,30));
    $this->pdf->Row(array('SP Letter Name','Description','Period'));
    $this->pdf->setaligns(array('L','L','L'));
    foreach($dataReader as $row)
    {
      $this->pdf->row(array($row['splettername'],$row['description'],$row['validperiod']));
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
		$model=Splettertype::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='Splettertype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

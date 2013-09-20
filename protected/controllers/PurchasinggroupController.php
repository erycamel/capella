<?php

class PurchasinggroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'purchasinggroup';

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
	  $purchasingorg=new Purchasingorg('searchwstatus');
	  $purchasingorg->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasingorg']))
		$purchasingorg->attributes=$_GET['Purchasingorg'];
		$model=new Purchasinggroup;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
			'purchasingorg'=>$purchasingorg), true)
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
	  $purchasingorg=new Purchasingorg('searchwstatus');
	  $purchasingorg->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasingorg']))
		$purchasingorg->attributes=$_GET['Purchasingorg'];
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'purchasinggroupid'=>$model->purchasinggroupid,
				'purchasingorgid'=>$model->purchasingorgid,
				'purchasingorgcode'=>$model->purchasingorg->purchasingorgcode,
				'purchasinggroupcode'=>$model->purchasinggroupcode,
				'description'=>$model->description,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'purchasingorg'=>$purchasingorg), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Purchasinggroup'], $_POST['Purchasinggroup']['purchasinggroupid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Purchasinggroup']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Purchasinggroup']['purchasingorgid'],'ppgemptypurchasingorgid','emptystring'),
array($_POST['Purchasinggroup']['purchasinggroupcode'],'ppgemptypurchasinggroupcode','emptystring'),
                array($_POST['Purchasinggroup']['description'],'ppgemptydescription','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Purchasinggroup'];
		if ((int)$_POST['Purchasinggroup']['purchasinggroupid'] > 0)
		{
		  $model=$this->loadModel($_POST['Purchasinggroup']['purchasinggroupid']);
		  $model->purchasinggroupcode = $_POST['Purchasinggroup']['purchasinggroupcode'];
		  $model->purchasingorgid = $_POST['Purchasinggroup']['purchasingorgid'];
		  $model->description = $_POST['Purchasinggroup']['description'];
		  $model->recordstatus = $_POST['Purchasinggroup']['recordstatus'];
		}
		else
		{
		  $model = new Purchasinggroup();
		  $model->attributes=$_POST['Purchasinggroup'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Purchasinggroup']['purchasinggroupid']);
              $this->GetSMessage('ppginsertsuccess');
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
	  $purchasingorg=new Purchasingorg('searchwstatus');
	  $purchasingorg->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasingorg']))
		$purchasingorg->attributes=$_GET['Purchasingorg'];
		$model=new Purchasinggroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Purchasinggroup']))
			$model->attributes=$_GET['Purchasinggroup'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
			'purchasingorg'=>$purchasingorg
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
			  $model=Purchasinggroup::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Purchasinggroup();
			  }
			  $model->purchasinggroupid = (int)$data[0];
			  $model->purchasingorgid = (int)$data[1];
			  $model->purchasinggroupcode = $data[2];
			  $model->description = $data[3];
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
		$sql = "select purchasingorgcode,purchasinggroupcode,a.description
				from purchasinggroup a 
				left join purchasingorg b on b.purchasingorgid = a.purchasingorgid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.purchasinggroupid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Purchasing Group List';
		$this->pdf->AddPage('P');
		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(50,50,90));
		$this->pdf->colheader = array('Purchasing Organization','Purchasing Group','Description');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','L');
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['purchasingorgcode'],$row1['purchasinggroupcode'],$row1['description']));
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
		$model=Purchasinggroup::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchasinggroup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

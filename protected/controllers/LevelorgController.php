<?php

class LevelorgController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'levelorg';

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
		$model=new Levelorg;
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
			  'levelorgid'=>$model->levelorgid,
			  'levelorgname'=>$model->levelorgname,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

        public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Levelorg'], $_POST['Levelorg']['levelorgid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Levelorg']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Levelorg']['levelorgname'],'hrmbtemptylevelorgname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Levelorg'];
		if ((int)$_POST['Levelorg']['levelorgid'] > 0)
		{
		  $model=$this->loadModel($_POST['Levelorg']['levelorgid']);
		  $model->levelorgname = $_POST['Levelorg']['levelorgname'];
		  $model->recordstatus = $_POST['Levelorg']['recordstatus'];
		}
		else
		{
		  $model = new Levelorg();
		  $model->attributes=$_POST['Levelorg'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Levelorg']['levelorgid']);
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
	  $model=new Levelorg('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Levelorg']))
		  $model->attributes=$_GET['Levelorg'];
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
			$row=0;			
			if (($handle = fopen($file, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					if ($row>0) {
						$model=Levelorg::model()->findByPk((int)$data[0]);
						if ($model=== null) {
							$model = new Levelorg();
						}
						$model->levelorgid = (int)$data[0];
						$model->levelorgname = $data[1];
						$model->recordstatus = (int)$data[2];
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
		$sql = "select levelorgname
			from levelorg a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.levelorgid = ".$_GET['id'];
		}		
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Level Organization List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		// menuliskan tabel
		$this->pdf->setaligns(array('C'));
		$this->pdf->setwidths(array(90));
		$this->pdf->Row(array('Level'));
		$this->pdf->setaligns(array('L'));
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['levelorgname']));
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
		$model=Levelorg::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='Levelorg-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

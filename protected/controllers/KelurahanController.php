<?php

class KelurahanController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'kelurahan';

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
	  $subdistrict=new Subdistrict('searchwstatus');
	  $subdistrict->unsetAttributes();  // clear any default values
	  if(isset($_GET['Subdistrict']))
		$subdistrict->attributes=$_GET['Subdistrict'];

		$model=new Kelurahan;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'subdistrict'=>$subdistrict), true)
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
	  $subdistrict=new Subdistrict('searchwstatus');
	  $subdistrict->unsetAttributes();  // clear any default values
	  if(isset($_GET['Subdistrict']))
		$subdistrict->attributes=$_GET['Subdistrict'];
      $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
                'kelurahanid'=>$model->kelurahanid,
                'subdistrictid'=>$model->subdistrictid,
                'subdistrictname'=>$model->subdistrict->subdistrictname,
                'kelurahanname'=>$model->kelurahanname,
                'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
            'subdistrict'=>$subdistrict), true)
                ));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Kelurahan'], $_POST['Kelurahan']['kelurahanid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Kelurahan']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Kelurahan']['kelurahanname'],'ccssdemptysubsubdistrict','emptystring'),
                array($_POST['Kelurahan']['subdistrictid'],'ccssdemptysubdistrict','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Kelurahan'];
		if ((int)$_POST['Kelurahan']['kelurahanid'] > 0)
		{
		  $model=$this->loadModel($_POST['Kelurahan']['kelurahanid']);
		  $model->kelurahanname = $_POST['Kelurahan']['kelurahanname'];
		  $model->subdistrictid = $_POST['Kelurahan']['subdistrictid'];
		  $model->recordstatus = $_POST['Kelurahan']['recordstatus'];
		}
		else
		{
		  $model = new Kelurahan();
		  $model->attributes=$_POST['Kelurahan'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Kelurahan']['kelurahanid']);
              $this->GetSMessage('ccsdinsertsuccess');
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
	  $subdistrict=new Subdistrict('searchwstatus');
	  $subdistrict->unsetAttributes();  // clear any default values
	  if(isset($_GET['Subdistrict']))
		$subdistrict->attributes=$_GET['Subdistrict'];
		$model=new Kelurahan('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Kelurahan']))
			$model->attributes=$_GET['Kelurahan'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
			'subdistrict'=>$subdistrict
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
			  $model=Kelurahan::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Kelurahan();
			  }
			  $model->kelurahanid = (int)$data[0];
			  $model->subdistrictname = $data[1];
			  $model->kelurahanname = $data[2];
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
		$sql = "select subdistrictname,kelurahanname
				from kelurahan a
left join subdistrict b on b.subdistrictid = a.subdistrictid				";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.kelurahanid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Sub Subdistrict List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C'));
		$this->pdf->setwidths(array(90,70));
		$this->pdf->Row(array('Subdistrictname','Kelurahan'));
		$this->pdf->setaligns(array('L','L'));
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['subdistrictname'],$row1['kelurahanname']));
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
		$model=Kelurahan::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kelurahan-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

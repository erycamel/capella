<?php

class EmployeespletterController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeespletter';

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
    $employee=new Employee('searchwstatus');
    $employee->unsetAttributes();  // clear any default values
    if(isset($_GET['Employee']))
      $employee->attributes=$_GET['Employee'];

    $splettertype=new Splettertype('searchwstatus');
    $splettertype->unsetAttributes();  // clear any default values
    if(isset($_GET['Splettertype']))
      $splettertype->attributes=$_GET['Splettertype'];

		$model=new Employeespletter;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
      'employee'=>$employee,
      'splettertype'=>$splettertype), true)
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
    $employee=new Employee('searchwstatus');
    $employee->unsetAttributes();  // clear any default values
    if(isset($_GET['Employee']))
      $employee->attributes=$_GET['Employee'];

    $splettertype=new Splettertype('searchwstatus');
    $splettertype->unsetAttributes();  // clear any default values
    if(isset($_GET['Splettertype']))
      $splettertype->attributes=$_GET['Splettertype'];
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'employeespletterid'=>$model->employeespletterid,
				'employeeid'=>$model->employeeid,
				'fullname'=>$model->employee->fullname,
				'splettertypeid'=>$model->splettertypeid,
				'splettername'=>$model->splettertype->splettername,
                'transdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->transdate)),
                'enddate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->enddate)),
                'reason'=>$model->reason,
                'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
      'employee'=>$employee,
      'splettertype'=>$splettertype), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeespletter'],
              $_POST['Employeespletter']['employeespletterid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeespletter']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeespletter']['transdate'],'heeiemptytransdate','emptystring'),
                array($_POST['Employeespletter']['employeeid'],'heeiemptyemployeeid','emptystring'),
                array($_POST['Employeespletter']['splettertypeid'],'heeiemptysplettertypeid','emptystring'),
                array($_POST['Employeespletter']['reason'],'heeiemptyspletterreason','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Employeespletter'];
		if ((int)$_POST['Employeespletter']['employeespletterid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeespletter']['employeespletterid']);
		  $model->employeeid = $_POST['Employeespletter']['employeeid'];
		  $model->splettertypeid = $_POST['Employeespletter']['splettertypeid'];
		  $model->transdate = $_POST['Employeespletter']['transdate'];
		  $model->reason = $_POST['Employeespletter']['reason'];
		  $model->recordstatus = $_POST['Employeespletter']['recordstatus'];
		  $model->enddate = $_POST['Employeespletter']['enddate'];
		}
		else
		{
		  $model = new Employeespletter();
		  $model->attributes=$_POST['Employeespletter'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeespletter']['employeespletterid']);
              $this->GetSMessage('heeiinsertsuccess');
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
	  $employee=new Employee('searchwstatus');
	  $employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$employee->attributes=$_GET['Employee'];

	  $splettertype=new Splettertype('searchwstatus');
	  $splettertype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Splettertype']))
		$splettertype->attributes=$_GET['Splettertype'];
	  $model=new Employeespletter('searchwstatus');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employeespletter']))
			$model->attributes=$_GET['Employeespletter'];
			if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
      'employee'=>$employee,
      'splettertype'=>$splettertype
		));
	}
	
	public function actionGeneratedetail()
    {
		$connection=Yii::app()->db;
		if (($_POST['id']) && ($_POST['transdate']))
		{
			$sql = "select date_add('".date(Yii::app()->params['datetodb'], strtotime($_POST['transdate']))."',interval a.validperiod month) as enddate
				from splettertype a
				where splettertypeid = ".$_POST['id'];
			$command=$connection->createCommand($sql);
			$datareader = $command->queryAll();
			foreach($datareader as $row) {
			  $enddate = $row['enddate'];
			}
			echo CJSON::encode(array(
				'status'=>'success',
				'enddate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)),
				));
			Yii::app()->end();
		}
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
			  $model=Employeespletter::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Employeespletter();
			  }
			  $model->employeespletterid = (int)$data[0];
			  $model->employeeid = (int)$data[1];
			  $model->splettertypeid = (int)$data[2];
			  $model->splettertypeno = $data[3];
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
	  $pdf->title='Employee Sanction / Warning Letter';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select b.oldnik,b.fullname, a.spletterno, a.transdate,a.reason, c.description,a.enddate
		from employeespletter a
		left join employee b on b.employeeid = a.employeeid
		left join splettertype c on c.splettertypeid = a.splettertypeid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.employeespletterid = ".$_GET['id'];
		}
		$sql = $sql . " order by a.employeeid";
    $command=$connection->createCommand($sql);
    $dataReader=$command->queryAll();

    foreach($dataReader as $row)
    {
      if (file_exists($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'.$row['oldnik'].'.jpg'))
      {
        $pdf->Image($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'. $row['oldnik'] .'.jpg',10,30,30);
      }
      $pdf->setFont('Arial','B',10);
      $pdf->text(50,35,'Date: '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['transdate'])));
      $pdf->text(50,40,'Name: '.$row['fullname']);
      $pdf->setFont('Arial','',8);
	  $pdf->text(50,45,'Sanction Type : '.$row['description']);
	  $pdf->text(50,50,'Reason: '.$row['reason']);
      $pdf->AddPage('P');
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
		$model=Employeespletter::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeespletter-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

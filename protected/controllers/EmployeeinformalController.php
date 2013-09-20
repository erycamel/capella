<?php

class EmployeeinformalController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeeinformal';

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

		$model=new Employeeinformal;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
      'employee'=>$employee), true)
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

		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'employeeinformalid'=>$model->employeeinformalid,
				'employeeid'=>$model->employeeid,
				'fullname'=>$model->employee->fullname,
				'informalname'=>$model->informalname,
				'organizer'=>$model->organizer,
				'period'=>$model->period,
				'isdiploma'=>$model->isdiploma,
				'sponsoredby'=>$model->sponsoredby,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
      'employee'=>$employee), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeeinformal'],
              $_POST['Employeeinformal']['employeeinformalid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeeinformal']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeeinformal']['employeeid'],'hremifemptyemployeeid','emptystring'),
                array($_POST['Employeeinformal']['informalname'],'hremifemptyinformalname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Employeeinformal'];
		if ((int)$_POST['Employeeinformal']['employeeinformalid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeeinformal']['employeeinformalid']);
		  $model->employeeid = $_POST['Employeeinformal']['employeeid'];
		  $model->informalname = $_POST['Employeeinformal']['informalname'];
		  $model->organizer = $_POST['Employeeinformal']['organizer'];
		  $model->period = $_POST['Employeeinformal']['period'];
		  $model->isdiploma = $_POST['Employeeinformal']['isdiploma'];
		  $model->sponsoredby = $_POST['Employeeinformal']['sponsoredby'];
		  $model->recordstatus = $_POST['Employeeinformal']['recordstatus'];
		}
		else
		{
		  $model = new Employeeinformal();
		  $model->attributes=$_POST['Employeeinformal'];
          $model->iswo=0;
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeeinformal']['employeeinformalid']);
              $this->GetSMessage('hremifinsertsuccess');
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
		$model=new Employeeinformal('searchwstatus');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employeeinformal']))
			$model->attributes=$_GET['Employeeinformal'];
			if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model
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
			  $model=Employeeinformal::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Employeeinformal();
			  }
			  $model->employeeinformalid = (int)$data[0];
			  $model->employeeid = (int)$data[1];
			  $model->informalname = $data[2];
			  $model->organizer = $data[3];
			  $model->period = (int)$data[4];
			  $model->isdiploma = (int)$data[5];
			  $model->sponsoredby = $data[6];
			  $model->recordstatus = (int)$data[7];
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
    $pdf->title='Employee Informal List';
    $pdf->AddPage('P');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $connection=Yii::app()->db;
    $sql = "select a.employeeid,a.fullname, a.oldnik, b.levelorgname, c.structurename,d.positionname,e.employeetypename,
        f.sexname,joindate,email,phoneno,alternateemail,hpno,a.addressbookid
      from employee a
      left join levelorg b on b.levelorgid = a.levelorgid
      left join orgstructure c on c.orgstructureid = a.orgstructureid
      left join position d on d.positionid = a.positionid
      left join employeetype e on e.employeetypeid = a.employeetypeid
      left join sex f on f.sexid = a.sexid
	left join employeeinformal g on g.employeeid = a.employeeid ";

      if ($_GET['id'] !== '') {
				$sql = $sql . "where g.employeeinformalid = ".$_GET['id'];
		}
		$sql = $sql . " order by employeeid";
    $command=$connection->createCommand($sql);
    $dataReader=$command->queryAll();

    foreach($dataReader as $row)
    {
      if (file_exists($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'.$row['oldnik'].'.jpg'))
      {
        $pdf->Image($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'. $row['oldnik'] .'.jpg',10,30,30);
      }
      $pdf->setFont('Arial','B',10);
      $pdf->text(50,30,'Nama: '.$row['fullname']);
      $pdf->setFont('Arial','',8);
      $pdf->text(50,35,'Golongan: '.$row['levelorgname']);
      $pdf->text(50,40,'Struktur: '.$row['structurename']);
      $pdf->text(50,45,'Posisi: '.$row['positionname']);
      $pdf->text(50,50,'Jenis Kelamin: '.$row['sexname']);
      $pdf->text(50,55,'Email Utama: '.$row['email']);
      $pdf->text(50,65,'Email ke-2: '.$row['alternateemail']);
      $pdf->text(50,70,'Telp: '.$row['phoneno']);
      $pdf->text(50,75,'No HP: '.$row['hpno']);
      $sql1 = "select informalname, organizer, period,isdiploma,sponsoredby
        from employeeinformal a
        where recordstatus=1 and employeeid = ".$row['employeeid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $pdf->text(10,90,'Course / Trainig / skill List');
      $pdf->SetY(95);
      $pdf->setaligns(array('C','C','C','C','C'));
      $pdf->setwidths(array(50,40,30,30,30));
      $pdf->Row(array('Course / Training / Skill','Organizer','Period','Is Diploma','Sponsored By'));
      $pdf->setaligns(array('L','L','C','C','L'));
      foreach($dataReader1 as $row1)
      {
        $pdf->row(array($row1['informalname'],$row1['organizer'],$row1['period'],
            ($row1['isdiploma']==1)?'V':'',$row1['sponsoredby']));
      }
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
		$model=Employeeinformal::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeeinformal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

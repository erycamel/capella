<?php

class PermitexittransController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'permitexittrans';

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
	   $permitexit=new Permitexit('searchwstatus');
	  $permitexit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Permitexit']))
		$permitexit->attributes=$_GET['Permitexit'];

	   $employee=new Employee('searchwstatus');
	  $employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$employee->attributes=$_GET['Employee'];

		$model=new Permitexittrans;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'permitexit'=>$permitexit,
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
	  $permitexit=new Permitexit('searchwstatus');
	  $permitexit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Permitexit']))
		$permitexit->attributes=$_GET['Permitexit'];

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
				'permitexittransid'=>$model->permitexittransid,
				'permitexitid'=>$model->permitexitid,
				'permitexitname'=>($model->permitexit!==null)?$model->permitexit->permitexitname:"",
				'employeeid'=>$model->employeeid,
				'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
				'permitexitdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->permitexitdate)),
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'permitexit'=>$permitexit,
			'employee'=>$employee), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Permitexittrans'], $_POST['Permitexittrans']['permitexittransid']);
    }

	public function actionWrite()
	{
            parent::actionWrite();
	  if(isset($_POST['Permitexittrans']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Permitexittrans']['permitexitdate'],'heejemptypermitexitdate','emptystring'),
                array($_POST['Permitexittrans']['employeeid'],'heejemptyemployeeid','emptystring'),
                array($_POST['Permitexittrans']['permitexitid'],'heejemptypermitexitid','emptystring'),
            )
        );
        if ($messages == '') {
          $permitexitdate = date(Yii::app()->params['datetodb'], strtotime($_POST['Permitexittrans']['permitexitdate']));
		//$_POST['Permitexittrans']=$_POST['Permitexittrans'];
		if ((int)$_POST['Permitexittrans']['permitexittransid'] > 0)
		{
              $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call UpdatePermitExitTrans(:vpermitexittransid,:vpermitexitdate,
				  :vemployeeid,:vpermitexitid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindParam(':vpermitexittransid',$_POST['Permitexittrans']['permitexittransid'],PDO::PARAM_INT);
				$command->bindParam(':vpermitexitdate',$permitexitdate,PDO::PARAM_STR);
				$command->bindParam(':vemployeeid',$_POST['Permitexittrans']['employeeid'],PDO::PARAM_INT);
				$command->bindParam(':vpermitexitid',$_POST['Permitexittrans']['permitexitid'],PDO::PARAM_INT);
				$post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
				$command->bindParam(':vlastupdateby', $post,PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Permitexittrans']['permitexittransid']);
              $this->GetSMessage('hrpapetinsertsuccess');
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				  $transaction->rollBack();
              $this->GetMessage($e->getMessage());
			  }
		  }
		  else
		  {
			  $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call InsertPermitExitTrans(:vpermitexitdate,
				  :vemployeeid,:vpermitexitid, :vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindParam(':vpermitexitdate',$permitexitdate,PDO::PARAM_STR);
				$command->bindParam(':vemployeeid',$_POST['Permitexittrans']['employeeid'],PDO::PARAM_INT);
				$command->bindParam(':vpermitexitid',$_POST['Permitexittrans']['permitexitid'],PDO::PARAM_INT);
				$post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
				$command->bindParam(':vcreatedby', $post,PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Permitexittrans']['permitexittransid']);
              $this->GetSMessage('hrpapetinsertsuccess');
			  }
			  catch (Exception $e)
			  {
				$transaction->rollBack();
              $this->GetMessage($e->getMessage());
			  }
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

    public function actionApprove()
	{
            parent::actionApprove();
		$id=$_POST['id'];
		foreach($id as $ids)
		{
			//$model=$this->loadModel($ids);
                    $a = Yii::app()->user->name;
			$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call ApprovePermitExitTrans(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$ids,PDO::PARAM_INT);
				$command->bindvalue(':vlastupdateby', $a,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->GetSMessage('pprinsertsuccess');
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				  $transaction->rollBack();
				  $this->GetMessage($e->getMessage());
			  }
		}
        Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
	  $permitexit=new Permitexit('searchwstatus');
	  $permitexit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Permitexit']))
		$permitexit->attributes=$_GET['Permitexit'];

	   $employee=new Employee('searchwstatus');
	  $employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$employee->attributes=$_GET['Employee'];
		$model=new Permitexittrans('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Permitexittrans']))
			$model->attributes=$_GET['Permitexittrans'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
			'permitexit'=>$permitexit,
			'employee'=>$employee
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
			  $model=Absrule::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Absrule();
			  }
			  $model->absruleid = (int)$data[0];
			  $model->absscheduleid = (int)$data[1];
			  $model->difftimein = $data[2];
			  $model->difftimeout = $data[3];
			  $model->absstatusid = (int)$data[4];
			  $model->recordstatus = 1;
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
	  $pdf->title='Permit Exit Transaction List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select a.employeeid,a.fullname, a.oldnik, b.levelorgname, c.structurename,d.positionname,e.employeetypename,
        f.sexname,joindate,email,phoneno,alternateemail,hpno,a.addressbookid,g.permitexittransid
      from employee a
      left join levelorg b on b.levelorgid = a.levelorgid
      left join orgstructure c on c.orgstructureid = a.orgstructureid
      left join position d on d.positionid = a.positionid
      left join employeetype e on e.employeetypeid = a.employeetypeid
      left join sex f on f.sexid = a.sexid
inner join permitexittrans g on g.employeeid = a.employeeid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where g.permitexittransid = ".$_GET['id'];
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

      $sql1 = "select  a.permitexitdate, a.nodocument, c.permitexitname
        from permitexittrans a
        left join permitexit c on c.permitexitid = a.permitexitid
        where employeeid  = ".$row['employeeid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $pdf->text(10,90,'Permit Exit Transaction List');
      $pdf->SetY(95);
      $pdf->setaligns(array('C','C','C','C','C','C','C'));
      $pdf->setwidths(array(25,40,35,30,25,25,25));
      $pdf->Row(array('Date','Document No','Reason'));
      $pdf->setaligns(array('L','L','L','L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $pdf->row(array($row1['permitexitdate'],$row1['nodocument'],$row1['permitexitname']));
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
		$model=Permitexittrans::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='permitexittrans-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class SicktransController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'sicktrans';
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

    public $employee, $hospital;

    public function lookupdata()
    {
      $this->employee=new Employee('searchwstatus');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$this->employee->attributes=$_GET['Employee'];

		$this->hospital=new Hospital('searchwstatus');
	  $this->hospital->unsetAttributes();  // clear any default values
	  if(isset($_GET['Hospital']))
		$this->hospital->attributes=$_GET['Hospital'];
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
      $this->lookupdata();
      $model=new Sicktrans;
      if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'employee'=>$this->employee,
                  'hospital'=>$this->hospital), true)
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
	  $this->lookupdata();
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

		if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'sicktransid'=>$model->sicktransid,
				'sickdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->sickdate)),
				'employeeid'=>$model->employeeid,
				'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
				'hospitalid'=>$model->hospitalid,
				'hospitalname'=>($model->hospital!==null)?$model->hospital->fullname:"",
				'doctorname'=>$model->doctorname,
				'takedatefrom'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->takedatefrom)),
				'takedateto'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->takedateto)),
				'diagnosa'=>$model->diagnosa,
				'nodocument'=>$model->nodocument,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'employee'=>$this->employee,
                  'hospital'=>$this->hospital), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Sicktrans'], $_POST['Sicktrans']['sicktransid']);
    }

	public function actionWrite()
	{
            parent::actionWrite();
	  if(isset($_POST['Sicktrans']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Sicktrans']['employeeid'],'heejemptyemployeeid','emptystring'),
                array($_POST['Sicktrans']['sickdate'],'heejemptysickdate','emptystring'),
                array($_POST['Sicktrans']['takedatefrom'],'heejemptytakedatefrom','emptystring'),
                array($_POST['Sicktrans']['takedateto'],'heejemptytakedateto','emptystring'),
            )
        );
        if ($messages == '') {
        $sickdate = date(Yii::app()->params['datetodb'], strtotime($_POST['Sicktrans']['sickdate']));
          $takedatefrom = date(Yii::app()->params['datetodb'], strtotime($_POST['Sicktrans']['takedatefrom']));
          $takedateto = date(Yii::app()->params['datetodb'], strtotime($_POST['Sicktrans']['takedateto']));
		  //$dataku->attributes=$_POST['Sicktrans'];
		  if ((int)$_POST['Sicktrans']['sicktransid'] > 0)
		  {
			  $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call UpdateSickTrans(:vsicktransid,:vsickdate,
				  :vemployeeid,:vhospitalid,:vdoctorname,
				  :vtakedatefrom, :vtakedateto, :vdiagnosa, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindParam(':vsicktransid',$_POST['Sicktrans']['sicktransid'],PDO::PARAM_INT);
				$command->bindParam(':vsickdate',$sickdate,PDO::PARAM_STR);
				$command->bindParam(':vemployeeid',$_POST['Sicktrans']['employeeid'],PDO::PARAM_INT);
				$command->bindParam(':vhospitalid',$_POST['Sicktrans']['hospitalid'],PDO::PARAM_INT);
				$command->bindParam(':vdoctorname',$_POST['Sicktrans']['doctorname'],PDO::PARAM_STR);
				$command->bindParam(':vtakedatefrom',$takedatefrom,PDO::PARAM_STR);
				$command->bindParam(':vtakedateto',$takedateto,PDO::PARAM_STR);
				$command->bindParam(':vdiagnosa',$_POST['Sicktrans']['diagnosa'],PDO::PARAM_STR);
				$post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
				$command->bindParam(':vlastupdateby', $post,PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
                 $this->GetSMessage('hrmbtinsertsuccess');
				$this->DeleteLock($this->menuname, $_POST['Sicktrans']['sicktransid']);
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				  $transaction->rollBack();
				  $this->GetMessage($e->getMessage());
			  }
		  }
		  else
		  {
			$model = new Sicktrans();
			  $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call InsertSickTrans(:vsickdate,
				  :vemployeeid,:vhospitalid,:vdoctorname,
				  :vtakedatefrom, :vtakedateto, :vdiagnosa, :vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindParam(':vsickdate',$sickdate,PDO::PARAM_STR);
				$command->bindParam(':vemployeeid',$_POST['Sicktrans']['employeeid'],PDO::PARAM_INT);
				$command->bindParam(':vhospitalid',$_POST['Sicktrans']['hospitalid'],PDO::PARAM_INT);
				$command->bindParam(':vdoctorname',$_POST['Sicktrans']['doctorname'],PDO::PARAM_STR);
				$command->bindParam(':vtakedatefrom',$takedatefrom,PDO::PARAM_STR);
				$command->bindParam(':vtakedateto',$takedateto,PDO::PARAM_STR);
				$command->bindParam(':vdiagnosa',$_POST['Sicktrans']['diagnosa'],PDO::PARAM_STR);
				$post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
				$command->bindParam(':vcreatedby', $post,PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
                 $this->GetSMessage('hrmbtinsertsuccess');
				$this->DeleteLock($this->menuname, $_POST['Sicktrans']['sicktransid']);
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
	  $this->lookupdata();

    $model=new Sicktrans('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Sicktrans']))
			$model->attributes=$_GET['Sicktrans'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
                  'employee'=>$this->employee,
                  'hospital'=>$this->hospital
		));
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
          $sql = 'call ApproveSickTrans(:vid, :vlastupdateby)';
          $command=$connection->createCommand($sql);
          $command->bindValue(':vid',$ids,PDO::PARAM_INT);
          $command->bindValue(':vlastupdateby', $a,PDO::PARAM_STR);
          $command->execute();
          $transaction->commit();
          $this->GetSMessage('agjapprovesuccess');
        }
        catch(Exception $e) // an exception is raised if a query fails
        {
            $transaction->rollBack();
            $this->GetMessage($e->getMessage());
        }
      }
      Yii::app()->end();
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
	  $pdf->title='Sickness Transaction List';
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
      left join sicktrans g on g.employeeid = a.employeeid ";
if ($_GET['id'] !== '') {
				$sql = $sql . "where g.sicktransid = ".$_GET['id'];
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

      $sql1 = "select a.sickdate, a.nodocument, b.fullname, a.doctorname, 
        a.takedatefrom, a.takedateto, a.diagnosa
        from sicktrans a
        left join addressbook b on b.addressbookid = a.hospitalid
        where employeeid = ".$row['employeeid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $pdf->text(10,90,'Sicktrans List');
      $pdf->SetY(95);
      $pdf->setaligns(array('C','C','C','C','C','C','C'));
      $pdf->setwidths(array(25,25,35,30,25,25,25));
      $pdf->Row(array('Date','No Document','Hospital','Doctor Name',
          'Take Date From','Take Date To','Diagnosa'));
      $pdf->setaligns(array('L','L','L','L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $pdf->row(array($row1['sickdate'],$row1['nodocument'],$row1['fullname'],
            $row1['doctorname'],$row1['takedatefrom'],$row1['takedateto'],$row1['diagnosa']));
      }
      $pdf->AddPage('P');
    }
    // me-render ke browser
    $pdf->Output('sicktrans.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Sicktrans::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sicktrans-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
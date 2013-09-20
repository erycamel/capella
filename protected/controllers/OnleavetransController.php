<?php

class OnleavetransController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'onleavetrans';

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

    public $onleavetype,$employee;

    public function lookupdata()
    {
      $this->onleavetype=new Onleavetype('searchwstatus');
	  $this->onleavetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Onleavetype']))
		$this->onleavetype->attributes=$_GET['Onleavetype'];

	  $this->employee=new Employee('searchwstatus');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$this->employee->attributes=$_GET['Employee'];
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
      $this->lookupdata();
      $model=new Onleavetrans;
      if (Yii::app()->request->isAjaxRequest)
      {
        echo CJSON::encode(array(
            'status'=>'success',
            'div'=>$this->renderPartial('_form', array('model'=>$model,
              'onleavetype'=>$this->onleavetype,
              'employee'=>$this->employee), true)
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
      if (Yii::app()->request->isAjaxRequest)
      {
        echo CJSON::encode(array(
            'status'=>'success',
            'onleavetransid'=>$model->onleavetransid,
            'onleavedate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->onleavedate)),
            'employeeid'=>$model->employeeid,
            'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
            'onleavetypeid'=>$model->onleavetypeid,
            'onleavename'=>($model->onleavetype!==null)?$model->onleavetype->onleavename:"",
            'datefrom'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->datefrom)),
            'dateto'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->dateto)),
            'reason'=>$model->reason,
            'recordstatus'=>$model->recordstatus,
            'div'=>$this->renderPartial('_form', array('model'=>$model,
              'onleavetype'=>$this->onleavetype,
              'employee'=>$this->employee), true)
            ));
        Yii::app()->end();
      }
	}

	public function actionWrite()
	{
      parent::actionWrite();
	  if(isset($_POST['Onleavetrans']))
	  {
                $messages = $this->ValidateData(
                array(array($_POST['Onleavetrans']['employeeid'],'heejemptyemployeeid','emptystring'),
                array($_POST['Onleavetrans']['onleavetypeid'],'heejemptyonleavetypeid','emptystring'),
                array($_POST['Onleavetrans']['onleavedate'],'heejemptysickdate','emptystring'),
                array($_POST['Onleavetrans']['datefrom'],'heejemptytakedatefrom','emptystring'),
                array($_POST['Onleavetrans']['dateto'],'heejemptytakedateto','emptystring'),
                    array($_POST['Onleavetrans']['reason'],'heejemptyreason','emptystring'),
            )
        );
        if ($messages == '') {
        $onleavedate = date(Yii::app()->params['datetodb'], strtotime($_POST['Onleavetrans']['onleavedate']));
        $datefrom = date(Yii::app()->params['datetodb'], strtotime($_POST['Onleavetrans']['datefrom']));
        $dateto = date(Yii::app()->params['datetodb'], strtotime($_POST['Onleavetrans']['dateto']));


        //$dataku->attributes=$_POST['Onleavetrans'];
        if ((int)$_POST['Onleavetrans']['onleavetransid'] > 0)
        {
          $connection=Yii::app()->db;
          $transaction=$connection->beginTransaction();
          try
          {
            $sql = 'call UpdateOnLeave(:vonleavetransid,:vonleavedate,
              :vemployeeid,:vonleaveid,:vdatefrom, :vdateto, :vreason, :vlastupdateby)';
            $command=$connection->createCommand($sql);
            $command->bindParam(':vonleavetransid',$_POST['Onleavetrans']['onleavetransid'],PDO::PARAM_INT);
            $command->bindParam(':vonleavedate',$onleavedate,PDO::PARAM_STR);
            $command->bindParam(':vemployeeid',$_POST['Onleavetrans']['employeeid'],PDO::PARAM_INT);
            $command->bindParam(':vonleaveid',$_POST['Onleavetrans']['onleavetypeid'],PDO::PARAM_INT);
            $command->bindParam(':vdatefrom',$datefrom,PDO::PARAM_STR);
            $command->bindParam(':vdateto',$dateto,PDO::PARAM_STR);
            $command->bindParam(':vreason',$_POST['Onleavetrans']['reason'],PDO::PARAM_STR);
            $post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
            $command->bindParam(':vlastupdateby', $post,PDO::PARAM_INT);
            $command->execute();
            $transaction->commit();
            $this->GetSMessage('hrtmasinsertsuccess');
          }
          catch(Exception $e) // an exception is raised if a query fails
          {
              $transaction->rollBack();
              $this->GetMessage($e->getMessage());
          }
        }
        else
        {
          $model = new Onleavetrans();
            $connection=Yii::app()->db;
            $transaction=$connection->beginTransaction();
            try
            {
              $sql = 'call InsertOnleaveTrans(:vonleavedate,
                :vemployeeid,:vonleaveid, :vdatefrom, :vdateto, :vreason, :vcreatedby)';
              $command=$connection->createCommand($sql);
            $command->bindParam(':vonleavedate',$onleavedate,PDO::PARAM_STR);
            $command->bindParam(':vemployeeid',$_POST['Onleavetrans']['employeeid'],PDO::PARAM_INT);
            $command->bindParam(':vonleaveid',$_POST['Onleavetrans']['onleavetypeid'],PDO::PARAM_INT);
            $command->bindParam(':vdatefrom',$datefrom,PDO::PARAM_STR);
            $command->bindParam(':vdateto',$dateto,PDO::PARAM_STR);
            $command->bindParam(':vreason',$_POST['Onleavetrans']['reason'],PDO::PARAM_STR);
              $post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
              $command->bindParam(':vcreatedby', $post,PDO::PARAM_INT);
              $command->execute();
              $transaction->commit();
              $this->GetSMessage('hrtmasinsertsuccess');
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
    
    public function actionDownload()
  {
    parent::actionDownload();
    $pdf = new PDF();
	  $pdf->title='Onleave Transaction List';
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
      left join onleavetrans g on g.employeeid = a.employeeid ";
if ($_GET['id'] !== '') {
				$sql = $sql . "where g.onleavetransid = ".$_GET['id'];
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

      $sql1 = "select a.onleavedate, c.onleavename, a.datefrom,a.dateto,a.reason,a.nodocument
        from onleavetrans a
        left join onleavetype c on c.onleavetypeid = a.onleavetypeid
        where employeeid = ".$row['employeeid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $pdf->text(10,90,'Onleave Transaction List');
      $pdf->SetY(95);
      $pdf->setaligns(array('C','C','C','C','C','C','C'));
      $pdf->setwidths(array(25,40,35,30,25,25,25));
      $pdf->Row(array('Date','Document No','Onleave Type','Date From','Date To','Reason'));
      $pdf->setaligns(array('L','L','L','L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $pdf->row(array($row1['onleavedate'],$row1['nodocument'],$row1['onleavename'],
            $row1['datefrom'],$row1['dateto'],$row1['reason']));
      }
      $pdf->AddPage('P');
    }
    // me-render ke browser
    $pdf->Output('onleavetrans.pdf','D');
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
        $model=Onleavetrans::model()->findByPk($ids);
        $model->recordstatus=0;
        if($model->save())
            {
              echo CJSON::encode(array(
              'status'=>'success',
              'div'=>'Data deleted'
              ));
            }
            else
            {
              echo CJSON::encode(array(
              'status'=>'failure',
              'div'=>$model->getErrors()
              ));
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
	  $onleavetype=new Onleavetype('searchwstatus');
	  $onleavetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Onleavetype']))
		$onleavetype->attributes=$_GET['Onleavetype'];

	  $employee=new Employee('searchwstatus');
	  $employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$employee->attributes=$_GET['Employee'];
		
   $model=new Onleavetrans('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Onleavetrans']))
			$model->attributes=$_GET['Onleavetrans'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
			'onleavetype'=>$onleavetype,
			'employee'=>$employee
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
				$sql = 'call ApproveOnleaveTrans(:vid, :vlastupdateby)';
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Onleavetrans::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='onleavetrans-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

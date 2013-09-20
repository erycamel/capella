<?php

class TroubleticketController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'troubleticket';

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
	  $project=new Project('searchwfstatus');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];
	  $model=new Troubleticket;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>$this->renderPartial('_form', array('model'=>$model,'project'=>$project), true)
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
	  $project=new Project('searchwfstatus');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];
	  $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'troubleticketid'=>$model->troubleticketid,
			  'serviceno'=>$model->serviceno,
			  'customername'=>$model->customername,
			  'unitkerja'=>$model->unitkerja,
			  'phoneno'=>$model->phoneno,
			  'mobilephoneno'=>$model->mobilephoneno,
			  'customeraddress'=>$model->customeraddress,
			  'useraccessid'=>$model->useraccessid,
              'realname'=>($model->userku!==null)?$model->userku->realname:"",
			  'recordstatus'=>$model->recordstatus,
			  'description'=>$model->description,
			  'startdate'=>date(Yii::app()->params['datetimeviewfromdb'], strtotime($model->startdate)),
			  'enddate'=>date(Yii::app()->params['datetimeviewfromdb'], strtotime($model->enddate)),
			  'troubleticketstatusid'=>$model->troubleticketstatusid,
              'troublecode'=>($model->troubleticketstatus!==null)?$model->troubleticketstatus->troublecode:"",
			  'div'=>$this->renderPartial('_form', array('model'=>$model,'project'=>$project), true)
			  ));
		  Yii::app()->end();
	  }
	}
	
	public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Troubleticket'], $_POST['Troubleticket']['troubleticketid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Troubleticket']))
	  {
        $messages = $this->ValidateData(
                array(
                array($_POST['Troubleticket']['customername'],'hrtasemptycustomername','emptystring'),
                array($_POST['Troubleticket']['unitkerja'],'hrtasemptyunitkerja','emptystring'),
                array($_POST['Troubleticket']['useraccessid'],'hrtasemptyuseraccessid','emptystring'),
                array($_POST['Troubleticket']['troubleticketstatusid'],'hrtasemptytroubleticketstatusid','emptystring'),
                array($_POST['Troubleticket']['startdate'],'hrtasemptystartdate','emptystring'),
                array($_POST['Troubleticket']['enddate'],'hrtasemptyenddate','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Troubleticket'];
		if ((int)$_POST['Troubleticket']['troubleticketid'] > 0)
		{
		  $model=$this->loadModel($_POST['Troubleticket']['troubleticketid']);
		  $model->serviceno = $_POST['Troubleticket']['serviceno'];
		  $model->customername = $_POST['Troubleticket']['customername'];
		  $model->unitkerja = $_POST['Troubleticket']['unitkerja'];
		  $model->phoneno = $_POST['Troubleticket']['phoneno'];
		  $model->mobilephoneno = $_POST['Troubleticket']['mobilephoneno'];
		  $model->customeraddress = $_POST['Troubleticket']['customeraddress'];
		  $model->description = $_POST['Troubleticket']['description'];
		  $model->useraccessid = $_POST['Troubleticket']['useraccessid'];
		  $model->startdate = $_POST['Troubleticket']['startdate'];
		  $model->enddate = $_POST['Troubleticket']['enddate'];
		  $model->troubleticketstatusid = $_POST['Troubleticket']['troubleticketstatusid'];
		}
		else
		{
		  $model = new Troubleticket();
		  $model->attributes=$_POST['Troubleticket'];
		}
		try
          {
            if($model->save())
            {
				$a = Yii::app()->user->name;
				$connection=Yii::app()->db;
				$transaction=$connection->beginTransaction();
				try
				{
					$sql = 'call ApproveTroubleTicket(:vid, :vlastupdateby)';
					$command=$connection->createCommand($sql);
					$command->bindvalue(':vid',$model->troubleticketid,PDO::PARAM_INT);
					$command->bindvalue(':vlastupdateby', $a,PDO::PARAM_STR);
					$command->execute();
					$transaction->commit();
				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					  $transaction->rollBack();
				}
				$this->DeleteLock($this->menuname,$_POST['Troubleticket']['troubleticketid']);
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
	
	public function actionGetdowntime()
	{
		if (isset($_POST['id']))
		{
			$id=$_POST['id'];
			$connection=Yii::app()->db;
			$sql = "select timediff(a.enddate,a.startdate) as waktu
				from troubleticketdetail a 
				inner join troubleticketstatus b on b.troubleticketstatusid = a.troubleticketstatusid 
				where a.troubleticketid = ".$id." and b.iscount = 1";
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
			$downtime = '';
			foreach($dataReader as $row)
			{
				if ($downtime == '')
				{
					$downtime = $row['waktu'];
				}
				else
				{
					$sql1 = "select addtime('".$row["waktu"]."','".$downtime."') as waktu";
					$command1 = $connection->createCommand($sql1);
					$dataReader1 = $command1->queryAll();
					foreach($dataReader1 as $row1)
					{
						$downtime = $row1['waktu'];
					}
				}
			}
			$waktu = explode(':',$downtime);
			$downtime = ($waktu[0]*60)+($waktu[1]);
			$diffday = intval(floor($downtime/1440));
			$modday = ($downtime%1440);
			$diffhour = intval(floor($modday/60));
			$diffminute = intval(($modday%60));
			echo CJSON::encode(array(
				'status'=>'success',
				'div'=>'Current selected troubleticket Downtime : '.round($diffday)." Day(s), ".round($diffhour)." Hour(s), ".round($diffminute,0)." Minute(s)"
			));
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
	  $troubleticketdetail = new Troubleticketdetail('searchwstatus');
	  $troubleticketdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Troubleticketdetail']))
		$troubleticketdetail->attributes=$_GET['Troubleticketdetail'];
		$project=new Project('searchwfstatus');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];
	  $model=new Troubleticket('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Troubleticket']))
	  	$model->attributes=$_GET['Troubleticket'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
			'model'=>$model,
			'troubleticketdetail'=>$troubleticketdetail,
			'project'=>$project,
	  ));
	}
	
	public function actionUpload()
	{
		parent::actionUpload();
		$folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/document/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploadfile']['name']); 
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
			$spk = explode('.',basename($_FILES['uploadfile']['name']));
			if (count($spk)>0)
			{
				$projectemp = Troubleticketdetail::model()->findbyattributes(array('woino'=>$spk[0]));
				if ($projectemp !== null)
				{
					$projectemp->filename = basename($_FILES['uploadfile']['name']);
					$projectemp->uploaddate = new CDbExpression('NOW()');
					$projectemp->save();
					echo "success";
				}
			}
		} else {
			echo Yii::t('app','directory permission');
		}	
	}

	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select troubleticketid,troubleticketno,serviceno,customername,unitkerja,phoneno,mobilephoneno,
		customeraddress
			from troubleticket a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.troubleticketid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$this->pdf->title='Trouble Ticket List';
		$this->pdf->AddPage('P');

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		foreach($dataReader as $row)
		{
			$this->pdf->text(20,30,'Trouble Ticket No '.$row['troubleticketno']);
			$this->pdf->text(20,35,'Service No '.$row['serviceno']);
			$this->pdf->text(20,40,'Customer Name '.$row['customername']);
			$this->pdf->text(20,45,'Customer Address '.$row['customeraddress']);
			$this->pdf->text(20,50,'Unit Kerja '.$row['unitkerja']);
			$this->pdf->text(20,55,'Phone No '.$row['phoneno']);
			$this->pdf->text(20,60,'Mobile Phone No '.$row['mobilephoneno']);
	  
			$sql1 = "select a.woino, b.realname, a.description, a.startdate, a.enddate, c.troublecode
				from troubleticketdetail a 
				left join useraccess b on b.useraccessid = a.useraccessid
				left join troubleticketstatus c on c.troubleticketstatusid = a.troubleticketstatusid ";
			$command1=$this->connection->createCommand($sql1);
			$dataReader1=$command1->queryAll();
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->setY($this->pdf->gety()+50);
			$this->pdf->setaligns(array('C','C','C','C','C','C'));
			$this->pdf->setwidths(array(30,30,30,30,50,20));
			$this->pdf->Row(array('WOI No','Start Date','End Date','Assign To','Description','Status'));
			$this->pdf->setaligns(array('L','L','L','L','L','L'));
			
			foreach($dataReader1 as $row1)
			{
				$this->pdf->row(array($row1['woino'],
					$row1['startdate'],
					$row1['enddate'],
					$row1['realname'],$row1['description'],$row1['troublecode']));
			}
			
			$sql1 = "select timediff(a.enddate,a.startdate) as waktu
				from troubleticketdetail a 
				inner join troubleticketstatus b on b.troubleticketstatusid = a.troubleticketstatusid 
				where a.troubleticketid = ".$row['troubleticketid']." and b.iscount = 1";
			$command=$this->connection->createCommand($sql1);
			$dataReader1=$command->queryAll();
			$downtime = '';
			foreach($dataReader1 as $row1)
			{
				if ($downtime == '')
				{
					$downtime = $row1['waktu'];
				}
				else
				{
					$sql2 = "select addtime('".$row1["waktu"]."','".$downtime."') as waktu";
					$command2 = $this->connection->createCommand($sql2);
					$dataReader2 = $command2->queryAll();
					foreach($dataReader2 as $row2)
					{
						$downtime = $row2['waktu'];
					}
				}
			}
			$waktu = explode(':',$downtime);
			$downtime = ($waktu[0]*60)+($waktu[1]);
			$diffday = intval(floor($downtime/1440));
			$modday = ($downtime%1440);
			$diffhour = intval(floor($modday/60));
			$diffminute = intval(($modday%60));
			
			$this->pdf->Text(40,$this->pdf->gety()+20,'Downtime : '.round($diffday)." Day(s), ".round($diffhour)." Hour(s), ".round($diffminute,0)." Minute(s)");
			$this->pdf->AddPage('P');
		}
		$this->pdf->Output();
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Troubleticket::model()->findByPk((int)$id);
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
	  if(isset($_POST['ajax']) && $_POST['ajax']==='troubleticket-form')
	  {
		  echo CActiveForm::validate($model);
		  Yii::app()->end();
	  }
	}
}

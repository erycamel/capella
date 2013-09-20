<?php

class ServicedeliveryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'servicedelivery';

	public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpnetwork'; break;
				case 4 : $this->txt = '_helpnetworkmodif'; break;
			}
		}
		parent::actionHelp();
	}

	public $projectservice, $projectpic, $projectlocation, $projectdocument, $projectnetwork,
	$projectemp,$srftime;

	public function lookupdata()
	{
		$this->projectservice=new Projectservice('search');
	  $this->projectservice->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectservice']))
		$this->projectservice->attributes=$_GET['Projectservice'];

		$this->projectpic=new Projectpic('search');
	  $this->projectpic->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectpic']))
		$this->projectpic->attributes=$_GET['Projectpic'];
		
		$this->projectlocation=new Projectlocation('search');
	  $this->projectlocation->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectlocation']))
		$this->projectlocation->attributes=$_GET['Projectlocation'];
		
		$this->projectdocument=new Projectdocument('search');
	  $this->projectdocument->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectdocument']))
		$this->projectdocument->attributes=$_GET['Projectdocument'];
		
		$this->projectnetwork=new Projectnetwork('search');
	  $this->projectnetwork->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectnetwork']))
		$this->projectnetwork->attributes=$_GET['Projectnetwork'];
		
		$this->projectemp=new Projectemp('search');
	  $this->projectemp->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectemp']))
		$this->projectemp->attributes=$_GET['Projectemp'];
		
		$this->srftime=new Srftime('search');
	  $this->srftime->unsetAttributes();  // clear any default values
	  if(isset($_GET['Srftime']))
		$this->srftime->attributes=$_GET['Srftime'];
		
}
	
	public function actionCreatenetwork()
	{
		parent::actionCreate();
		$projectnetwork=new Projectnetwork;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formnetwork',
				  array('model'=>$projectnetwork), true)
				));
            Yii::app()->end();
        }
	}
	
	public function actionCreateemployee()
	{
		parent::actionCreate();
		$projectemp=new Projectemp;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formemployee',
				  array('model'=>$projectemp), true)
				));
            Yii::app()->end();
        }
	}
	
	public function actionCreatelocation()
	{
		parent::actionCreate();
		$projectlocation=new Projectlocation;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formlocation',
				  array('model'=>$projectlocation), true)
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
		parent::actionCreate();
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

	  $this->lookupdata();

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'projectid'=>$model->projectid,
				'projectno'=>$model->projectno,
                'soheaderid'=>$model->soheaderid,
                'sono'=>($model->soheader!==null)?$model->soheader->sono:"",
                'contractno'=>($model->soheader!==null)?$model->soheader->contractno:"",
                'customer'=>($model->soheader!==null)?$model->soheader->customer->fullname:"",
                'projectnote'=>$model->projectnote,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
					'projectservice'=>$this->projectservice,
					'projectpic'=>$this->projectpic,
					'projectdocument'=>$this->projectdocument,
					'projectnetwork'=>$this->projectnetwork,
					'projectlocation'=>$this->projectlocation,
					'projectemp'=>$this->projectemp), true)
				));
            Yii::app()->end();
        }
	}
	
	public function actionUpdatenetwork()
	{
		$id=$_POST['id'];
	  $projectnetwork=$this->loadModelnetwork($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'projectnetworkid'=>$projectnetwork->projectnetworkid,
                'application'=>$projectnetwork->application,
                'technology'=>$projectnetwork->technology,
                'upstream'=>$projectnetwork->upstream,
                'downstream'=>$projectnetwork->downstream,
                'accessmethodid'=>$projectnetwork->accessmethodid,
                'accessmethodname'=>($projectnetwork->accessmethod!==null)?$projectnetwork->accessmethod->accessmethodname:"",
                'originipaddress'=>$projectnetwork->originipaddress,
                'destipaddress'=>$projectnetwork->destipaddress,
                'originnetmask'=>$projectnetwork->originnetmask,
                'destnetmask'=>$projectnetwork->destnetmask,
                'div'=>$this->renderPartial('_formnetwork',
				  array('model'=>$projectnetwork), true)
				));
            Yii::app()->end();
        }
	}
	
	public function actionUpdateemployee()
	{
		$id=$_POST['id'];
	  $projectemp=$this->loadModelemp($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'projectempid'=>$projectemp->projectempid,
                'requestforid'=>$projectemp->requestforid,
                'requestforname'=>($projectemp->requestfor!==null)?$projectemp->requestfor->requestforname:"",
                'employeeid'=>$projectemp->employeeid,
                'fullname'=>($projectemp->employee!==null)?$projectemp->employee->fullname:"",
			  'workdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($projectemp->workdate)),
			  'workdateend'=>date(Yii::app()->params['dateviewfromdb'], strtotime($projectemp->workdateend)),
                'description'=>$projectemp->description,
                'div'=>$this->renderPartial('_formemployee',
				  array('model'=>$projectemp), true)
				));
            Yii::app()->end();
        }
	}
	
	public function actionUpdatepic()
	{
		$id=$_POST['id'];
        $this->lookupdetail();
	  $projectpic=$this->loadModelpic($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'projectpicid'=>$projectpic->projectpicid,
                'picname'=>$projectpic->picname,
                'picdept'=>$projectpic->picdept,
                'pictelp'=>$projectpic->pictelp,
                'picemail'=>$projectpic->picemail,
                'picfunction'=>$projectpic->picfunction,
                'div'=>$this->renderPartial('_formpic',
				  array('model'=>$projectpic), true)
				));
            Yii::app()->end();
        }
	}
	
	public function actionUpdatelocation()
	{
		$id=$_POST['id'];
	  $projectlocation=$this->loadModellocation($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'projectlocationid'=>$projectlocation->projectlocationid,
                'originid'=>$projectlocation->originid,
                'originname'=>($projectlocation->origin!==null)?$projectlocation->origin->fullname:"",
                'destid'=>$projectlocation->destid,
                'destname'=>($projectlocation->dest!==null)?$projectlocation->dest->fullname:"",
                'originaddress'=>$projectlocation->originaddress,
                'destaddress'=>$projectlocation->destaddress,
                'origincityid'=>$projectlocation->origincityid,
                'origincityname'=>($projectlocation->origincity!==null)?$projectlocation->origincity->cityname:"",
                'destcityid'=>$projectlocation->destcityid,
                'destcityname'=>($projectlocation->destcity!==null)?$projectlocation->destcity->cityname:"",
                'originbuilding'=>$projectlocation->originbuilding,
                'destbuilding'=>$projectlocation->destbuilding,
                'div'=>$this->renderPartial('_formlocation',
				  array('model'=>$projectlocation), true)
				));
            Yii::app()->end();
        }
	}
	
	
		    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Project'], $_POST['Project']['projectid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Project']))
	  {
         $messages = $this->ValidateData(
                array(
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Project']['projectid'] > 0)
		{
		  $model=$this->loadModel($_POST['Project']['projectid']);
		}
		else
		{
		  $model = new Project();
		  $model->attributes=$_POST['Project'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Project']['projectid']);
              $this->GetSMessage('ppinsertsuccess');
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
		
	public function actionWritenetwork()
	{
	  if(isset($_POST['Projectnetwork']))
	  {
	  $messages = $this->ValidateData(
                array(
				array($_POST['Projectnetwork']['projectid'],'ppemptyprojectid','emptystring'),
				array($_POST['Projectnetwork']['application'],'ppemptyapplication','emptystring'),
				array($_POST['Projectnetwork']['technology'],'ppemptytechnology','emptystring'),
				array($_POST['Projectnetwork']['upstream'],'ppemptyupstream','emptystring'),
				array($_POST['Projectnetwork']['downstream'],'ppemptydownstream','emptystring'),
				array($_POST['Projectnetwork']['accessmethodid'],'ppemptyaccessmethodid','emptystring'),
				array($_POST['Projectnetwork']['originipaddress'],'ppemptyoriginipaddress','emptystring'),
				array($_POST['Projectnetwork']['destipaddress'],'ppemptydestipaddress','emptystring'),
				array($_POST['Projectnetwork']['originnetmask'],'ppemptyoriginnetmask','emptystring'),
				array($_POST['Projectnetwork']['destnetmask'],'ppemptydestnetmask','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Projectnetwork']['projectnetworkid'] > 0)
		{
		  $model=Projectnetwork::model()->findbyPK($_POST['Projectnetwork']['projectnetworkid']);
		  $model->projectid = $_POST['Projectnetwork']['projectid'];
		  $model->application = $_POST['Projectnetwork']['application'];
	  $model->technology = $_POST['Projectnetwork']['technology'];
	  $model->upstream = $_POST['Projectnetwork']['upstream'];
	  $model->downstream = $_POST['Projectnetwork']['downstream'];
	  $model->accessmethodid = $_POST['Projectnetwork']['accessmethodid'];
	  $model->originipaddress = $_POST['Projectnetwork']['originipaddress'];
	  $model->destipaddress = $_POST['Projectnetwork']['destipaddress'];
	  $model->originnetmask = $_POST['Projectnetwork']['originnetmask'];
	  $model->destnetmask = $_POST['Projectnetwork']['destnetmask'];
						}
		else
		{
		  $model = new Projectnetwork();
		  $model->attributes=$_POST['Projectnetwork'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Projectnetwork']['projectnetworkid']);
              $this->GetSMessage('ppinsertsuccess');
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
	
	public function actionWriteemployee()
	{
	  if(isset($_POST['Projectemp']))
	  {
	  $messages = $this->ValidateData(
                array(
				array($_POST['Projectemp']['projectid'],'ppemptyprojectid','emptystring'),
				array($_POST['Projectemp']['requestforid'],'ppemptyrequestforid','emptystring'),
				array($_POST['Projectemp']['workdate'],'ppemptyworkdate','emptystring'),
				array($_POST['Projectemp']['workdateend'],'ppemptyworkdateend','emptystring'),
				array($_POST['Projectemp']['employeeid'],'ppemptyemployeeid','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Projectemp']['projectempid'] > 0)
		{
		  $model=Projectemp::model()->findbyPK($_POST['Projectemp']['projectempid']);
		  $model->projectid = $_POST['Projectemp']['projectid'];
		  $model->requestforid = $_POST['Projectemp']['requestforid'];
	  $model->workdate = $_POST['Projectemp']['workdate'];
	  $model->workdateend = $_POST['Projectemp']['workdateend'];
	  $model->employeeid = $_POST['Projectemp']['employeeid'];
	  $model->description = $_POST['Projectemp']['description'];
						}
		else
		{
		  $model = new Projectemp();
		  $model->attributes=$_POST['Projectemp'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Projectemp']['projectempid']);
              $this->GetSMessage('ppinsertsuccess');
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
	
	public function actionWritepic()
	{
	  if(isset($_POST['Projectpic']))
	  {
	  $messages = $this->ValidateData(
                array(
				array($_POST['Projectpic']['projectid'],'ppemptyprojectid','emptystring'),
				array($_POST['Projectpic']['picname'],'ppemptypicname','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Projectpic']['projectpicid'] > 0)
		{
		  $model=Projectpic::model()->findbyPK($_POST['Projectpic']['projectpicid']);
		  $model->projectid = $_POST['Projectpic']['projectid'];
		  $model->picname = $_POST['Projectpic']['picname'];
	  $model->picdept = $_POST['Projectpic']['picdept'];
	  $model->picemail = $_POST['Projectpic']['picemail'];
	  $model->pictelp = $_POST['Projectpic']['pictelp'];
	  $model->picfunction = $_POST['Projectpic']['picfunction'];
						}
		else
		{
		  $model = new Projectpic();
		  $model->attributes=$_POST['Projectpic'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Projectpic']['projectpicid']);
              $this->GetSMessage('ppinsertsuccess');
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
	
	public function actionWritelocation()
	{
	  if(isset($_POST['Projectlocation']))
	  {
	  $messages = $this->ValidateData(
                array(
				array($_POST['Projectlocation']['projectid'],'ppemptyprojectid','emptystring'),
				array($_POST['Projectlocation']['originid'],'ppemptyoriginid','emptystring'),
				array($_POST['Projectlocation']['destid'],'ppemptydestid','emptystring'),
				array($_POST['Projectlocation']['originaddress'],'ppemptyoriginaddress','emptystring'),
				array($_POST['Projectlocation']['destaddress'],'ppemptydestaddress','emptystring'),
				array($_POST['Projectlocation']['origincityid'],'ppemptyorigincityid','emptystring'),
				array($_POST['Projectlocation']['destcityid'],'ppemptydestcityid','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Projectlocation']['projectlocationid'] > 0)
		{
		  $model=Projectlocation::model()->findbyPK($_POST['Projectlocation']['projectlocationid']);
		  $model->projectid = $_POST['Projectlocation']['projectid'];
		  $model->originid = $_POST['Projectlocation']['originid'];
	  $model->destid = $_POST['Projectlocation']['destid'];
	  $model->originaddress = $_POST['Projectlocation']['originaddress'];
	  $model->destaddress = $_POST['Projectlocation']['destaddress'];
	  $model->origincityid = $_POST['Projectlocation']['origincityid'];
	  $model->destcityid = $_POST['Projectlocation']['destcityid'];
	  $model->originbuilding = $_POST['Projectlocation']['originbuilding'];
	  $model->destbuilding = $_POST['Projectlocation']['destbuilding'];
						}
		else
		{
		  $model = new Projectlocation();
		  $model->attributes=$_POST['Projectlocation'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Projectlocation']['projectlocationid']);
              $this->GetSMessage('ppinsertsuccess');
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
	
	public function actionDeletenetwork()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Projectnetwork::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	public function actionDeleteemp()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Projectemp::model()->findbyPK($ids);
		  $model->delete();
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
            $sql = 'call Approveproject(:vid, :vlastupdateby)';
            $command=$connection->createCommand($sql);
            $command->bindParam(':vid',$ids,PDO::PARAM_INT);
            $command->bindParam(':vlastupdateby', $a,PDO::PARAM_STR);
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
	  $this->lookupdata();
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
					'projectservice'=>$this->projectservice,
					'projectpic'=>$this->projectpic,
										'projectlocation'=>$this->projectlocation,
										'projectdocument'=>$this->projectdocument,
										'projectnetwork'=>$this->projectnetwork,
										'projectemp'=>$this->projectemp,
					'srftime'=>$this->srftime
		));
	}

	public function actionIndexservice()
	{
		$this->lookupdata();
	  $this->renderPartial('indexservice',
		array('projectservice'=>$this->projectservice));
	  Yii::app()->end();
	}
	
	public function actionIndexpic()
	{
		$this->lookupdata();
	  $this->renderPartial('indexpic',
		array('projectpic'=>$this->projectpic));
	  Yii::app()->end();
	}
	
	public function actionIndexdocument()
	{
		$this->lookupdata();
	  $this->renderPartial('indexdocument',
		array('projectdocument'=>$this->projectdocument));
	  Yii::app()->end();
	}
	
	public function actionIndexlocation()
	{
		$this->lookupdata();
	  $this->renderPartial('indexlocation',
		array('projectlocation'=>$this->projectlocation));
	  Yii::app()->end();
	}
	
	public function actionIndexnetwork()
	{
		$this->lookupdata();
	  $this->renderPartial('indexnetwork',
		array('projectnetwork'=>$this->projectnetwork));
	  Yii::app()->end();
	}
	
	public function actionIndexemp()
	{
		$this->lookupdata();
	  $this->renderPartial('indexemp',
		array('projectemp'=>$this->projectemp));
	  Yii::app()->end();
	}
	
	public function actionUploaddoc()
	{
		parent::actionUpload();
		$folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/document/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploadfile']['name']); 
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
			$spk = explode('.',basename($_FILES['uploadfile']['name']));
			if (count($spk)>0)
			{
				$projectemp = Projectemp::model()->findbyattributes(array('spkno'=>$spk[0]));
				if ($projectemp !== null)
				{
					$projectemp->filename = basename($_FILES['uploadfile']['name']);
					$projectemp->realdate = new CDbExpression('NOW()');
					$projectemp->uploaddate = new CDbExpression('NOW()');
					$projectemp->save();
					echo "success";
				}
			}
		} else {
			echo Yii::t('app','directory permission');
		}	
	}
	
	public function actionUploaddocbaol()
	{
		parent::actionUpload();
		$folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/document/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploaddocbaol']['name']); 
		if (move_uploaded_file($_FILES['uploaddocbaol']['tmp_name'], $file)) { 
		// baol SRF-N-05-12-00006.rar
			$spk = explode('.',basename($_FILES['uploaddocbaol']['name']));
			$baol = explode(' ',$spk[0]);
			if (count($spk)>0)
			{
				$projectno = str_replace('-','/',$baol[1]);
				$project = Project::model()->findbyattributes(array('projectno'=>$projectno));
				if ($project !== null)
				{
					$projectemp = Projectdocument::model()->findbyattributes(array('documentname'=>$baol[0],'projectid'=>$project->projectid));
					if ($projectemp !== null)
					{
						$projectemp->filename = basename($_FILES['uploaddocbaol']['name']);
						$projectemp->uploaddate = new CDbExpression('NOW()');
						$projectemp->save();
						echo "success";
					}
				} 
			}
		} else {
			echo Yii::t('app','directory permission');
		}	
	}

	public function actionDownload()
	{
		parent::actionDownload();
		if (isset($_GET['id']))
		{
			$pdf = new PDF();
			$pdf->title='Service Request Form';
			$pdf->AddPage('P');
			$pdf->setFont('Arial','B',12);

			// definisi font

			// menuliskan tabel
			$connection=Yii::app()->db;
			$sql = "select a.projectno,a.projectdate,c.description,b.projectname,b.contractno,b.addressbookid
			  from project a 
			  inner join soheader b on b.soheaderid = a.soheaderid
			  inner join projecttype c on c.projecttypeid = b.projecttypeid
			  where projectid = ". $_GET['id'];
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();

			foreach($dataReader as $row)
			{
				$pdf->setfillcolor(248,244,244);
				$pdf->rect(15,30,180,8,'DF');
				$pdf->setFont('Arial','B',8);
				$pdf->text(20,35,'Data Utama');
				$pdf->setfillcolor(255,255,255);
				$pdf->rect(15,38,180,30,'D');
				$pdf->text(20,43,'Tgl SRF');$pdf->text(40,43,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['projectdate'])));
				$pdf->text(20,50,'No SRF');$pdf->text(40,50,': '.$row['projectno']);
				$pdf->text(20,55,'Nama Proyek');$pdf->text(40,55,': '.$row['projectname']);
				$pdf->text(20,60,'Jenis Proyek');$pdf->text(40,60,': '.$row['description']);
				$pdf->text(20,65,'No SPK / LOI');$pdf->text(40,65,': '.$row['contractno']);

				$sql1 = "select b.requestforname,a.dateofdelivery,a.dateofdeliverydevice,a.estimatedelivery,a.installdate,a.onlinedate,c.contracttermname
					  from projectservice a 
					  inner join requestfor b on b.requestforid = a.requestforid
					  inner join contractterm c on c.contracttermid = a.contracttermid
					  where projectid = ". $_GET['id'];
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();

				$pdf->setfillcolor(248,244,244);
				$pdf->rect(15,70,180,8,'DF');
				$pdf->text(20,75,'Data Permintaan');
				$pdf->setFont('Arial','B',6);
				$pdf->setaligns(array('C','C','C','C','C','C','C'));
				$pdf->setwidths(array(40,20,30,20,20,20,30));
				$pdf->setFont('Arial','',6);
				$pdf->setxy(15,78);
				$pdf->Row(array('Request For','Date of Delivery','Date of Delivery Device','Estimate Delivery','Install Date','Online Date','Contract Term'));
				$pdf->setaligns(array('L','L','L','L','L','L','L'));
				$pdf->setx(15);
				foreach($dataReader1 as $row1)
				{
					$pdf->setx(15);
					$pdf->row(array($row1['requestforname'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['dateofdelivery'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['dateofdeliverydevice'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['estimatedelivery'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['installdate'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['onlinedate'])),			
						$row1['contracttermname']));
				}
				
				$sql1 = "select fullname,b.addressname, c.cityname, d.provincename, b.phoneno
					  from addressbook a 
					  inner join address b on b.addressbookid = a.addressbookid
					  left join city c on c.cityid = b.cityid
					  inner join province d on d.provinceid = c.provinceid
					  where a.addressbookid = ". $row['addressbookid'] . " limit 1 ";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				
				$pdf->sety($pdf->gety()+2);
				$pdf->setfillcolor(248,244,244);
				$pdf->setFont('Arial','B',8);
				$pdf->rect(15,$pdf->gety(),180,8,'DF');
				$pdf->text(20,$pdf->gety()+5,'Informasi Perusahaan');
				$pdf->setfillcolor(248,244,244);
				$pdf->rect(15,$pdf->gety()+8,180,30,'D');
				$pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$pdf->text(20,$pdf->gety()+15,'Nama Perusahaan');$pdf->text(40,$pdf->gety()+15,': '.$row1['fullname']);
					$pdf->text(20,$pdf->gety()+20,'Alamat ');$pdf->text(40,$pdf->gety()+20,': '.$row1['addressname']);
					$pdf->text(20,$pdf->gety()+25,'Kota Perusahaan');$pdf->text(40,$pdf->gety()+25,': '.$row1['cityname']);
					$pdf->text(20,$pdf->gety()+30,'Propinsi / Negara');$pdf->text(40,$pdf->gety()+30,': '.$row1['provincename']);
					$pdf->text(20,$pdf->gety()+35,'Nomor Telepon');$pdf->text(40,$pdf->gety()+30,': '.$row1['phoneno']);
				}
				
				$sql1 = "select picname,picfunction,picemail,picdept,pictelp
					  from projectpic a 
					  where projectid = ". $_GET['id'];
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();

				$pdf->setxy(15,$pdf->gety()+40);
				$pdf->setfillcolor(248,244,244);
				$pdf->rect(15,$pdf->gety(),180,8,'DF');
				$pdf->setFont('Arial','B',8);
				$pdf->text(20,$pdf->gety()+5,'Data Penanggung Jawab');
				$pdf->setxy(15,$pdf->gety()+8);
				$pdf->setaligns(array('C','C','C','C','C','C','C'));
				$pdf->setwidths(array(40,40,30,40,30,60,40));
				$pdf->Row(array('Nama','Bagian','No Telp','Email','Fungsi'));
				$pdf->setaligns(array('L','L','L','L','L','L','L'));
				$pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$pdf->setx(15);
					$pdf->row(array($row1['picname'],$row1['picdept'],$row1['pictelp'],$row1['picemail'],$row1['picfunction']));
				}
				
				$sql1 = "select b.fullname as originname, c.fullname as destname, a.originaddress,a.destaddress, d.cityname as origincityname,
					  e.cityname as destcityname
					  from projectlocation a 
					  left join addressbook b on b.addressbookid = a.originid
					  left join addressbook c on c.addressbookid = a.destid
					  left join city d on d.cityid = a.origincityid
					  left join city e on e.cityid = a.destcityid
					  where a.projectid = ". $_GET['id'] . " limit 1 ";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				
				$pdf->setxy(15,$pdf->gety()+3);
				$pdf->setfillcolor(248,244,244);
				$pdf->setFont('Arial','B',8);
				$pdf->rect(15,$pdf->gety(),180,8,'DF');
				$pdf->text(20,$pdf->gety()+5,'Data Lokasi');
				$pdf->setfillcolor(248,244,244);
				$pdf->rect(15,$pdf->gety()+8,60,8,'DF');
				$pdf->rect(75,$pdf->gety()+8,60,8,'DF');
				$pdf->rect(135,$pdf->gety()+8,60,8,'DF');
				$pdf->text(20,$pdf->gety()+13,'Keterangan');
				$pdf->text(80,$pdf->gety()+13,'Asal');
				$pdf->text(140,$pdf->gety()+13,'Tujuan');
				$pdf->rect(15,$pdf->gety()+16,60,15,'D');
				$pdf->rect(75,$pdf->gety()+16,60,15,'D');
				$pdf->rect(135,$pdf->gety()+16,60,15,'D');
				$pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$pdf->text(20,$pdf->gety()+19,'Perusahaan');$pdf->text(80,$pdf->gety()+19,$row1['originname']);$pdf->text(140,$pdf->gety()+19,$row1['destname']);
					$pdf->text(20,$pdf->gety()+24,'Alamat ');$pdf->text(80,$pdf->gety()+24,$row1['originaddress']);$pdf->text(140,$pdf->gety()+24,$row1['destaddress']);
					$pdf->text(20,$pdf->gety()+29,'Kota ');$pdf->text(80,$pdf->gety()+29,$row1['origincityname']);$pdf->text(140,$pdf->gety()+29,$row1['destcityname']);
				}
				
				$sql1 = "select a.application,a.technology,a.upstream,a.downstream, b. accessmethodname, a.originipaddress, 
					  a.destipaddress,a.originnetmask,a.destnetmask
					  from projectnetwork a 
					  inner join accessmethod b on b.accessmethodid = a.accessmethodid
					  where a.projectid = ". $_GET['id'] . " limit 1 ";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				
				$pdf->setxy(15,$pdf->gety()+35);
				$pdf->setfillcolor(248,244,244);
				$pdf->setFont('Arial','B',8);
				$pdf->rect(15,$pdf->gety(),180,8,'DF');
				$pdf->text(20,$pdf->gety()+5,'Spesifikasi Jaringan');
				$pdf->setfillcolor(248,244,244);
				$pdf->rect(15,$pdf->gety()+8,180,50,'D');
				$pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$pdf->text(20,$pdf->gety()+13,'Aplikasi');$pdf->text(60,$pdf->gety()+13,' : '.$row1['application']);
					$pdf->text(20,$pdf->gety()+18,'Teknologi');$pdf->text(60,$pdf->gety()+18,' : '.$row1['technology']);
					$pdf->text(20,$pdf->gety()+23,'Kecepatan Upstream (Kbps)');$pdf->text(60,$pdf->gety()+23,' : '.$row1['upstream']);
					$pdf->text(20,$pdf->gety()+28,'Kecepatan Downstream (Kbps)');$pdf->text(60,$pdf->gety()+28,' : '.$row1['downstream']);
					$pdf->text(20,$pdf->gety()+33,'Access Method');$pdf->text(60,$pdf->gety()+33,' : '.$row1['accessmethodname']);
					$pdf->text(20,$pdf->gety()+38,'IP Address Asal');$pdf->text(60,$pdf->gety()+38,' : '.$row1['originipaddress']);
					$pdf->text(20,$pdf->gety()+43,'IP Address Tujuan');$pdf->text(60,$pdf->gety()+43,' : '.$row1['destipaddress']);
					$pdf->text(20,$pdf->gety()+48,'Netmask Asal');$pdf->text(60,$pdf->gety()+48,' : '.$row1['originnetmask']);
					$pdf->text(20,$pdf->gety()+53,'Netmask Tujuan');$pdf->text(60,$pdf->gety()+53,' : '.$row1['destnetmask']);
				}
				
				$pdf->AddPage('P');
				$pdf->text(20,$pdf->gety(),'Dengan ini kami menyatakan bahwa informasi yang kami berikan adalah benar adanya dan bisa dipertanggung jawabkan');
				$pdf->setFont('Arial','B',8);
				$pdf->text(50,$pdf->gety()+15,'PEMOHON');
				$pdf->text(150,$pdf->gety()+15,'PELAKSANA');
				$pdf->text(40,$pdf->gety()+35,'PDP');
				$pdf->text(80,$pdf->gety()+35,'PDS');
				$pdf->text(155,$pdf->gety()+35,'MJP');
				$pdf->line(30,$pdf->gety()+37,60,$pdf->gety()+37);
				$pdf->line(65,$pdf->gety()+37,100,$pdf->gety()+37);
				$pdf->line(135,$pdf->gety()+37,180,$pdf->gety()+37);			
				
			}
			// me-render ke browser
			$pdf->Output();
	  }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Project::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Projectservice::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelpic($id)
	{
		$model=Projectpic::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModellocation($id)
	{
		$model=Projectlocation::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModeldocument($id)
	{
		$model=Projectdocument::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelnetwork($id)
	{
		$model=Projectnetwork::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelemp($id)
	{
		$model=Projectemp::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='projectservice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

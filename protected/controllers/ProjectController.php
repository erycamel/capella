<?php

class ProjectController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'project';

	public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpservice'; break;
				case 4 : $this->txt = '_helpservicemodif'; break;
				case 5 : $this->txt = '_helppic'; break;
				case 6 : $this->txt = '_helppicmodif'; break;
				case 7 : $this->txt = '_helplocation'; break;
				case 8 : $this->txt = '_helplocationmodif'; break;
				case 9 : $this->txt = '_helpdocument'; break;
				case 10 : $this->txt = '_helpdocumentmodif'; break;
				case 11 : $this->txt = '_helpnetwork'; break;
				case 12 : $this->txt = '_helpnetworkmodif'; break;
			}
		}
		parent::actionHelp();
	}

	public $projectservice, $projectpic, $projectlocation, $projectdocument, $projectnetwork,$srftime,$projectemp;

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
		
		$this->srftime=new Srftime('search');
	  $this->srftime->unsetAttributes();  // clear any default values
	  if(isset($_GET['Srftime']))
		$this->srftime->attributes=$_GET['Srftime'];
		
		$this->projectemp=new Projectemp('search');
	  $this->projectemp->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectemp']))
		$this->projectemp->attributes=$_GET['Projectemp'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
		$model=new Project;
		$model->recordstatus=Wfgroup::model()->findstatusbyuser('insproject');
		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'projectid'=>$model->projectid,
				  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
					'projectservice'=>$this->projectservice,
					'projectpic'=>$this->projectpic,
					'projectdocument'=>$this->projectdocument,
					'projectnetwork'=>$this->projectnetwork,
					'projectlocation'=>$this->projectlocation), true)
				  ));
			  Yii::app()->end();
			}
        }
	}

	public function actionCreateservice()
	{
		parent::actionCreate();
		$projectservice=new Projectservice;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formservice',
				  array('model'=>$projectservice), true)
				));
            Yii::app()->end();
        }
	}
	
	public function actionCreatepic()
	{
		parent::actionCreate();
		$projectpic=new Projectpic;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formpic',
				  array('model'=>$projectpic), true)
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
	
	public function actionCreatedocument()
	{
		parent::actionCreate();
		$projectdocument=new Projectdocument;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formdocument',
				  array('model'=>$projectdocument), true)
				));
            Yii::app()->end();
        }
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
                'soheaderid'=>$model->soheaderid,
                'sono'=>($model->soheader!==null)?$model->soheader->sono:"",
                'projectnote'=>$model->projectnote,
                'priceotr'=>$model->priceotr,
                'priceotc'=>$model->priceotc,
				'projectdate'=>date(Yii::app()->params['datetimeviewfromdb'], strtotime($model->projectdate)),
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
					'projectservice'=>$this->projectservice,
					'projectpic'=>$this->projectpic,
					'projectdocument'=>$this->projectdocument,
					'projectnetwork'=>$this->projectnetwork,
					'projectlocation'=>$this->projectlocation), true)
				));
            Yii::app()->end();
        }
	}

	public function actionUpdateservice()
	{
		$id=$_POST['id'];
	  $projectservice=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'projectserviceid'=>$projectservice->projectserviceid,
                'contracttermid'=>$projectservice->contracttermid,
                'contracttermname'=>($projectservice->contractterm!==null)?$projectservice->contractterm->contracttermname:"",
                'requestforid'=>$projectservice->requestforid,
                'requestforname'=>($projectservice->requestfor!==null)?$projectservice->requestfor->requestforname:"",
                'dateofdelivery'=>date(Yii::app()->params['dateviewfromdb'], strtotime($projectservice->dateofdelivery)),
                'dateofdeliverydevice'=>date(Yii::app()->params['dateviewfromdb'], strtotime($projectservice->dateofdeliverydevice)),
                'estimatedelivery'=>date(Yii::app()->params['dateviewfromdb'], strtotime($projectservice->estimatedelivery)),
                'installdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($projectservice->installdate)),
                'onlinedate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($projectservice->onlinedate)),
                'div'=>$this->renderPartial('_formservice',
				  array('model'=>$projectservice), true)
				));
            Yii::app()->end();
        }
	}
	
	public function actionUpdatepic()
	{
		$id=$_POST['id'];
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
	
	public function actionUpdatedocument()
	{
		$id=$_POST['id'];
	  $projectdocument=$this->loadModeldocument($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'projectdocumentid'=>$projectdocument->projectdocumentid,
                'documentname'=>$projectdocument->documentname,
                'filename'=>$projectdocument->filename,
                'div'=>$this->renderPartial('_formdocument',
				  array('model'=>$projectdocument), true)
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
	
		    public function actionCancelWrite()
    {
      $model = Project::model()->findbypk($_POST['Project']['projectid']);
      if ($model != null)
      {
        $model->Delete();
      }
      $this->DeleteLockCloseForm($this->menuname, $_POST['Project'], $_POST['Project']['projectid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Project']))
	  {
         $messages = $this->ValidateData(
                array(array($_POST['Project']['soheaderid'],'ppemptysoheaderid','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Project']['projectid'] > 0)
		{
		  $model=$this->loadModel($_POST['Project']['projectid']);
		  $model->soheaderid = $_POST['Project']['soheaderid'];
		  $model->projectnote = $_POST['Project']['projectnote'];
		  $model->serviceno = $_POST['Project']['serviceno'];
		  $model->priceotr = $_POST['Project']['priceotr'];
		  $model->priceotc = $_POST['Project']['priceotc'];
		  $model->projectdate = $_POST['Project']['projectdate'];
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
	
	public function actionWriteservice()
	{
	  if(isset($_POST['Projectservice']))
	  {
	  $messages = $this->ValidateData(
                array(
				array($_POST['Projectservice']['projectid'],'ppemptyprojectid','emptystring'),
				array($_POST['Projectservice']['contracttermid'],'ppemptycontracttermid','emptystring'),
				array($_POST['Projectservice']['requestforid'],'ppemptyrequestforid','emptystring'),
				array($_POST['Projectservice']['installdate'],'ppemptyinstalldate','emptystring'),
				array($_POST['Projectservice']['onlinedate'],'ppemptyonlinedate','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Projectservice']['projectserviceid'] > 0)
		{
		  $model=Projectservice::model()->findbyPK($_POST['Projectservice']['projectserviceid']);
		  $model->projectid = $_POST['Projectservice']['projectid'];
		  $model->contracttermid = $_POST['Projectservice']['contracttermid'];
		  $model->requestforid = $_POST['Projectservice']['requestforid'];
		  $model->dateofdelivery = $_POST['Projectservice']['dateofdelivery'];
		  $model->dateofdeliverydevice = $_POST['Projectservice']['dateofdeliverydevice'];
		  $model->estimatedelivery = $_POST['Projectservice']['estimatedelivery'];
		  $model->installdate = $_POST['Projectservice']['installdate'];
		  $model->onlinedate = $_POST['Projectservice']['onlinedate'];
		}
		else
		{
		  $model = new Projectservice();
		  $model->attributes=$_POST['Projectservice'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Projectservice']['projectserviceid']);
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
	
	public function actionWritedocument()
	{
	  if(isset($_POST['Projectdocument']))
	  {
	  $messages = $this->ValidateData(
                array(
				array($_POST['Projectdocument']['projectid'],'ppemptyprojectid','emptystring'),
				array($_POST['Projectdocument']['documentname'],'ppemptydocumentname','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Projectdocument']['projectdocumentid'] > 0)
		{
		  $model=Projectdocument::model()->findbyPK($_POST['Projectdocument']['projectdocumentid']);
		  $model->projectid = $_POST['Projectdocument']['projectid'];
		  $model->documentname = $_POST['Projectdocument']['documentname'];
						}
		else
		{
		  $model = new Projectdocument();
		  $model->attributes=$_POST['Projectdocument'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Projectdocument']['projectdocumentid']);
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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteservice()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Projectservice::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	public function actionDeletepic()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Projectpic::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
	
	public function actionDeletedocument()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Projectdocument::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}
    

    public function actionGenerate()
        {
          if(isset($_POST['id']))
	  {
              $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call GeneratePRSO(:vid, :vhid)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
				$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
                $soheader = Soheader::model()->findbypk($_POST['id']);
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
                        'addressbookid'=>$soheader->addressbookid,
                      'fullname'=>$soheader->customer->fullname,
                        'piccust'=>$soheader->pocheader->piccust,
                        'startdate'=>$soheader->pocheader->pocdate,
                        'enddate'=>$soheader->pocheader->deliverydate,
                        'projecttypeid'=>$soheader->pocheader->projecttypeid,
                        'protypedescription'=>$soheader->pocheader->projecttype->description,
					  'div'=>"Data generated"
					));
				}
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				  $transaction->rollBack();
				  if (Yii::app()->request->isAjaxRequest)
				  {
					  echo CJSON::encode(array(
						'status'=>'failure',
						'div'=>$e->getMessage()
					  ));
				  }
			  }
          }
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
					'srftime'=>$this->srftime,
					'projectemp'=>$this->projectemp
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
						$old = '';
						$model = Project::model()->findByattributes(array('projectno'=>$data[0]));
						if ($model == null) 
						{
							$old = $data[0];
							$model = new Project();
							$model->projectno = $data[0];
						}
						$sales = Soheader::model()->findbyattributes(array('contractno'=>$data[1]));
						if ($sales !== null)
						{
							$model->soheaderid = $sales->soheaderid;
						}
						$model->projectnote = $data[2];
						$model->projectdate = $data[3];
						$model->serviceno = $data[4];
						$model->priceotr = $data[5];
						$model->priceotc = $data[6];
						$model->onlinedate = $data[7];
						$model->recordstatus = Wfgroup::model()->findstatusbyuser('insproject');
						try
						  {
							if(!$model->save())
							{
								echo $model->getErrors();
							}
							else
							{
								if ($data[8] !== '')
								{
									$prodoc = new Projectdocument();
									
									$prodoc->projectid=$model->projectid;
									$prodoc->documentname=$data[8];
									if(!$prodoc->save())
									{
										echo $prodoc->getErrors();
									}
								}
								if ($data[9] !== '')
								{
									$pronetwork = new Projectnetwork();
									$pronetwork->projectid=$model->projectid;
									$pronetwork->application=$data[9];
									$pronetwork->technology=$data[10];
									$pronetwork->upstream=$data[11];
									$pronetwork->downstream=$data[12];
									$accessmethod = Accessmethod::model()->findbyattributes(array('accessmethodname'=>$data[13]));
									if ($accessmethod !== null)
									{
										$pronetwork->accessmethodid = $accessmethod->accessmethodid;
									}
									$pronetwork->originipaddress=$data[14];
									$pronetwork->destipaddress=$data[15];
									$pronetwork->originnetmask=$data[16];
									$pronetwork->destnetmask=$data[17];
									if(!$pronetwork->save())
									{
										echo $pronetwork->getErrors();
									}
								}
								if ($data[18] !== '')
								{
									$proservice = new Projectservice();
									$proservice->projectid=$model->projectid;
									$requestfor = Requestfor::model()->findbyattributes(array('requestforname'=>$data[18]));
									if ($requestfor !== null)
									{
										$proservice->requestforid = $requestfor->requestforid;
									}
									$proservice->dateofdelivery=$data[19];
									$proservice->dateofdeliverydevice=$data[20];
									$proservice->estimatedelivery=$data[21];
									$proservice->installdate=$data[22];
									$proservice->onlinedate=$data[23];
									$contract = Contractterm::model()->findbyattributes(array('contracttermname'=>$data[24]));
									if ($contract !== null)
									{
										$proservice->contracttermid = $contract->contracttermid;
									}
									if(!$proservice->save())
									{
										echo $proservice->getErrors();
									}
								}
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
			$sql = "select a.projectid,a.projectno,a.projectdate,c.description,b.projectname,b.contractno,b.addressbookid,a.serviceno
			  from project a 
			  inner join soheader b on b.soheaderid = a.soheaderid
			  inner join projecttype c on c.projecttypeid = b.projecttypeid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.projectid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
			$this->pdf->title='Service Request Form';
			$this->pdf->AddPage('P');
			$this->pdf->setFont('Arial','B',12);

			foreach($dataReader as $row)
			{
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,30,180,8,'DF');
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->text(20,35,'Data Utama');
				$this->pdf->setfillcolor(255,255,255);
				$this->pdf->rect(15,38,180,30,'D');
				$this->pdf->text(20,43,'Tgl SRF');$this->pdf->text(40,43,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['projectdate'])));
				$this->pdf->text(20,50,'No SRF');$this->pdf->text(40,50,': '.$row['projectno']);
				$this->pdf->text(20,55,'Nama Proyek');$this->pdf->text(40,55,': '.$row['projectname']);
				$this->pdf->text(20,60,'Jenis Proyek');$this->pdf->text(40,60,': '.$row['description']);
				$this->pdf->text(20,65,'No SPK / LOI');$this->pdf->text(40,65,': '.$row['contractno']);
				$this->pdf->text(80,65,'No Service');$this->pdf->text(120,65,': '.$row['serviceno']);


				$sql1 = "select b.requestforname,a.dateofdelivery,a.dateofdeliverydevice,a.estimatedelivery,a.installdate,a.onlinedate,c.contracttermname
					  from projectservice a 
					  inner join requestfor b on b.requestforid = a.requestforid
					  inner join contractterm c on c.contracttermid = a.contracttermid
					  where projectid = ". $row['projectid'];
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();

				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,70,180,8,'DF');
				$this->pdf->text(20,75,'Data Permintaan');
				$this->pdf->setFont('Arial','B',6);
				$this->pdf->setaligns(array('C','C','C','C','C','C','C'));
				$this->pdf->setwidths(array(40,20,30,20,20,20,30));
				$this->pdf->setFont('Arial','',6);
				$this->pdf->setxy(15,78);
				$this->pdf->Row(array('Request For','Date of Delivery','Date of Delivery Device','Estimate Delivery','Install Date','Online Date','Contract Term'));
				$this->pdf->setaligns(array('L','L','L','L','L','L','L'));
				$this->pdf->setx(15);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->setx(15);
					$this->pdf->row(array($row1['requestforname'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['dateofdelivery'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['dateofdeliverydevice'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['estimatedelivery'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['installdate'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['onlinedate'])),			
						$row1['contracttermname']));
				}
				
				$sql1 = "select fullname,b.addressname, c.cityname, d.provincename, b.phoneno
					  from addressbook a 
					  left join address b on b.addressbookid = a.addressbookid
					  left join city c on c.cityid = b.cityid
					  left join province d on d.provinceid = c.provinceid
					  where a.addressbookid = ". $row['addressbookid'] . " limit 1 ";
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->rect(15,$this->pdf->gety(),180,8,'DF');
				$this->pdf->text(20,$this->pdf->gety()+5,'Informasi Perusahaan');
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,$this->pdf->gety()+8,180,30,'D');
				$this->pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->text(20,$this->pdf->gety()+15,'Nama Perusahaan');$this->pdf->text(40,$this->pdf->gety()+15,': '.$row1['fullname']);
					$this->pdf->text(20,$this->pdf->gety()+20,'Alamat ');$this->pdf->text(40,$this->pdf->gety()+20,': '.$row1['addressname']);
					$this->pdf->text(20,$this->pdf->gety()+25,'Kota Perusahaan');$this->pdf->text(40,$this->pdf->gety()+25,': '.$row1['cityname']);
					$this->pdf->text(20,$this->pdf->gety()+30,'Propinsi / Negara');$this->pdf->text(40,$this->pdf->gety()+30,': '.$row1['provincename']);
					$this->pdf->text(20,$this->pdf->gety()+35,'Nomor Telepon');$this->pdf->text(40,$this->pdf->gety()+30,': '.$row1['phoneno']);
				}
				
				$sql1 = "select picname,picfunction,picemail,picdept,pictelp
					  from projectpic a 
					  where projectid = ". $row['projectid'];
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();

				$this->pdf->setxy(15,$this->pdf->gety()+40);
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,$this->pdf->gety(),180,8,'DF');
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->text(20,$this->pdf->gety()+5,'Data Penanggung Jawab');
				$this->pdf->setxy(15,$this->pdf->gety()+8);
				$this->pdf->setaligns(array('C','C','C','C','C','C','C'));
				$this->pdf->setwidths(array(40,40,30,40,30,60,40));
				$this->pdf->Row(array('Nama','Bagian','No Telp','Email','Fungsi'));
				$this->pdf->setaligns(array('L','L','L','L','L','L','L'));
				$this->pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->setx(15);
					$this->pdf->row(array($row1['picname'],$row1['picdept'],$row1['pictelp'],$row1['picemail'],$row1['picfunction']));
				}
				
				$sql1 = "select b.fullname as originname, c.fullname as destname, a.originaddress,a.destaddress, d.cityname as origincityname,
					  e.cityname as destcityname
					  from projectlocation a 
					  left join addressbook b on b.addressbookid = a.originid
					  left join addressbook c on c.addressbookid = a.destid
					  left join city d on d.cityid = a.origincityid
					  left join city e on e.cityid = a.destcityid
					  where a.projectid = ". $row['projectid'] . " limit 1 ";
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				
				$this->pdf->setxy(15,$this->pdf->gety()+3);
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->rect(15,$this->pdf->gety(),180,8,'DF');
				$this->pdf->text(20,$this->pdf->gety()+5,'Data Lokasi');
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,$this->pdf->gety()+8,60,8,'DF');
				$this->pdf->rect(75,$this->pdf->gety()+8,60,8,'DF');
				$this->pdf->rect(135,$this->pdf->gety()+8,60,8,'DF');
				$this->pdf->text(20,$this->pdf->gety()+13,'Keterangan');
				$this->pdf->text(80,$this->pdf->gety()+13,'Asal');
				$this->pdf->text(140,$this->pdf->gety()+13,'Tujuan');
				$this->pdf->rect(15,$this->pdf->gety()+16,60,15,'D');
				$this->pdf->rect(75,$this->pdf->gety()+16,60,15,'D');
				$this->pdf->rect(135,$this->pdf->gety()+16,60,15,'D');
				$this->pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->text(20,$this->pdf->gety()+19,'Perusahaan');$this->pdf->text(80,$this->pdf->gety()+19,$row1['originname']);$this->pdf->text(140,$this->pdf->gety()+19,$row1['destname']);
					$this->pdf->text(20,$this->pdf->gety()+24,'Alamat ');$this->pdf->text(80,$this->pdf->gety()+24,$row1['originaddress']);$this->pdf->text(140,$this->pdf->gety()+24,$row1['destaddress']);
					$this->pdf->text(20,$this->pdf->gety()+29,'Kota ');$this->pdf->text(80,$this->pdf->gety()+29,$row1['origincityname']);$this->pdf->text(140,$this->pdf->gety()+29,$row1['destcityname']);
				}
				
				$sql1 = "select a.application,a.technology,a.upstream,a.downstream, b. accessmethodname, a.originipaddress, 
					  a.destipaddress,a.originnetmask,a.destnetmask
					  from projectnetwork a 
					  inner join accessmethod b on b.accessmethodid = a.accessmethodid
					  where a.projectid = ". $row['projectid'] . " limit 1 ";
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				
				$this->pdf->setxy(15,$this->pdf->gety()+35);
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->rect(15,$this->pdf->gety(),180,8,'DF');
				$this->pdf->text(20,$this->pdf->gety()+5,'Spesifikasi Jaringan');
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,$this->pdf->gety()+8,180,50,'D');
				$this->pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->text(20,$this->pdf->gety()+13,'Aplikasi');$this->pdf->text(60,$this->pdf->gety()+13,' : '.$row1['application']);
					$this->pdf->text(20,$this->pdf->gety()+18,'Teknologi');$this->pdf->text(60,$this->pdf->gety()+18,' : '.$row1['technology']);
					$this->pdf->text(20,$this->pdf->gety()+23,'Kecepatan Upstream (Kbps)');$this->pdf->text(60,$this->pdf->gety()+23,' : '.$row1['upstream']);
					$this->pdf->text(20,$this->pdf->gety()+28,'Kecepatan Downstream (Kbps)');$this->pdf->text(60,$this->pdf->gety()+28,' : '.$row1['downstream']);
					$this->pdf->text(20,$this->pdf->gety()+33,'Access Method');$this->pdf->text(60,$this->pdf->gety()+33,' : '.$row1['accessmethodname']);
					$this->pdf->text(20,$this->pdf->gety()+38,'IP Address Asal');$this->pdf->text(60,$this->pdf->gety()+38,' : '.$row1['originipaddress']);
					$this->pdf->text(20,$this->pdf->gety()+43,'IP Address Tujuan');$this->pdf->text(60,$this->pdf->gety()+43,' : '.$row1['destipaddress']);
					$this->pdf->text(20,$this->pdf->gety()+48,'Netmask Asal');$this->pdf->text(60,$this->pdf->gety()+48,' : '.$row1['originnetmask']);
					$this->pdf->text(20,$this->pdf->gety()+53,'Netmask Tujuan');$this->pdf->text(60,$this->pdf->gety()+53,' : '.$row1['destnetmask']);
				}
				
				$this->pdf->AddPage('P');
				$this->pdf->text(20,$this->pdf->gety(),'Dengan ini kami menyatakan bahwa informasi yang kami berikan adalah benar adanya dan bisa dipertanggung jawabkan');
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->text(50,$this->pdf->gety()+15,'PEMOHON');
				$this->pdf->text(150,$this->pdf->gety()+15,'PELAKSANA');
				$this->pdf->text(40,$this->pdf->gety()+35,'PDP');
				$this->pdf->text(80,$this->pdf->gety()+35,'PDS');
				$this->pdf->text(155,$this->pdf->gety()+35,'MJP');
				$this->pdf->line(30,$this->pdf->gety()+37,60,$this->pdf->gety()+37);
				$this->pdf->line(65,$this->pdf->gety()+37,100,$this->pdf->gety()+37);
				$this->pdf->line(135,$this->pdf->gety()+37,180,$this->pdf->gety()+37);			
				
				$this->pdf->AddPage('P');
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

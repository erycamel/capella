<?php

class WorkorderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname='workorder';
	protected $myworkorder='myworkorder';
	public $workorderstaff,$eventrequest,$product;

	public function lookupdata()
	{
	  $this->workorderstaff=new Workorderstaff('searchwstatus');
	  $this->workorderstaff->unsetAttributes();  // clear any default values
	  if(isset($_GET['Workorderstaff']))
		$this->workorderstaff->attributes=$_GET['Workorderstaff'];

	  $this->eventrequest=new Eventrequest('searchwstatus');
	  $this->eventrequest->unsetAttributes();  // clear any default values
	  if(isset($_GET['Eventrequest']))
		$this->eventrequest->attributes=$_GET['Eventrequest'];

	  $this->product=new Product('searchwstatus');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
		$model=new Workorder;
		$this->lookupdata();
		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'div'=>$this->renderPartial('_form', array('model'=>$model,
		'workorderstaff'=>$this->workorderstaff,
		'eventrequest'=>$this->eventrequest,
		'product'=>$this->product), true)
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
			  'workorderid'=>$model->workorderid,
			  'productid'=>$model->productid,
			  'productname'=>$model->product->productname,
			  'workstartdate'=>$model->workstartdate,
			  'worktargetdate'=>$model->worktargetdate,
			  'workorderstaffid'=>$model->workorderstaffid,
			  'username'=>$model->workorderstaff->useraccessid,
			  'description'=>$model->description,
			  'workorderstatus'=>$model->workorderstatus,
			  'eventrequestid'=>$model->eventrequestid,
			  'eventtitle'=>$model->eventrequest->eventtitle,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
		'workorderstaff'=>$this->workorderstaff,
		'eventrequest'=>$this->eventrequest,
		'product'=>$this->product), true)
			  ));
		  Yii::app()->end();
	  }
	}

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Workorder']))
	  {
		$dataku->attributes=$_POST['Workorder'];
		if ((int)$dataku->attributes['workorderid'] > 0)
		{
		  $model=$this->loadModel($dataku->attributes['workorderid']);
		  $model->productid = $dataku->attributes['productid'];
		  $model->workstartdate = $dataku->attributes['workstartdate'];
		  $model->worktargetdate = $dataku->attributes['worktargetdate'];
		  $model->workorderstaffid = $dataku->attributes['workorderstaffid'];
		  $model->description = $dataku->attributes['description'];
		  $model->workorderstatus = $dataku->attributes['workorderstatus'];
		  $model->eventrequestid = $dataku->attributes['eventrequestid'];
		  $model->recordstatus = $dataku->attributes['recordstatus'];
		}
		else
		{
		  $model = new Workorder();
		  $model->attributes=$_POST['Workorder'];
		}
	  }
		try
		{
		  if($model->save())
		  {
			if ($model->workorderstaffid != null)  {
			  $workorderstaff = Workorderstaff::model()->findbyPk($model->workorderstaffid);		  
			  if ($workorderstaff != null) {
				$usertodo = new Usertodo();
				$usertodo->useraccessid = $workorderstaff->useraccessid;
				$usertodo->tododate = $model->workstartdate;
				$menuaccess = Menuaccess::model()->findbyAttributes(array('menuname'=>$this->myworkorder));
				$usertodo->menuaccessid = $menuaccess->menuaccessid;
				$usertodo->description = $model->description;
				$usertodo->recordstatus = 1;
				$usertodo->save();
			  }
			}
			if (Yii::app()->request->isAjaxRequest)
			  {
				echo CJSON::encode(array(
				  'status'=>'success',
				  'div'=>"Data saved"
				));
			  }
		  }
		  else
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
		$this->lookupdata();
	  
		$model=new Workorder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Workorder']))
			$model->attributes=$_GET['Workorder'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		'workorderstaff'=>$this->workorderstaff,
		'eventrequest'=>$this->eventrequest,
		'product'=>$this->product
		));
	}

public function actionUpload()
  {
     parent::actionUpload();
  }

  public function actionDownload()
  {
	parent::actionDownload();
  }

  public function actionAssign()
  {
	parent::actionWrite();
	$id=$_POST['id'];
	foreach($id as $ids)
	{
	  $model=$this->loadModel($ids);
	  if(isset($_POST['Workorder']))
		$model->attributes=$_POST['Workorder'];
		$model->workorderstaffid = $_POST['workorderstaffid'];
	  try
	  {
		if($model->save())
		{
		  if ($model->workorderstaffid != null)  {
			$workorderstaff = Workorderstaff::model()->findbyPk($model->workorderstaffid);
			if ($workorderstaff != null) {
			  $usertodo = new Usertodo();
			  $usertodo->useraccessid = $workorderstaff->useraccessid;
			  $usertodo->tododate = $model->workstartdate;
			  $menuaccess = Menuaccess::model()->findbyAttributes(array('menuname'=>$this->myworkorder));
			  $usertodo->menuaccessid = $menuaccess->menuaccessid;
			  $usertodo->description = $model->description;
			  $usertodo->recordstatus = 1;
			  $usertodo->save();
			}
		  }
		  if (Yii::app()->request->isAjaxRequest)
			{
			  echo CJSON::encode(array(
				'status'=>'success',
				'div'=>"Data saved"
			  ));
			}
		}
		else
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
  }

  	public function actionView()
	{
	  $id=$_POST['id'];
	  $workorderhist=Workorderhist::model();
	  $workorderhist->workorderid = $id[0];
	  $workorderhist->search();

	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>$this->renderPartial('_formhist', array('workorderhist'=>$workorderhist), true)));
		Yii::app()->end();
	  }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Workorder::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='workorder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

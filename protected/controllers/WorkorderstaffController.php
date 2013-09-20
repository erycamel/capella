<?php

class WorkorderstaffController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
  protected $menuname='workorderstaff';

  public $useraccess;

	public function lookupdata()
	{
	  $this->useraccess=new Useraccess('searchwstatus');
	  $this->useraccess->unsetAttributes();  // clear any default values
	  if(isset($_GET['Useraccess']))
		$this->useraccess->attributes=$_GET['Useraccess'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Workorderstaff;
    $this->lookupdata();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest)
    {
		  if ($this->CheckAccess($this->menuname, $this->iswrite)) {
            echo CJSON::encode(array(
                'status'=>'success',
                'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'useraccess'=>$this->useraccess), true)
				));
            Yii::app()->end();
		  }
    }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$this->lookupdata();

	  $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

	  if (Yii::app()->request->isAjaxRequest)
	  {
      if ($this->CheckAccess($this->menuname, $this->iswrite)) {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'workorderstaffid'=>$model->workorderstaffid,
			  'useraccessid'=>$model->useraccessid,
			  'username'=>$model->useraccess->realname,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'useraccess'=>$this->useraccess), true)
			  ));
		  Yii::app()->end();
      }
	  }
	}

  public function actionWrite()
	{
	  if(isset($_POST['Workorderstaff']))
	  {
		$dataku->attributes=$_POST['Workorderstaff'];
		if ((int)$dataku->attributes['workorderstaffid'] > 0)
		{
		  $model=$this->loadModel($dataku->attributes['workorderstaffid']);
		  $model->useraccessid = $dataku->attributes['useraccessid'];
		  $model->recordstatus = $dataku->attributes['recordstatus'];
		}
		else
		{
		  $model = new Workorderstaff();
		  $model->attributes=$_POST['Workorderstaff'];
		}
		try
		{
		  if($model->save())
		  {
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
    if ($this->CheckAccess($this->menuname, $this->isreject)) {
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
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
    if ($this->CheckAccess($this->menuname, $this->isread)) {
    $this->lookupdata();
		$model=new Workorderstaff('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Workorderstaff']))
			$model->attributes=$_GET['Workorderstaff'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
      'useraccess'=>$this->useraccess
		));
    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Workorderstaff::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='workorderstaff-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

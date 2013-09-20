<?php

class ReportpermitintransController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'reportpermitintrans';

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
	   $permitin=new Permitin('searchwstatus');
	  $permitin->unsetAttributes();  // clear any default values
	  if(isset($_GET['Permitin']))
		$permitin->attributes=$_GET['Permitin'];

	   $employee=new Employee('searchwstatus');
	  $employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$employee->attributes=$_GET['Employee'];

		$model=new Permitintrans;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'permitin'=>$permitin,
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
	  $permitin=new Permitin('searchwstatus');
	  $permitin->unsetAttributes();  // clear any default values
	  if(isset($_GET['Permitin']))
		$permitin->attributes=$_GET['Permitin'];

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
				'permitintransid'=>$model->permitintransid,
				'permitinid'=>$model->permitinid,
				'permitinname'=>($model->permitin!==null)?$model->permitin->permitinname:"",
				'employeeid'=>$model->employeeid,
				'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
				'permitindate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->permitindate)),
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'permitin'=>$permitin,
			'employee'=>$employee), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Permitintrans'], $_POST['Permitintrans']['permitintransid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Permitintrans']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Permitintrans']['employeeid'],'heejemptyemployeeid','emptystring'),
                array($_POST['Permitintrans']['permitindate'],'heejemptypermitindate','emptystring'),
                array($_POST['Permitintrans']['permitinid'],'heejemptypermitinid','emptystring'),
            )
        );
        if ($messages == '') {
        $onleavedate = date(Yii::app()->params['datetodb'], strtotime($_POST['Permitintrans']['permitindate']));
        if ((int)$_POST['Permitintrans']['permitintransid'] > 0)
		{
              $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call UpdatePermitInTrans(:vpermitintransid,:vpermitindate,
				  :vemployeeid,:vpermitinid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindParam(':vpermitintransid',$_POST['Permitintrans']['permitintransid'],PDO::PARAM_INT);
				$command->bindParam(':vpermitindate',$onleavedate,PDO::PARAM_STR);
				$command->bindParam(':vemployeeid',$_POST['Permitintrans']['employeeid'],PDO::PARAM_INT);
				$command->bindParam(':vpermitinid',$_POST['Permitintrans']['permitinid'],PDO::PARAM_INT);
				$post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
				$command->bindParam(':vlastupdateby', $post,PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Permitintrans']['permitintransid']);
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
				$sql = 'call InsertPermitInTrans(:vpermitindate,
				  :vemployeeid,:vpermitinid, :vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindParam(':vpermitindate',$onleavedate,PDO::PARAM_STR);
				$command->bindParam(':vemployeeid',$_POST['Permitintrans']['employeeid'],PDO::PARAM_INT);
				$command->bindParam(':vpermitinid',$_POST['Permitintrans']['permitinid'],PDO::PARAM_INT);
				$post=Useraccess::model()->find("username=':postID'", array(':postID'=>Yii::app()->user->name));
				$command->bindParam(':vcreatedby', $post,PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Permitintrans']['permitintransid']);
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
				$sql = 'call ApprovePermitInTrans(:vid, :vlastupdateby)';
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
	  $permitin=new Permitin('searchwstatus');
	  $permitin->unsetAttributes();  // clear any default values
	  if(isset($_GET['Permitin']))
		$permitin->attributes=$_GET['Permitin'];

	   $employee=new Employee('searchwstatus');
	  $employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$employee->attributes=$_GET['Employee'];
		$model=new Permitintrans('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Permitintrans']))
			$model->attributes=$_GET['Permitintrans'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
			'permitin'=>$permitin,
			'employee'=>$employee
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Permitintrans::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='permitintrans-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class EmployeestatusController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeestatus';

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
		$model=new Employeestatus;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model), true)
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
		 $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'employeestatusid'=>$model->employeestatusid,
				'employeestatusname'=>$model->employeestatusname,
                'taxvalue'=>$model->taxvalue,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeestatus'], $_POST['Employeestatus']['employeestatusid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeestatus']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeestatus']['employeestatusname'],'hrmesemptyemployeestatusname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Employeestatus'];
		if ((int)$_POST['Employeestatus']['employeestatusid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeestatus']['employeestatusid']);
		  $model->employeestatusname = $_POST['Employeestatus']['employeestatusname'];
		  $model->taxvalue = $_POST['Employeestatus']['taxvalue'];
		  $model->recordstatus = $_POST['Employeestatus']['recordstatus'];
		}
		else
		{
		  $model = new Employeestatus();
		  $model->attributes=$_POST['Employeestatus'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeestatus']['employeestatusid']);
              $this->GetSMessage('hrmesinsertsuccess');
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
    $model=new Employeestatus('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employeestatus']))
			$model->attributes=$_GET['Employeestatus'];
 if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionDownload()
  {
      parent::actionDownload();
	$pdf = new PDF();
	  $pdf->title='Employee Status List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select employeestatusname, taxvalue
      from employeestatus  ";
	   if ($_GET['id'] !== '') {
				$sql = $sql . "where employeestatusid = ".$_GET['id'];
		}
    $command=$connection->createCommand($sql);
    $dataReader=$command->queryAll();

    $pdf->setaligns(array('C','C','C','C'));
    $pdf->setwidths(array(50,30,30,30));
    $pdf->Row(array('Employee Status','Tax Value'));
    $pdf->setaligns(array('L','R','C','C'));
    foreach($dataReader as $row1)
    {
      $pdf->row(array($row1['employeestatusname'],$row1['taxvalue']));
    }
    // me-render ke browser
    $pdf->Output('employeestatus.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Employeestatus::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeestatus-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

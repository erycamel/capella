<?php

class EmployeeoverController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeeover';

	public function actionHelp()
	{
		$txt = '';
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $txt = '_help'; break;
				case 2 : $txt = '_helpmodif'; break;
				case 3 : $txt = '_helpdetail'; break;
				case 4 : $txt = '_helpdetailmodif'; break;
			}
		}
		parent::actionHelp($txt);
	}
	
	public $employeeoverdet;
	

	public function lookupdata()
	{
	  $this->employeeoverdet=new Employeeoverdet('search');
	  $this->employeeoverdet->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeeoverdet']))
		$this->employeeoverdet->attributes=$_GET['Employeeoverdet'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Employeeover;
	  $model->recordstatus=0;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  if ($model->save()) {
			echo CJSON::encode(array(
				'status'=>'success',
				'employeeoverid'=>$model->employeeoverid,
				'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'employeeoverdet'=>$this->employeeoverdet), true)
				));
			Yii::app()->end();
		  }
	  }
	}

	public function actionCreatedetail()
	{
	  $employeeoverdet=new Employeeoverdet;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_formdetail',
				array('model'=>$employeeoverdet), true)
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
				'employeeoverid'=>$model->employeeoverid,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'employeeoverdet'=>$this->employeeoverdet), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
		$id=$_POST['id'];
	  $employeeoverdet=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'employeeoverdetid'=>$employeeoverdet->employeeoverdetid,
				'employeeid'=>$employeeoverdet->employeeid,
				'fullname'=>($employeeoverdet->employee!==null)?$employeeoverdet->employee->fullname:"",
				'overtime'=>$employeeoverdet->overtime,
                'overtimeend'=>$employeeoverdet->overtimeend,
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$employeeoverdet), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeeover'], $_POST['Employeeover']['employeeoverid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeeover']))
	  {
        $messages = $this->ValidateData(
                array(
                    array($_POST['Employeeover']['overtimedate'],'htesemptyovertimedate','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Employeeover'];
		if ((int)$_POST['Employeeover']['employeeoverid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeeover']['employeeoverid']);
		  $model->overtimedate = $_POST['Employeeover']['overtimedate'];
		  $model->recordstatus = $_POST['Employeeover']['recordstatus'];
		}
		else
		{
		  $model = new Employeeover();
		  $model->attributes=$_POST['Employeeover'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeeover']['employeeoverid']);
              $this->GetSMessage('agjinsertsuccess');
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

	public function actionWritedetail()
	{
	  if(isset($_POST['Employeeoverdet']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeeoverdet']['employeeid'],'hteoemptyemployee','emptystring'),
                array($_POST['Employeeoverdet']['overtime'],'hteoemptyovertime','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Employeeoverdet'];
          if ((int)$_POST['Employeeoverdet']['employeeoverdetid'] > 0)
          {
            $model=Employeeoverdet::model()->findbyPK($_POST['Employeeoverdet']['employeeoverdetid']);
            $model->employeeoverid = $_POST['Employeeoverdet']['employeeoverid'];
            $model->employeeid = $_POST['Employeeoverdet']['employeeid'];
            $model->overtime = $_POST['Employeeoverdet']['overtime'];
            $model->overtimeend = $_POST['Employeeoverdet']['overtimeend'];
          }
          else
          {
            $model = new Employeeoverdet();
            $model->attributes=$_POST['Employeeoverdet'];
          }
          try
          {
            if($model->save())
            {
              $this->GetSMessage('hteoinsertsuccess');
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
	public function actionDeletedetail()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Employeeoverdet::model()->findbyPK($ids);
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
          $sql = 'call ApproveEmployeeOvertime(:vid, :vlastupdateby)';
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();
		$model=new Employeeover('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employeeover']))
			$model->attributes=$_GET['Employeeover'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'employeeoverdet'=>$this->employeeoverdet
		));
	}

	public function actionIndexdetail()
	{
	  $this->lookupdata();
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->renderPartial('indexdetail',
		array('employeeoverdet'=>$this->employeeoverdet));
	  Yii::app()->end();
	}

	public function actionDownload()
  {
	parent::actionDownload();
    $pdf = new PDF();
    $pdf->title='Absence Schedule List';
    $pdf->AddPage('L');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Schedule Name','Absence In','Absence Out', 'Status', 'Wage Name', 'Currency', 'Insentif');
    $model=new Absschedule('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($dataku);
    $w= array(20,25,30,30,30,30,30,30,30);
    $pdf->SetTableHeader();
    //Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $pdf->Ln();
    $pdf->SetTableData();
    //Data
    $fill=false;
    foreach($data as $n=>$datas)
    {
        $pdf->Cell($w[0],6,$n,'LR',0,'C',$fill);
        $pdf->Cell($w[1],6,$datas['absscheduleid'],'LR',0,'C',$fill);
        $pdf->Cell($w[2],6,$datas['absschedulename'],'LR',0,'C',$fill);
        $pdf->Cell($w[3],6,$datas['absin'],'LR',0,'C',$fill);
        $pdf->Cell($w[4],6,$datas['absout'],'LR',0,'C',$fill);
        $pdf->Cell($w[5],6,Absstatus::model()->findByPk($datas['absstatusid'])->shortstat,'LR',0,'C',$fill);
        $pdf->Cell($w[6],6,Wagetype::model()->findByPk($datas['wagetypeid'])->wagename,'LR',0,'C',$fill);
        $pdf->Cell($w[7],6,Currency::model()->findByPk($datas['currencyid'])->currencyname,'LR',0,'C',$fill);
        $pdf->Cell($w[8],6,number_format($datas['insentif']),'LR',0,'C',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');


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
		$model=Employeeover::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Employeeoverdet::model()->findByPk((int)$id);
		//if($model===null)
		//	throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeeover-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeeoverdet-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class PettycashController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'pettycash';

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

	public $pettycashdetail, $employee;

	public function lookupdata()
	{
	  $this->pettycashdetail=new Pettycashdetail('search');
	  $this->pettycashdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Pettycashdetail']))
		$this->pettycashdetail->attributes=$_GET['Pettycashdetail'];

      $this->employee=new Employee('search');
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
	  $model=new Pettycash;
	  $model->recordstatus=0;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  if ($model->save()) {
			echo CJSON::encode(array(
				'status'=>'success',
				'pettycashid'=>$model->pettycashid,
				'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'pettycashdetail'=>$this->pettycashdetail,
                    'employee'=>$this->employee), true)
				));
			Yii::app()->end();
		  }
	  }
	}

	public function actionCreatedetail()
	{
      $this->lookupdata();
	  $pettycashdetail=new Pettycashdetail;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_formdetail',
				array('model'=>$pettycashdetail), true)
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
				'pettycashid'=>$model->pettycashid,
				'pettycashdate'=>$model->pettycashdate,
				'employeeid'=>$model->employeeid,
				'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
				'pettycashval'=>$model->pettycashval,
				'currencyid'=>$model->currencyid,
				'currencyname'=>($model->currency!==null)?$model->currency->currencyname:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'pettycashdetail'=>$this->pettycashdetail,
                    'employee'=>$this->employee), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
		$id=$_POST['id'];
	  $pettycashdetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'pettycashdetailid'=>$pettycashdetail->pettycashdetailid,
				'accountid'=>$pettycashdetail->accountid,
				'accountcode'=>($pettycashdetail->account!==null)?$pettycashdetail->account->accountcode:"",
				'accountname'=>($pettycashdetail->account!==null)?$pettycashdetail->account->accountname:"",
				'debit'=>$pettycashdetail->debit,
				'credit'=>$pettycashdetail->credit,
				'currencyid'=>$pettycashdetail->currencyid,
				'currencyname'=>($pettycashdetail->currency!==null)?$pettycashdetail->currency->currencyname:"",
				'projectid'=>$pettycashdetail->projectid,
				'projectno'=>($pettycashdetail->project!==null)?$pettycashdetail->project->projectno:"",
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$pettycashdetail), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Pettycash'], $_POST['Pettycash']['pettycashid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Pettycash']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Pettycash']['pettycashval'],'aarpcemptypettycashval','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Pettycash'];
		if ((int)$_POST['Pettycash']['pettycashid'] > 0)
		{
		  $model=$this->loadModel($_POST['Pettycash']['pettycashid']);
		  $model->pettycashval = $_POST['Pettycash']['pettycashval'];
		  $model->employeeid = $_POST['Pettycash']['employeeid'];
		  $model->currencyid = $_POST['Pettycash']['currencyid'];
		  $model->recordstatus = $_POST['Pettycash']['recordstatus'];
		}
		else
		{
		  $model = new Pettycash();
		  $model->attributes=$_POST['Pettycash'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Pettycash']['pettycashid']);
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
	  if(isset($_POST['Pettycashdetail']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Pettycashdetail']['accountid'],'aarpcemptyaccount','emptystring'),
                array($_POST['Pettycashdetail']['debit'],'aarpcemptydebit','emptystring'),
                array($_POST['Pettycashdetail']['credit'],'aarpcemptycredit','emptystring'),
                array($_POST['Pettycashdetail']['currencyid'],'aarpcemptycurrency','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Pettycashdetail'];
          if ((int)$_POST['Pettycashdetail']['pettycashdetailid'] > 0)
          {
            $model=Pettycashdetail::model()->findbyPK($_POST['Pettycashdetail']['pettycashdetailid']);
            $model->pettycashid = $_POST['Pettycashdetail']['pettycashid'];
            $model->accountid = $_POST['Pettycashdetail']['accountid'];
            $model->debit = $_POST['Pettycashdetail']['debit'];
            $model->credit = $_POST['Pettycashdetail']['credit'];
            $model->currencyid = $_POST['Pettycashdetail']['currencyid'];
            $model->projectid = $_POST['Pettycashdetail']['projectid'];
          }
          else
          {
            $model = new Pettycashdetail();
            $model->attributes=$_POST['Pettycashdetail'];
          }
          try
          {
            if($model->save())
            {
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
		  $model=Pettycashdetail::model()->findbyPK($ids);
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
          $sql = 'call ApprovePettyCash(:vid, :vlastupdateby)';
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
		$model=new Pettycash('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pettycash']))
			$model->attributes=$_GET['Pettycash'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'pettycashdetail'=>$this->pettycashdetail
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
		array('pettycashdetail'=>$this->pettycashdetail));
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
		$model=Pettycash::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Pettycashdetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='pettycash-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='pettycashdetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

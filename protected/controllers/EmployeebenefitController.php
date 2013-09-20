<?php

class EmployeebenefitController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeebenefit';

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
	
public $employee,$employeebenefitdetail;

	public function lookupdata()
	{
	  $this->employee=new Employee('searchwstatus');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$this->employee->attributes=$_GET['Employee'];

	   $this->employeebenefitdetail=new Employeebenefitdetail('searchwstatus');
	  $this->employeebenefitdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeebenefitdetail']))
		$this->employeebenefitdetail->attributes=$_GET['Employeebenefitdetail'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Employeebenefit;
	  $model->recordstatus=0;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  if ($model->save()) {
			echo CJSON::encode(array(
				'status'=>'success',
				'employeebenefitid'=>$model->employeebenefitid,
				'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'employeebenefitdetail'=>$this->employeebenefitdetail), true)
				));
			Yii::app()->end();
		  }
	  }
	}

	public function actionCreatedetail()
	{
	  $employeebenefitdetail=new Employeebenefitdetail;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_formdetail',
				array('model'=>$employeebenefitdetail), true)
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
				'employeebenefitid'=>$model->employeebenefitid,
				'employeeid'=>$model->employeeid,
				'currencyid'=>$model->currencyid,
				'currencyname'=>($model->currency!==null)?$model->currency->currencyname:"",
				'ratevalue'=>$model->ratevalue,
                'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'employeebenefitdetail'=>$this->employeebenefitdetail), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
		$id=$_POST['id'];
	  $employeebenefitdetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'employeebenefitdetailid'=>$employeebenefitdetail->employeebenefitdetailid,
				'wagetypeid'=>$employeebenefitdetail->wagetypeid,
				'wagename'=>($employeebenefitdetail->wagetype!==null)?$employeebenefitdetail->wagetype->wagename:"",
				'startdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($employeebenefitdetail->startdate)),
				'enddate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($employeebenefitdetail->enddate)),
                'reason'=>$employeebenefitdetail->reason,
                'amount'=>$employeebenefitdetail->amount,
				'isfinal'=>$employeebenefitdetail->isfinal,
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$employeebenefitdetail), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeebenefit'], $_POST['Employeebenefit']['employeebenefitid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeebenefit']))
	  {
        $messages = $this->ValidateData(
                array(
                array($_POST['Employeebenefit']['employeeid'],'agjemptyemployeeid','emptystring'),
                    array($_POST['Employeebenefit']['currencyid'],'agjemptycurrencyid','emptystring'),
                    array($_POST['Employeebenefit']['ratevalue'],'agjemptyratevalue','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Employeebenefit'];
		if ((int)$_POST['Employeebenefit']['employeebenefitid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeebenefit']['employeebenefitid']);
		  $model->employeeid = $_POST['Employeebenefit']['employeeid'];
            $model->currencyid = $_POST['Employeebenefit']['currencyid'];
            $model->ratevalue = $_POST['Employeebenefit']['ratevalue'];
		  $model->recordstatus = $_POST['Employeebenefit']['recordstatus'];
		}
		else
		{
		  $model = new Employeebenefit();
		  $model->attributes=$_POST['Employeebenefit'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeebenefit']['employeebenefitid']);
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

    public function actionGeneratedetail()
    {
      if (isset($_POST['id']))
	  {
        $model = Employeebenefitdetail::model()->findbysql('select * from employeebenefitdetail a
          where wagetypeid = 1
          and now() between startdate and enddate
          and employeebenefitid = '.$_POST['id']);
        if ($model != null) {
          $gapok = $model->amount;
        }
        $wagetype = Wagetype::model()->findbysql('select * from wagetype where wagetypeid = '.$_POST['wagetypeid']);
        $amount = 0;
        if ($wagetype != null) {
          if ($wagetype->percentage != 0) {
            $amount = $wagetype->percentage * $gapok / 100;
			if ($wagetype->maxvalue > 0) {
				$amount = $wagetype->maxvalue;
			}
          }
        }
        $connection=Yii::app()->db;
        $sql = 'select date(now()) as startdate,date(date_add(now(),interval 10 year)) as enddate';
        $command=$connection->createCommand($sql);
        $datareader = $command->queryAll();
        $startdate;
        $enddate;
        foreach($datareader as $row) {
          $startdate = $row['startdate'];
          $enddate = $row['enddate'];
        }
        echo CJSON::encode(array(
            'status'=>'success',
            'amount'=>$amount,
            'startdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($startdate)),
            'enddate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($enddate)),
            ));
        Yii::app()->end();
      }
    }

	public function actionWritedetail()
	{
	  if(isset($_POST['Employeebenefitdetail']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeebenefitdetail']['wagetypeid'],'agjemptywagetypeid','emptystring'),
                array($_POST['Employeebenefitdetail']['startdate'],'agjemptystartdate','emptystring'),
                array($_POST['Employeebenefitdetail']['enddate'],'agjemptyenddate','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Employeebenefitdetail'];
          if ((int)$_POST['Employeebenefitdetail']['employeebenefitdetailid'] > 0)
          {
            $model=Employeebenefitdetail::model()->findbyPK($_POST['Employeebenefitdetail']['employeebenefitdetailid']);
            $model->wagetypeid = $_POST['Employeebenefitdetail']['wagetypeid'];
            $model->startdate = $_POST['Employeebenefitdetail']['startdate'];
            $model->enddate = $_POST['Employeebenefitdetail']['enddate'];
            $model->reason = $_POST['Employeebenefitdetail']['reason'];
            $model->amount = $_POST['Employeebenefitdetail']['amount'];
            $model->isfinal = $_POST['Employeebenefitdetail']['isfinal'];
          }
          else
          {
            $model = new Employeebenefitdetail();
            $model->attributes=$_POST['Employeebenefitdetail'];
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
		  $model=Employeebenefitdetail::model()->findbyPK($ids);
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
          $sql = 'call ApproveEmployeeWage(:vid, :vlastupdateby)';
          $command=$connection->createCommand($sql);
          $command->bindValue(':vid',$ids,PDO::PARAM_INT);
          $command->bindValue(':vlastupdateby', $a,PDO::PARAM_STR);
          $command->execute();
          $transaction->commit();
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
		$model=new Employeebenefit('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employeebenefit']))
			$model->attributes=$_GET['Employeebenefit'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'employeebenefitdetail'=>$this->employeebenefitdetail
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
		array('employeebenefitdetail'=>$this->employeebenefitdetail));
	  Yii::app()->end();
	}

    public function actionUpload()
    {
      parent::actionUpload();
     $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploadfile']['name']); 
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
			echo "success";
			$row=1;			
			if (($handle = fopen($file, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					if ($row>1) {
						$employee=Employee::model()->findbyattributes(array('oldnik'=>$data[0]));
						if ($employee != null)
						{
							$empbenefit = Employeebenefit::model()->findbyattributes(array('employeeid'=>$employee->employeeid));
							if ($empbenefit == null)
							{
							  $empbenefit = new Employeebenefit();
							}
							$empbenefit->employeeid = $employee->employeeid;
							$currency = Currency::model()->findbyattributes(array('currencyname'=>$data[6]));
							if ($currency != null)
							{
							  $empbenefit->currencyid = $currency->currencyid;
							}
							$empbenefit->ratevalue = 1;
							$empbenefit->recordstatus = 1;
							if ($empbenefit->save())
							{
							  $empbenefitdetail = new Employeebenefitdetail();
							  $empbenefitdetail->employeebenefitid = $empbenefit->employeebenefitid;
							  $wagetype = Wagetype::model()->findbyattributes(array('wagename'=>$data[2]));
							  if ($wagetype != null)
							  {
								$empbenefitdetail->wagetypeid = $wagetype->wagetypeid;
							  }
							  $empbenefitdetail->startdate = $data[3];
							  $empbenefitdetail->enddate = $data[4];
							  $empbenefitdetail->amount=$data[5];
							  $empbenefitdetail->reason=$data[8];
							  $empbenefitdetail->isfinal=$data[7];
							  if(!$empbenefitdetail->save())
								{
									  echo $empbenefitdetail->getErrors();
								}
							}
							else
							{
								echo $empbenefit->getErrors();
							}
							
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
     $pdf = new PDF();
        $pdf->title='Employee Benefit List';
        $pdf->AddPage('P');
        $pdf->setFont('Arial','B',12);

        // menuliskan header
        $connection=Yii::app()->db;
        $sql = "select a.employeebenefitid, b.fullname, c.levelorgname, d.structurename,
          e.currencyname,a.ratevalue
          from employeebenefit a
          left join employee b on b.employeeid = a.employeeid
          left join levelorg c on c.levelorgid = b.levelorgid
          left join orgstructure d on d.orgstructureid = b.orgstructureid
          left join currency e on e.currencyid = a.currencyid";
        $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();

        foreach($dataReader as $row)
        {
        	$pdf->setFont('Arial','B',12);
          $pdf->text(100,30,$row['fullname']);
        	$pdf->setFont('Arial','',12);
          $pdf->text(100,35,$row['levelorgname']);
          $pdf->text(100,40,$row['structurename']);

          // menuliskan detail
          $sql1 = "select b.wagename,a.startdate,a.enddate,a.reason,a.amount
            from employeebenefitdetail a
            left join wagetype b on b.wagetypeid = a.wagetypeid
            where a.employeebenefitid = ".$row['employeebenefitid'];
          $command1=$connection->createCommand($sql1);
          $dataReader1=$command1->queryAll();

          $pdf->setY(50);

          $pdf->setwidths(array(80,25,25,30,25));
          $pdf->SetAligns(array('C','C','C','C','C'));
          $pdf->setFont('Arial','B',10);
          $pdf->row(array('Wage Name','Start Date','End Date','Amount','Reason'));
          $pdf->SetAligns(array('L','R','R','R','R'));
          $pdf->setFont('Arial','B',8);
          $pdf->SetTableData();
          foreach($dataReader1 as $row1)
          {
            $pdf->row(array($row1['wagename'],
                $row1['startdate'],
                $row1['enddate'],
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row1['amount']),
                $row1['reason']));
          }
          $pdf->AddPage('P');
        }
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
		$model=Employeebenefit::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Employeebenefitdetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeebenefit-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeebenefitdetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

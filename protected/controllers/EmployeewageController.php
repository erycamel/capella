<?php

class EmployeewageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeewage';

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
	
public $employee,$wagetype,$currency,$employeewagedetail;

	public function lookupdata()
	{
	  $this->employee=new Employee('searchwstatus');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$this->employee->attributes=$_GET['Employee'];

	   $this->employeewagedetail=new Employeewagedetail('searchwstatus');
	  $this->employeewagedetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeewagedetail']))
		$this->employeewagedetail->attributes=$_GET['Employeewagedetail'];
      $this->lookupdetail();
	}

	public function lookupdetail()
	{
	  $this->wagetype=new Wagetype('searchwstatus');
	  $this->wagetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Wagetype']))
		$this->wagetype->attributes=$_GET['Wagetype'];

	  $this->currency=new Currency('searchwstatus');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Employeewage;
	  $model->recordstatus=0;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  if ($model->save()) {
			echo CJSON::encode(array(
				'status'=>'success',
				'employeewageid'=>$model->employeewageid,
				'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'employeewagedetail'=>$this->employeewagedetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype), true)
				));
			Yii::app()->end();
		  }
	  }
	}

	public function actionCreatedetail()
	{
	  $employeewagedetail=new Employeewagedetail;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_formdetail',
				array('model'=>$employeewagedetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype), true)
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
				'employeewageid'=>$model->employeewageid,
				'employeeid'=>$model->employeeid,
                'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'employeewagedetail'=>$this->employeewagedetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
		$id=$_POST['id'];
	  $employeewagedetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'employeewagedetailid'=>$employeewagedetail->employeewagedetailid,
				'wagetypeid'=>$employeewagedetail->wagetypeid,
				'wagetypename'=>($employeewagedetail->wagetype!==null)?$employeewagedetail->wagetype->wagename:"",
				'amount'=>$employeewagedetail->amount,
				'currencyid'=>$employeewagedetail->currencyid,
				'currencyname'=>($employeewagedetail->currency!==null)?$employeewagedetail->currency->currencyname:"",
				'startdate'=>$employeewagedetail->startdate,
				'enddate'=>$employeewagedetail->enddate,
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$employeewagedetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeewage'], $_POST['Employeewage']['employeewageid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeewage']))
	  {
        $messages = $this->ValidateData(
                array(
                array($_POST['Employeewage']['employeeid'],'agjemptyemployeeid','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Employeewage'];
		if ((int)$_POST['Employeewage']['employeewageid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeewage']['employeewageid']);
		  $model->employeeid = $_POST['Employeewage']['employeeid'];
		  $model->recordstatus = $_POST['Employeewage']['recordstatus'];
		}
		else
		{
		  $model = new Employeewage();
		  $model->attributes=$_POST['Employeewage'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeewage']['employeewageid']);
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
	  if(isset($_POST['Employeewagedetail']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeewagedetail']['wagetypeid'],'agjemptyaccount','emptystring'),
                array($_POST['Employeewagedetail']['startdate'],'agjemptydebit','emptystring'),
                array($_POST['Employeewagedetail']['enddate'],'agjemptycredit','emptystring'),
                array($_POST['Employeewagedetail']['amount'],'agjemptycredit','emptystring'),
                array($_POST['Employeewagedetail']['currencyid'],'agjemptycredit','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Employeewagedetail'];
          if ((int)$_POST['Employeewagedetail']['employeewagedetailid'] > 0)
          {
            $model=Employeewagedetail::model()->findbyPK($_POST['Employeewagedetail']['employeewagedetailid']);
            $model->wagetypeid = $_POST['Employeewagedetail']['wagetypeid'];
            $model->startdate = $_POST['Employeewagedetail']['startdate'];
            $model->enddate = $_POST['Employeewagedetail']['enddate'];
            $model->amount = $_POST['Employeewagedetail']['amount'];
            $model->currencyid = $_POST['Employeewagedetail']['currencyid'];
          }
          else
          {
            $model = new Employeewagedetail();
            $model->attributes=$_POST['Employeewagedetail'];
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
		  $model=Employeewagedetail::model()->findbyPK($ids);
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
		$model=new Employeewage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employeewage']))
			$model->attributes=$_GET['Employeewage'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('index',array(
			'model'=>$model,
			'employeewagedetail'=>$this->employeewagedetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype
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
		array('employeewagedetail'=>$this->employeewagedetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype));
	  Yii::app()->end();
	}

    public function actionUpload()
    {
      parent::actionUpload();
      Yii::import("ext.EAjaxUpload.qqFileUploader");
	  $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
	  $allowedExtensions = array("csv");
	  $sizeLimit = (int)Yii::app()->params['sizeLimit'];// maximum file size in bytes
	  $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	  $result = $uploader->handleUpload($folder,true);
	  $row = 0;
      $oldid = 0;
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Employeewage::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Employeewage();
                $model->journaldate = $data[2];
                $model->postdate = $data[2];
                $model->referenceno = $data[3];
			  }
              $model->employeewageid = (int)$data[0];
              $model->recordstatus = 1;
			  try
			  {
				if(!$model->save())
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
                else {
                  $detail=Employeewagedetail::model()->findByPk((int)$data[1]);
                  if ($detail=== null) {
                    $detail = new Employeewagedetail();
                  }
                  $detail->employeewagedetailid = (int)$data[1];
                  $detail->employeewageid = (int)$data[0];
                  $detail->accountid = Account::model()->findbysql("select accountid from account where upper(accountcode) = '".$data[4]."'")->accountid;
                  if ($data[5] != '') 
                  {
                    $detail->debit = $data[5];
                    $detail->credit = 0;
                  }
                  if ($data[6] != '')
                  {
                    $detail->debit = 0;
                    $detail->credit = $data[6];
                  }
                  $detail->currencyid = Currency::model()->findbysql("select currencyid from currency where upper(currencyname) = '".$data[7]."'")->currencyid;
                  $detail->detailnote = $data[3];
                  if(!$detail->save())
                  {
                    $errormessage=$detail->getErrors();
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
			$row++;
		  }
		  fclose($handle);
	  }
	  $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	  echo $result;
  }

	public function actionDownload()
  {
	parent::actionDownload();
	$sql = "select a.employeeid, a.wagestartperiod,a.wageendperiod, a.employeewageid, b.fullname, 
			c.levelorgname, d.structurename
          from employeewage a
          left join employee b on b.employeeid = a.employeeid
          left join levelorg c on c.levelorgid = b.levelorgid
          left join orgstructure d on d.orgstructureid = b.orgstructureid ";
		  if ($_GET['id'] !== '') {
				$sql = $sql . " where a.employeewageid = ". $_GET['id'];
		}
        $command=$this->connection->createCommand($sql);
        $dataReader=$command->queryAll();
		$this->pdf->isheader=false;
        $this->pdf->title='';
        $this->pdf->AddPage('P','GAJI');		
        $this->pdf->setFont('Arial','B',8);

		$this->pdf->SetAligns(5);
        foreach($dataReader as $row)
        {
        	$this->pdf->setFont('Arial','B',8);
			$this->pdf->text(10,36,'No Slip   '.$row['employeewageid']);
			$this->pdf->text(10,41,'Nama      '.$row['fullname']);
			$this->pdf->text(10,46,'Status    '.$row['levelorgname']);
			$this->pdf->text(10,51,'Posisi    '.$row['structurename']);
			
			// menuliskan detail
			$sql1 = "select b.wagename,a.amount
				from employeewagedetail a
				inner join wagetype b on b.wagetypeid = a.wagetypeid
				where a.employeewageid = ".$row['employeewageid'] . " and amount > 0 ";
			$command1=$this->connection->createCommand($sql1);
			$dataReader1=$command1->queryAll();
		
			$this->pdf->setY($this->pdf->gety()+50);
			$this->pdf->setwidths(array(55,22,22));
			$this->pdf->colalign = array('L','R','R');
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->colheader =array('Wage Name','Addition','Deduction');
			$this->pdf->rowheader();
		  
			$this->pdf->SetTableData();
			$totaladd = 0;
			$totaldec = 0;
			$total = 0;
 
			foreach($dataReader1 as $row1)
			{		
				$this->pdf->row(array($row1['wagename'],
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row1['amount']),
				''));
				$totaladd += $row1['amount'];
			}
			
			$sql1 = "select b.wagename,a.amount
				from employeewagedetail a
				inner join wagetype b on b.wagetypeid = a.wagetypeid
				where a.employeewageid = ".$row['employeewageid'] . " and amount <= 0 ";
			$command1=$this->connection->createCommand($sql1);
			$dataReader1=$command1->queryAll();
		
			foreach($dataReader1 as $row1)
			{		
				$this->pdf->row(array($row1['wagename'],
				'',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row1['amount'])));
				$totaldec += $row1['amount'];
			}
			$this->pdf->row(array('Sub Total',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$totaladd),
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$totaldec),
));
			$total = $totaladd + $totaldec;
			$this->pdf->row(array('Total',
				Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$total),
				''));
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
		$model=Employeewage::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Employeewagedetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeewage-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeewagedetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

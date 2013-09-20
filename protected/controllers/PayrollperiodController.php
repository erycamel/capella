<?php

class PayrollperiodController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
 protected $menuname = 'payrollperiod';
	public $parentpayrollperiod;
	
	public function lookupdata()
	{
	  $this->parentpayrollperiod=new Payrollperiod('searchwstatus');
	  $this->parentpayrollperiod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Payrollperiod']))
		$this->parentpayrollperiod->attributes=$_GET['Payrollperiod'];
	}

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
	  $this->lookupdata();
	  $model=new Payrollperiod;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				'parentpayrollperiod'=>$this->parentpayrollperiod), true)
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
			  'payrollperiodid'=>$model->payrollperiodid,
			  'payrollperiodname'=>$model->payrollperiodname,
			  'startdate'=>$model->startdate,
			  'enddate'=>$model->enddate,
			  'parentperiodid'=>$model->parentperiodid,
			  'parentpayrollperiodname'=>($model->parentpayrollperiod!==null)?$model->parentpayrollperiod->payrollperiodname:"",
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
				'parentpayrollperiod'=>$this->parentpayrollperiod), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
	  $this->DeleteLockCloseForm($this->menuname, $_POST['Payrollperiod'], $_POST['Payrollperiod']['payrollperiodid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Payrollperiod']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Payrollperiod']['payrollperiodname'],'hpypemptypayrollperiodname','emptystring'),
                array($_POST['Payrollperiod']['startdate'],'hpypemptystartdate','emptystring'),
                array($_POST['Payrollperiod']['enddate'],'hpypemptyenddate','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Payrollperiod'];
		if ((int)$_POST['Payrollperiod']['payrollperiodid'] > 0)
		{
		  $model=$this->loadModel($_POST['Payrollperiod']['payrollperiodid']);
		  $model->payrollperiodname = $_POST['Payrollperiod']['payrollperiodname'];
		  $model->startdate = $_POST['Payrollperiod']['startdate'];
		  $model->enddate = $_POST['Payrollperiod']['enddate'];
		  $model->parentperiodid = $_POST['Payrollperiod']['parentperiodid'];
		  $model->recordstatus = $_POST['Payrollperiod']['recordstatus'];
		}
		else
		{
		  $model = new Payrollperiod();
		  $model->attributes=$_POST['Payrollperiod'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname,$_POST['Payrollperiod']['payrollperiodid']);
              $this->GetSMessage('aaccinsertsuccess');
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
      parent::actionIndex();
	  $this->lookupdata();
	  $model=new Payrollperiod('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Payrollperiod']))
			$model->attributes=$_GET['Payrollperiod'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		'model'=>$model,
				  'parentpayrollperiod'=>$this->parentpayrollperiod
	  ));
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
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Payrollperiod::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Payrollperiod();
			  }
			  $model->payrollperiodid = (int)$data[0];
			  $model->payrollperiodcode = $data[1];
			  $model->payrollperiodname = $data[2];
			  if ($data[3] != '') {
				$model->parentpayrollperiodid = (int)$data[3];
			  } else {
				$model->parentpayrollperiodid = null;
			  }
			  if ($data[4] != '') {
                $payrollperiodtype = Payrollperiodtype::model()->findbysql("select * from payrollperiodtype where upper(payrollperiodtypename) = upper('".$data[4]."')");
                if ($payrollperiodtype != null) {
                  $model->payrollperiodtypeid = $payrollperiodtype->payrollperiodtypeid;
                } else {
                  $model->payrollperiodtypeid = null;
                }
			  } else {
				$model->payrollperiodtypeid = null;
			  }
			  if ($data[5] != '') {
                $currency = Currency::model()->findbysql("select * from currency where upper(currencyname) = upper('".$data[5]."')");
                if ($currency != null) {
                  $model->currencyid = $currency->currencyid;
                } else {
                  $model->currencyid = null;
                }
			  } else {
				$model->currencyid = null;
			  }
			  $model->recordstatus = $data[6];
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
    $pdf = new PDF();
	  $pdf->title='Payroll Period List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select a.payrollperiodname, a.startdate,a.enddate,b.payrollperiodname as Parentperiod
      from payrollperiod a
      left join payrollperiod b on b.payrollperiodid = a.parentperiodid";
    $command=$connection->createCommand($sql);
    $dataReader=$command->queryAll();

    $pdf->setaligns(array('C','C','C','C'));
    $pdf->setwidths(array(50,30,30,30));
    $pdf->Row(array('Payroll Period','Start Date','End Date','Periode Before'));
    $pdf->setaligns(array('L','L','L','L'));
    foreach($dataReader as $row1)
    {
      $pdf->row(array($row1['payrollperiodname'],$row1['startdate'],$row1['enddate'],$row1['Parentperiod']));
    }
    // me-render ke browser
    $pdf->Output('payrollperiod.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Payrollperiod::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='payrollperiod-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

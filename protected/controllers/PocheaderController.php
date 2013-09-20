<?php

class PocheaderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'pocheader';

	public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpdetail'; break;
				case 4 : $this->txt = '_helpdetailmodif'; break;
			}
		}
		parent::actionHelp();
	}

    public $customer, $product, $unitofmeasure, $currency,$pocdetail,$projecttype;
    
    public function lookupdata()
    {
      $this->customer=new Customer('search');
	  $this->customer->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$this->customer->attributes=$_GET['Customer'];

      $this->projecttype=new Projecttype('search');
	  $this->projecttype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projecttype']))
		$this->projecttype->attributes=$_GET['Projecttype'];

            $this->pocdetail=new Pocdetail('search');
	  $this->pocdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Pocdetail']))
		$this->pocdetail->attributes=$_GET['Pocdetail'];
      $this->lookupdetail();
    }

    public function lookupdetail()
    {
		$this->product=new Product('search');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

      $this->unitofmeasure=new Unitofmeasure('search');
	  $this->unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$this->unitofmeasure->attributes=$_GET['Unitofmeasure'];

      $this->currency=new Currency('search');
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
      $model=new Pocheader;
      $model->recordstatus=0;
      if (Yii::app()->request->isAjaxRequest)
      {
          if ($model->save()) {
            echo CJSON::encode(array(
                'status'=>'success',
                'pocheaderid'=>$model->pocheaderid,
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
                  'pocdetail'=>$this->pocdetail,
                  'customer'=>$this->customer,
                  'product'=>$this->product,
                  'unitofmeasure'=>$this->unitofmeasure,
                    'currency'=>$this->currency,
                    'projecttype'=>$this->projecttype), true)
                ));
            Yii::app()->end();
          }
      }
	}

	public function actionCreatedetail()
	{
      $this->lookupdetail();
      $pocdetail=new Pocdetail;

      if (Yii::app()->request->isAjaxRequest)
      {
          echo CJSON::encode(array(
              'status'=>'success',
              'divcreate'=>$this->renderPartial('_formdetail',
                array('model'=>$pocdetail,
                  'product'=>$this->product,
                  'unitofmeasure'=>$this->unitofmeasure,
                    'currency'=>$this->currency), true)
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
				'pocheaderid'=>$model->pocheaderid,
				'pocdate'=>$model->pocdate,
				'postdate'=>$model->postdate,
				'addressbookid'=>$model->addressbookid,
                'pocno'=>$model->pocno,
				'fullname'=>($model->customer!==null)?$model->customer->fullname:"",
                'sono'=>$model->sono,
                'contractno'=>$model->contractno,
                'woino'=>$model->woino,
                'deliverydate'=>$model->deliverydate,
                'testdate'=>$model->testdate,
                'qcdate'=>$model->qcdate,
                'docdate'=>$model->docdate,
                'piccust'=>$model->piccust,
                'phoneno'=>$model->phoneno,
                'projecttypeid'=>$model->projecttypeid,
				'protypedescription'=>($model->projecttype!==null)?$model->customer->fullname:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'pocdetail'=>$this->pocdetail,
                  'customer'=>$this->customer,
                  'product'=>$this->product,
                  'unitofmeasure'=>$this->unitofmeasure,
                    'currency'=>$this->currency,
                    'projecttype'=>$this->projecttype), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
      $this->lookupdetail();

		$id=$_POST['id'];
	  $pocdetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'pocdetailid'=>$pocdetail->pocdetailid,
				'productid'=>($pocdetail->product!==null)?$pocdetail->product->productid:"",
				'productname'=>($pocdetail->product!==null)?$pocdetail->product->productname:"",
				'qty'=>$pocdetail->qty,
				'unitofmeasureid'=>$pocdetail->unitofmeasureid,
				'uomcode'=>($pocdetail->unitofmeasure!==null)?$pocdetail->unitofmeasure->uomcode:"",
                'price'=>$pocdetail->price,
				'currencyname'=>($pocdetail->currency!==null)?$pocdetail->currency->currencyname:"",
				'serviceqty'=>$pocdetail->serviceqty,
				'serviceuomid'=>$pocdetail->serviceuomid,
				'serviceuomcode'=>($pocdetail->serviceuom!==null)?$pocdetail->serviceuom->uomcode:"",
                'serviceprice'=>$pocdetail->serviceprice,
				'servicecurrencyname'=>($pocdetail->servicecurrency!==null)?$pocdetail->servicecurrency->currencyname:"",
                'description'=>$pocdetail->description,
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$pocdetail,
                  'product'=>$this->product,
                  'unitofmeasure'=>$this->unitofmeasure,
                    'currency'=>$this->currency), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Pocheader'], $_POST['Pocheader']['pocheaderid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Pocheader']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Pocheader']['addressbookid'],'sdpocemptyaddressbookid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Pocheader']['pocheaderid'] > 0)
		{
		  $model=$this->loadModel($_POST['Pocheader']['pocheaderid']);
		  $model->pocno = $_POST['Pocheader']['pocno'];
		  $model->pocdate = $_POST['Pocheader']['pocdate'];
		  $model->addressbookid = $_POST['Pocheader']['addressbookid'];
		  $model->sono = $_POST['Pocheader']['sono'];
		  $model->contractno = $_POST['Pocheader']['contractno'];
		  $model->woino = $_POST['Pocheader']['woino'];
		  $model->deliverydate = $_POST['Pocheader']['deliverydate'];
		  $model->testdate = $_POST['Pocheader']['testdate'];
		  $model->qcdate = $_POST['Pocheader']['qcdate'];
		  $model->docdate = $_POST['Pocheader']['docdate'];
		  $model->piccust = $_POST['Pocheader']['piccust'];
		  $model->phoneno = $_POST['Pocheader']['phoneno'];
		  $model->projecttypeid = $_POST['Pocheader']['projecttypeid'];
		  $model->recordstatus = $_POST['Pocheader']['recordstatus'];
		}
		else
		{
		  $model = new Pocheader();
		  $model->attributes=$_POST['Pocheader'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Pocheader']['pocheaderid']);
              $this->GetSMessage('sdpocinsertsuccess');
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
	  if(isset($_POST['Pocdetail']))
	  {
		if ((int)$_POST['Pocdetail']['pocdetailid'] > 0)
		{
		  $model=Pocdetail::model()->findbyPK($_POST['Pocdetail']['pocdetailid']);
		  $model->pocheaderid = $_POST['Pocdetail']['pocheaderid'];
		  $model->productid = $_POST['Pocdetail']['productid'];
		  $model->unitofmeasureid = $_POST['Pocdetail']['unitofmeasureid'];
		  $model->qty = $_POST['Pocdetail']['qty'];
		  $model->price = $_POST['Pocdetail']['price'];
		  $model->currencyid = $_POST['Pocdetail']['currencyid'];
		  $model->serviceuomid = $_POST['Pocdetail']['serviceuomid'];
		  $model->serviceqty = $_POST['Pocdetail']['serviceqty'];
		  $model->serviceprice = $_POST['Pocdetail']['serviceprice'];
		  $model->servicecurrencyid = $_POST['Pocdetail']['servicecurrencyid'];
		  $model->description = $_POST['Pocdetail']['description'];
		}
		else
		{
		  $model = new Pocdetail();
		  $model->attributes=$_POST['Pocdetail'];
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
		  $model=Pocdetail::model()->findbyPK($ids);
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
			$model=$this->loadModel($ids);
			$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call ApprovePOC(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindValue(':vid',$model->pocheaderid,PDO::PARAM_INT);
				$command->bindValue(':vlastupdateby', Yii::app()->user->name,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
					  'div'=>"Data saved"
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
      $this->lookupdata();

      $model=new Pocheader('search');
      $model->unsetAttributes();  // clear any default values
      if(isset($_GET['Pocheader']))
          $model->attributes=$_GET['Pocheader'];
      if (isset($_GET['pageSize']))
      {
        Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
        unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
      }

      $this->render('index',array(
          'model'=>$model,
          'pocdetail'=>$this->pocdetail,
          'customer'=>$this->customer,
          'product'=>$this->product,
          'unitofmeasure'=>$this->unitofmeasure,
          'currency'=>$this->currency,
                    'projecttype'=>$this->projecttype
      ));
	}

	public function actionIndexdetail()
	{
      $this->lookupdetail();
	  $pocdetail=new Pocdetail('search');
	  $pocdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Pocdetail']))
		$pocdetail->attributes=$_GET['Pocdetail'];

	  $this->renderPartial('indexdetail',
		array('pocdetail'=>$pocdetail,
                  'product'=>$this->product,
                  'unitofmeasure'=>$this->unitofmeasure,
                    'currency'=>$this->currency));
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
		$model=Pocheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Pocdetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='pocheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='pocdetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

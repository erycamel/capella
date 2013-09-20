<?php

class InvoiceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'invoice';

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

	public $invoicemat,$invoicepay;

	public function lookupdata()
	{
	  $this->invoicemat=new Invoicemat('search');
	  $this->invoicemat->unsetAttributes();  // clear any default values
	  if(isset($_GET['Invoicemat']))
		$this->invoicemat->attributes=$_GET['Invoicemat'];

      $this->invoicepay=new Invoicepay('search');
	  $this->invoicepay->unsetAttributes();  // clear any default values
	  if(isset($_GET['Invoicepay']))
		$this->invoicepay->attributes=$_GET['Invoicepay'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Invoice;
	  $model->invoiceno='Reference No';
	  $model->recordstatus=0;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  if ($model->save()) {
			echo CJSON::encode(array(
				'status'=>'success',
				'invoiceid'=>$model->invoiceid,
				'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'invoicemat'=>$this->invoicemat,
                    'invoicepay'=>$this->invoicepay), true)
				));
			Yii::app()->end();
		  }
	  }
	}

	public function actionCreatedetail()
	{
	  $invoicemat=new Invoicemat;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_formdetail',
				array('model'=>$invoicemat), true)
			  ));
		  Yii::app()->end();
	  }
	}

    public function actionCreatepay()
	{
	  $invoicepay=new Invoicepay;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_formpay',
				array('model'=>$invoicepay), true)
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
				'invoiceid'=>$model->invoiceid,
				'poheaderid'=>$model->poheaderid,
				'pono'=>($model->poheader!==null)?$model->poheader->pono:"",
				'invoiceno'=>$model->invoiceno,
				'invoicedate'=>$model->invoicedate,
                'addressbookid'=>$model->addressbookid,
                'fullname'=>($model->supplier!==null)?$model->supplier->fullname:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'invoicemat'=>$this->invoicemat,
                    'invoicepay'=>$this->invoicepay), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionUpdatedetail()
	{
		$id=$_POST['id'];
	  $invoicemat=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'invoicematid'=>$invoicemat->invoicematid,
				'productid'=>$invoicemat->productid,
				'productname'=>($invoicemat->product!==null)?$invoicemat->product->productname:"",
				'qty'=>$invoicemat->qty,
				'unitofmeasureid'=>$invoicemat->unitofmeasureid,
				'uomcode'=>($invoicemat->unitofmeasure!==null)?$invoicemat->unitofmeasure->uomcode:"",
                'price'=>$invoicemat->price,
				'currencyid'=>$invoicemat->currencyid,
				'currencyname'=>($invoicemat->currency!==null)?$invoicemat->currency->currencyname:"",
				'taxid'=>$invoicemat->taxid,
				'taxname'=>($invoicemat->tax!==null)?$invoicemat->tax->taxname:"",
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$invoicemat), true)
				));
            Yii::app()->end();
        }
	}

    public function actionUpdatepay()
	{
		$id=$_POST['id'];
	  $invoicepay=$this->loadModelpay($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'invoicepayid'=>$invoicepay->invoicepayid,
				'accountid'=>$invoicepay->accountid,
				'accountcode'=>($invoicepay->account!==null)?$invoicepay->account->accountcode:"",
				'accountname'=>($invoicepay->account!==null)?$invoicepay->account->accountname:"",
				'price'=>$invoicepay->price,
				'currencyid'=>$invoicepay->currencyid,
				'currencyname'=>($invoicepay->currency!==null)?$invoicepay->currency->currencyname:"",
                'div'=>$this->renderPartial('_formpay',
				  array('model'=>$invoicepay), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Invoice'], $_POST['Invoice']['invoiceid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Invoice']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Invoice']['invoiceno'],'aapiemptyinvoiceno','emptystring'),
                array($_POST['Invoice']['poheaderid'],'aapiemptypoheaderid','emptystring'),
                array($_POST['Invoice']['invoicedate'],'aapiemptyinvoicedate','emptystring'),
                array($_POST['Invoice']['addressbookid'],'aapiemptyaddressbookid','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Invoice'];
		if ((int)$_POST['Invoice']['invoiceid'] > 0)
		{
		  $model=$this->loadModel($_POST['Invoice']['invoiceid']);
		  $model->invoiceno = $_POST['Invoice']['referenceno'];
		  $model->poheaderid = $_POST['Invoice']['journaldate'];
		  $model->invoicedate = $_POST['Invoice']['journalnote'];
		  $model->addressbookid = $_POST['Invoice']['addressbookid'];
		  $model->recordstatus = $_POST['Invoice']['recordstatus'];
		}
		else
		{
		  $model = new Invoice();
		  $model->attributes=$_POST['Invoice'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Invoice']['invoiceid']);
              $this->GetSMessage('aapiinsertsuccess');
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
	  if(isset($_POST['Invoicemat']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Invoicemat']['productid'],'aapcemptyproductid','emptystring'),
                array($_POST['Invoicemat']['qty'],'aapcemptyqty','emptystring'),
                array($_POST['Invoicemat']['unitofmeasureid'],'aapcemptyunitofmeasureid','emptystring'),
                array($_POST['Invoicemat']['price'],'aapcemptyprice','emptystring'),
                array($_POST['Invoicemat']['currencyid'],'aapcemptycurrencyid','emptystring'),
                array($_POST['Invoicemat']['taxid'],'aapcemptytaxid','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Invoicemat'];
          if ((int)$_POST['Invoicemat']['invoicematid'] > 0)
          {
            $model=Invoicemat::model()->findbyPK($_POST['Invoicemat']['invoicematid']);
            $model->invoiceid = $_POST['Invoicemat']['invoiceid'];
            $model->productid = $_POST['Invoicemat']['productid'];
            $model->qty = $_POST['Invoicemat']['qty'];
            $model->unitofmeasureid = $_POST['Invoicemat']['unitofmeasureid'];
            $model->price = $_POST['Invoicemat']['price'];
            $model->currencyid = $_POST['Invoicemat']['currencyid'];
          }
          else
          {
            $model = new Invoicemat();
            $model->attributes=$_POST['Invoicemat'];
          }
          try
          {
            if($model->save())
            {
              $this->GetSMessage('aapiinsertsuccess');
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

    public function actionWritepay()
	{
	  if(isset($_POST['Invoicepay']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Invoicepay']['accountid'],'aapcemptyaccount','emptystring'),
                array($_POST['Invoicepay']['debet'],'aapcemptydebet','emptystring'),
                array($_POST['Invoicepay']['credit'],'aapcemptycredit','emptystring'),
                array($_POST['Invoicepay']['currencyid'],'aapcemptycurrency','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Invoicepay'];
          if ((int)$_POST['Invoicepay']['invoicepayid'] > 0)
          {
            $model=Invoicepay::model()->findbyPK($_POST['Invoicepay']['invoicepayid']);
            $model->invoiceid = $_POST['Invoicepay']['invoiceid'];
            $model->accountid = $_POST['Invoicepay']['accountid'];
            $model->debet = $_POST['Invoicepay']['debet'];
            $model->credit = $_POST['Invoicepay']['credit'];
            $model->currencyid = $_POST['Invoicepay']['currencyid'];
          }
          else
          {
            $model = new Invoicepay();
            $model->attributes=$_POST['Invoicepay'];
          }
          try
          {
            if($model->save())
            {
              $this->GetSMessage('aapcinsertsuccess');
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
		  $model=Invoicemat::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

    public function actionDeletepay()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Invoicepay::model()->findbyPK($ids);
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
          $sql = 'call ApproveInvoice(:vid, :vlastupdateby)';
          $command=$connection->createCommand($sql);
          $command->bindValue(':vid',$ids,PDO::PARAM_INT);
          $command->bindValue(':vlastupdateby', $a,PDO::PARAM_STR);
          $command->execute();
          $transaction->commit();
          $this->GetSMessage('aapcapprovesuccess');
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
		$model=new Invoice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Invoice']))
			$model->attributes=$_GET['Invoice'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'invoicemat'=>$this->invoicemat,
            'invoicepay'=>$this->invoicepay
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
		array('invoicemat'=>$this->invoicemat));
	  Yii::app()->end();
	}

    public function actionIndexpay()
	{
	  $this->lookupdata();
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->renderPartial('indexpay',
		array('invoicepay'=>$this->invoicepay));
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
		$model=Invoice::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Invoicemat::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoicemat-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class ProwotemplateController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'prowotemplate';

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
    
        public $projecttype,$currency,$customer,$unitofmeasure,$product,
            $servicecurrency,$serviceuom;

	public function lookupdata()
	{
	  $this->projecttype=new Projecttype('searchwstatus');
	  $this->projecttype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projecttype']))
		$this->projecttype->attributes=$_GET['Projecttype'];

       $this->currency=new Currency('searchwstatus');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];
      
       $this->product=new Product('searchwstatus');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

      $this->currency=new Currency('searchwstatus');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];

       $this->customer=new Customer('searchwstatus');
	  $this->customer->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$this->customer->attributes=$_GET['Customer'];

      $this->unitofmeasure=new Unitofmeasure('searchwstatus');
	  $this->unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$this->unitofmeasure->attributes=$_GET['Unitofmeasure'];

      $this->serviceuom=new Unitofmeasure('searchwstatus');
	  $this->serviceuom->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$this->serviceuom->attributes=$_GET['Unitofmeasure'];

      $this->servicecurrency=new Currency('searchwstatus');
	  $this->servicecurrency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->servicecurrency->attributes=$_GET['Currency'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
      $this->lookupdata();
      $model=new Prowotemplate;

      if (Yii::app()->request->isAjaxRequest)
      {
          echo CJSON::encode(array(
              'status'=>'success',
              'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
                  'projecttype'=>$this->projecttype,
                  'currency'=>$this->currency,
                  'customer'=>$this->customer,
                  'unitofmeasure'=>$this->unitofmeasure,
                  'product'=>$this->product,
                  'serviceuom'=>$this->serviceuom,
                  'servicecurrency'=>$this->servicecurrency), true)
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
				'prowotemplateid'=>$model->prowotemplateid,
				'projecttypeid'=>$model->projecttypeid,
                'protypedescription'=>($model->projecttype!==null)?$model->projecttype->description:"",
				'addressbookid'=>$model->addressbookid,
                'fullname'=>($model->customer!==null)?$model->customer->fullname:"",
              'price'=>$model->price,
              'productid'=>$model->productid,
              'productname'=>($model->product!==null)?$model->product->productname:"",
              'currencyid'=>$model->currencyid,
              'currencyname'=>($model->currency!==null)?$model->currency->currencyname:"",
              'qty'=>$model->qty,
              'unitofmeasureid'=>$model->unitofmeasureid,
              'uomcode'=>($model->unitofmeasure!==null)?$model->unitofmeasure->uomcode:"",
              'serviceprice'=>$model->serviceprice,
              'servicecurrencyid'=>$model->servicecurrencyid,
              'servicecurrencyname'=>($model->servicecurrency!==null)?$model->servicecurrency->currencyname:"",
              'serviceqty'=>$model->serviceqty,
              'serviceuomid'=>$model->serviceuomid,
              'serviceuomcode'=>($model->serviceuom!==null)?$model->serviceuom->uomcode:"",
              'contractno'=>$model->contractno,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
                    'projecttype'=>$this->projecttype,
                  'currency'=>$this->currency,
                  'customer'=>$this->customer,
                  'unitofmeasure'=>$this->unitofmeasure,
                  'product'=>$this->product,
                  'serviceuom'=>$this->serviceuom,
                  'servicecurrency'=>$this->servicecurrency), true)
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Prowotemplate'], $_POST['Prowotemplate']['prowotemplateid']);
    }

	public function actionWrite()
	{
      parent::actionWrite();
	  if(isset($_POST['Prowotemplate']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Prowotemplate']['projecttypeid'],'ppwemptyprojecttype','emptystring'),
            array($_POST['Prowotemplate']['addressbookid'],'ppwemptyaddressbook','emptystring'),
            )
        );
        if ($messages == '') {
          if ((int)$_POST['Prowotemplate']['prowotemplateid'] > 0)
          {
            $model=$this->loadModel($_POST['Prowotemplate']['prowotemplateid']);
            $model->price = $_POST['Prowotemplate']['price'];
            $model->currencyid = $_POST['Prowotemplate']['currencyid'];
            $model->addressbookid = $_POST['Prowotemplate']['addressbookid'];
            $model->qty = $_POST['Prowotemplate']['qty'];
            $model->unitofmeasureid = $_POST['Prowotemplate']['unitofmeasureid'];
            $model->productid = $_POST['Prowotemplate']['productid'];
            $model->serviceuomid = $_POST['Prowotemplate']['serviceuomid'];
            $model->serviceqty = $_POST['Prowotemplate']['serviceqty'];
            $model->serviceprice = $_POST['Prowotemplate']['serviceprice'];
            $model->servicecurrencyid = $_POST['Prowotemplate']['servicecurrencyid'];
            $model->contractno = $_POST['Prowotemplate']['contractno'];
            $model->recordstatus = $_POST['Prowotemplate']['recordstatus'];
          }
          else
          {
            $model = new Prowotemplate();
            $model->attributes=$_POST['Prowotemplate'];
          }
          try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Prowotemplate']['prowotemplateid']);
              $this->GetSMessage('scoinsertsuccess');
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
                $this->lookupdata();
    $model=new Prowotemplate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Prowotemplate']))
			$model->attributes=$_GET['Prowotemplate'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
                    'projecttype'=>$this->projecttype,
                  'currency'=>$this->currency,
                  'customer'=>$this->customer,
                  'unitofmeasure'=>$this->unitofmeasure,
            'product'=>$this->product,
                  'serviceuom'=>$this->serviceuom,
                  'servicecurrency'=>$this->servicecurrency
		));
	}
	
	public function actionUpload()
	{
      parent::actionUpload();
	  $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
	  $allowedExtensions = array("csv");
	  $sizeLimit = (int)Yii::app()->params['sizeLimit'];// maximum file size in bytes
	  $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	  $result = $uploader->handleUpload($folder,true);
	  $row = 0;
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Prowotemplate::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Prowotemplate();
			  }
			  $model->absstatusid = (int)$data[0];
			  $model->shortstat = $data[1];
			  $model->longstat = $data[2];
			  $model->isin = (int)$data[3];
			  $model->priority = (int)$data[4];
			  $model->recordstatus = (int)$data[5];
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
    $pdf->title='Prowotemplate List';
    $pdf->AddPage('L');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Prowotemplate Name','Address Name','City','Record Status');
    $model=new Prowotemplate('search');
    $dataprovider=$model->search();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    //var_dump($dataku);
    $w= array(10,15,60,100,50,20);

    $pdf->SetTableHeader();
    //Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $pdf->Ln();
    $pdf->SetTableData();
    //Data
    $fill=false;
    $i=0;
    foreach($data as $datas)
    {
        $i=$i+1;
        $pdf->Cell($w[0],6,$i,'LR',0,'L',$fill);
        $pdf->Cell($w[1],6,$datas['prowotemplateid'],'LR',0,'C',$fill);
        $pdf->Cell($w[2],6,$datas['prowotemplatename'],'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,$datas['address'],'LR',0,'L',$fill);
        $pdf->Cell($w[4],6,$datas['city'],'LR',0,'L',$fill);
        $pdf->Cell($w[5],6,$datas['recordstatus'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');


    // me-render ke browser
    $pdf->Output('prowotemplate.pdf','D');
  }

  public function actionPrint()
  {
    var_dump($_POST['id']);
    if (isset($_POST['id']))
    {
      Yii::import('application.extensions.ireport.*');
      $id=$_POST['id'];
      foreach($id as $ids)
      {
        $report = dirname(__FILE__) . '/report/' . 'prowotemplate.jrxml';
        $AReport = new IReport($report);
        $AReport->parameters = array("prowotemplateid"=>$ids);
        $AReport->execute();
      }
    }
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Prowotemplate::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='prowotemplate-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

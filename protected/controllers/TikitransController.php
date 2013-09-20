<?php

class TikitransController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  $shipcity=new City('searchwstatus');
    $shipcity->unsetAttributes();  // clear any default values
    if(isset($_GET['City']))
      $shipcity->attributes=$_GET['City'];

$shipcountry=new Country('searchwstatus');
    $shipcountry->unsetAttributes();  // clear any default values
    if(isset($_GET['Country']))
      $shipcountry->attributes=$_GET['Country'];

	  $shipprovince=new Province('searchwstatus');
    $shipprovince->unsetAttributes();  // clear any default values
    if(isset($_GET['Province']))
      $shipprovince->attributes=$_GET['Province'];

	  $rcvcity=new City('searchwstatus');
    $rcvcity->unsetAttributes();  // clear any default values
    if(isset($_GET['City']))
      $rcvcity->attributes=$_GET['City'];

$rcvcountry=new Country('searchwstatus');
    $rcvcountry->unsetAttributes();  // clear any default values
    if(isset($_GET['Country']))
      $rcvcountry->attributes=$_GET['Country'];

	  $rcvprovince=new Province('searchwstatus');
    $rcvprovince->unsetAttributes();  // clear any default values
    if(isset($_GET['Province']))
      $rcvprovince->attributes=$_GET['Province'];

	  $paymentmethod=new Paymentmethod('searchwstatus');
    $paymentmethod->unsetAttributes();  // clear any default values
    if(isset($_GET['Paymentmethod']))
      $paymentmethod->attributes=$_GET['Paymentmethod'];

		$model=new Tikitrans;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
  'shipcity'=>$shipcity,
  'shipcountry'=>$shipcountry,
  'shipprovince'=>$shipprovince,
  'rcvcity'=>$rcvcity,
  'rcvcountry'=>$rcvcountry,
  'rcvprovince'=>$rcvprovince,
  'paymentmethod'=>$paymentmethod), true)
				));
            Yii::app()->end();
        }
        else
		{
		$this->render('create',array(
			'model'=>$model,
  'shipcity'=>$shipcity,
  'shipcountry'=>$shipcountry,
  'shipprovince'=>$shipprovince,
  'rcvcity'=>$rcvcity,
  'rcvcountry'=>$rcvcountry,
  'rcvprovince'=>$rcvprovince,
  'paymentmethod'=>$paymentmethod
		));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
	  $shipcity=new City('searchwstatus');
    $shipcity->unsetAttributes();  // clear any default values
    if(isset($_GET['City']))
      $shipcity->attributes=$_GET['City'];

$shipcountry=new Country('searchwstatus');
    $shipcountry->unsetAttributes();  // clear any default values
    if(isset($_GET['Country']))
      $shipcountry->attributes=$_GET['Country'];

	  $shipprovince=new Province('searchwstatus');
    $shipprovince->unsetAttributes();  // clear any default values
    if(isset($_GET['Province']))
      $shipprovince->attributes=$_GET['Province'];

	  $rcvcity=new City('searchwstatus');
    $rcvcity->unsetAttributes();  // clear any default values
    if(isset($_GET['City']))
      $rcvcity->attributes=$_GET['City'];

$rcvcountry=new Country('searchwstatus');
    $rcvcountry->unsetAttributes();  // clear any default values
    if(isset($_GET['Country']))
      $rcvcountry->attributes=$_GET['Country'];

	  $rcvprovince=new Province('searchwstatus');
    $rcvprovince->unsetAttributes();  // clear any default values
    if(isset($_GET['Province']))
      $rcvprovince->attributes=$_GET['Province'];

	  $paymentmethod=new Paymentmethod('searchwstatus');
    $paymentmethod->unsetAttributes();  // clear any default values
    if(isset($_GET['Paymentmethod']))
      $paymentmethod->attributes=$_GET['Paymentmethod'];
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

	  //$this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure',
				'airwaybillno'=>$model->airwaybillno,
				'transdate'=>$model->transdate,
				'shipcompany'=>$model->shipcompany,
				'shipaddress'=>$model->shipaddress,
				'shipcityid'=>$model->shipcityid,
				'shipcityname'=>$model->shipcity->cityname,
				'shipprovinceid'=>$model->shipprovinceid,
				'shipprovincename'=>$model->shipprovince->provincename,
				'shipzipcode'=>$model->shipzipcode,
				'shipname'=>$model->shipname,
				'shipcountryid'=>$model->shipcountryid,
				'shipcountryname'=>$model->shipcountry->countryname,
				'shiptelno'=>$model->shiptelno,
				'descofship'=>$model->descofship,
				'deliveryinst'=>$model->deliveryinst,
				'paymentmethodid'=>$model->paymentmethodid,
				'paymentname'=>$model->paymentmethod->paymentname,
				'charges'=>$model->charges,
				'rcvcompany'=>$model->rcvcompany,
				'rcvaddress'=>$model->rcvaddress,
				'rcvcityid'=>$model->rcvcityid,
				'rcvcityname'=>$model->rcvcity->cityname,
				'rcvprovinceid'=>$model->rcvprovinceid,
				'rcvprovincename'=>$model->rcvprovince->provincename,
				'rcvcountryid'=>$model->rcvcountryid,
				'rcvcountryname'=>$model->rcvcountry->countryname,
				'rcvtelno'=>$model->rcvtelno,
				'rcvattention'=>$model->rcvattention,
				'rcvzipcode'=>$model->rcvzipcode,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
  'shipcity'=>$shipcity,
  'shipcountry'=>$shipcountry,
  'shipprovince'=>$shipprovince,
  'rcvcity'=>$rcvcity,
  'rcvcountry'=>$rcvcountry,
  'rcvprovince'=>$rcvprovince,
  'paymentmethod'=>$paymentmethod), true)
				));
            Yii::app()->end();
        }
        else
		{
		$this->render('update',array(
			'model'=>$model,
  'shipcity'=>$shipcity,
  'shipcountry'=>$shipcountry,
  'shipprovince'=>$shipprovince,
  'rcvcity'=>$rcvcity,
  'rcvcountry'=>$rcvcountry,
  'rcvprovince'=>$rcvprovince,
  'paymentmethod'=>$paymentmethod
		));
		}
	}

	public function actionWrite()
	{
	  if(isset($_POST['Tikitrans']))
	  {
		$dataku->attributes=$_POST['Tikitrans'];
		if ((int)$dataku->attributes['airwaybillno'] > 0)
		{
		  $model=$this->loadModel($dataku->attributes['airwaybillno']);
		  $model->shipcompany = $dataku->attributes['shipcompany'];
		  $model->shipaddress = $dataku->attributes['shipaddress'];
		  $model->shipcityid = $dataku->attributes['shipcityid'];
		  $model->shipprovinceid = $dataku->attributes['shipprovinceid'];
		  $model->shipzipcode = $dataku->attributes['shipzipcode'];
		  $model->shipname = $dataku->attributes['shipname'];
		  $model->shipcountryid = $dataku->attributes['shipcountryid'];
		  $model->shiptelno = $dataku->attributes['shiptelno'];
		  $model->descofship = $dataku->attributes['descofship'];
		  $model->deliveryinst = $dataku->attributes['deliveryinst'];
		  $model->paymentmethodid = $dataku->attributes['paymentmethodid'];
		  $model->charges = $dataku->attributes['charges'];
		  $model->rcvcompany = $dataku->attributes['rcvcompany'];
		  $model->rcvaddress = $dataku->attributes['rcvaddress'];
		  $model->rcvcityid = $dataku->attributes['rcvcityid'];
		  $model->rcvprovinceid = $dataku->attributes['rcvprovinceid'];
		  $model->rcvcountryid = $dataku->attributes['rcvcountryid'];
		  $model->rcvtelno = $dataku->attributes['rcvtelno'];
		  $model->rcvattention = $dataku->attributes['rcvattention'];
		  $model->rcvzipcode = $dataku->attributes['rcvzipcode'];
		  $model->recordstatus = $dataku->attributes['recordstatus'];
		}
		else
		{
		  $model = new Tikitrans();
		  $model->attributes=$_POST['Tikitrans'];
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
			  else
			  {
				Yii::app()->user->setflash($id, array('title' => 'Success', 'content' => 'Data Saved') );
				$this->redirect(array('index'));
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
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
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
	  $shipcity=new City('searchwstatus');
    $shipcity->unsetAttributes();  // clear any default values
    if(isset($_GET['City']))
      $shipcity->attributes=$_GET['City'];

$shipcountry=new Country('searchwstatus');
    $shipcountry->unsetAttributes();  // clear any default values
    if(isset($_GET['Country']))
      $shipcountry->attributes=$_GET['Country'];

	  $shipprovince=new Province('searchwstatus');
    $shipprovince->unsetAttributes();  // clear any default values
    if(isset($_GET['Province']))
      $shipprovince->attributes=$_GET['Province'];

	  $rcvcity=new City('searchwstatus');
    $rcvcity->unsetAttributes();  // clear any default values
    if(isset($_GET['City']))
      $rcvcity->attributes=$_GET['City'];

$rcvcountry=new Country('searchwstatus');
    $rcvcountry->unsetAttributes();  // clear any default values
    if(isset($_GET['Country']))
      $rcvcountry->attributes=$_GET['Country'];

	  $rcvprovince=new Province('searchwstatus');
    $rcvprovince->unsetAttributes();  // clear any default values
    if(isset($_GET['Province']))
      $rcvprovince->attributes=$_GET['Province'];

	  $paymentmethod=new Paymentmethod('searchwstatus');
    $paymentmethod->unsetAttributes();  // clear any default values
    if(isset($_GET['Paymentmethod']))
      $paymentmethod->attributes=$_GET['Paymentmethod'];
		$model=new Tikitrans('searchwstatus');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tikitrans']))
			$model->attributes=$_GET['Tikitrans'];
			if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
  'shipcity'=>$shipcity,
  'shipcountry'=>$shipcountry,
  'shipprovince'=>$shipprovince,
  'rcvcity'=>$rcvcity,
  'rcvcountry'=>$rcvcountry,
  'rcvprovince'=>$rcvprovince,
  'paymentmethod'=>$paymentmethod
		));
	}

public function actionDownload()
  {
    Yii::import('application.extensions.fpdf.*');
    require_once("pdf.php");
    $pdf = new PDF();
	$pdf->isheader = false;
    $pdf->title='TIKI Transaction List';
    // definisi font
    $pdf->setFont('Arial','',8);
	$model=new Tikitrans('search');
	$model->unsetAttributes();
	if(isset($_GET['Tikitrans']))
			$model->attributes=$_GET['Tikitrans'];
	$dataprovider=$model->search();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();

    //Data
    $fill=false;
    foreach($data as $datas)
    {
		$pdf->AddPage('L');
		$pdf->Text(5,5,$datas['transdate']);
        $fill=!$fill;
    }

    // me-render ke browser
    $pdf->Output('applicanteducation.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Tikitrans::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tikitrans-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

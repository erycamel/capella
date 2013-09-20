<?php

class ProductpurchaseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'productpurchase';

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
	  $product=new Product('searchwstatus');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$plant=new Plant('searchwstatus');
	  $plant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Plant']))
		$plant->attributes=$_GET['Plant'];

		$orderunit=new Unitofmeasure('searchwstatus');
	  $orderunit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$orderunit->attributes=$_GET['Unitofmeasure'];

		$purchasinggroup=new Purchasinggroup('searchwstatus');
	  $purchasinggroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasinggroup']))
		$purchasinggroup->attributes=$_GET['Purchasinggroup'];
		
		$model=new Productpurchase;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'product'=>$product,
				  'plant'=>$plant,
				  'orderunit'=>$orderunit,
				  'purchasinggroup'=>$purchasinggroup), true)
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
	  $product=new Product('searchwstatus');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$plant=new Plant('searchwstatus');
	  $plant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Plant']))
		$plant->attributes=$_GET['Plant'];

		$orderunit=new Unitofmeasure('searchwstatus');
	  $orderunit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$orderunit->attributes=$_GET['Unitofmeasure'];

		$purchasinggroup=new Purchasinggroup('searchwstatus');
	  $purchasinggroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasinggroup']))
		$purchasinggroup->attributes=$_GET['Purchasinggroup'];
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
 if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'productpurchaseid'=>$model->productpurchaseid,
				'productid'=>$model->productid,
				'productname'=>($model->product!==null)?$model->product->productname:"",
				'plantid'=>$model->plantid,
				'plantcode'=>$model->plant->plantcode,
				'orderunit'=>$model->orderunit,
				'orderuomcode'=>($model->orderunit0!==null)?$model->orderunit0->uomcode:"",
				'purchasinggroupid'=>$model->purchasinggroupid,
				'purchasinggroupcode'=>($model->purchasinggroup!==null)?$model->purchasinggroup->purchasinggroupcode:"",
				'isautoPO'=>$model->isautoPO,
				'validfrom'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->validfrom)),
				'validto'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->validto)),
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'product'=>$product,
				  'plant'=>$plant,
				  'orderunit'=>$orderunit,
				  'purchasinggroup'=>$purchasinggroup), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Productpurchase'], $_POST['Productpurchase']['productpurchaseid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Productpurchase']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Productpurchase']['productid'],'mmpremptyproductid','emptystring'),
                array($_POST['Productpurchase']['plantid'],'mmpremptyplantid','emptystring'),
                array($_POST['Productpurchase']['orderunit'],'mmpremptyorderunit','emptystring'),
                array($_POST['Productpurchase']['purchasinggroupid'],'mmpremptypurchasinggroupid','emptystring'),
                array($_POST['Productpurchase']['validfrom'],'mmpremptyvalidfrom','emptystring'),
                array($_POST['Productpurchase']['validto'],'mmpremptyvalidto','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Productpurchase'];
		if ((int)$_POST['Productpurchase']['productpurchaseid'] > 0)
		{
		  $model=$this->loadModel($_POST['Productpurchase']['productpurchaseid']);
		  $model->productid = $_POST['Productpurchase']['productid'];
		  $model->plantid = $_POST['Productpurchase']['plantid'];
		  $model->orderunit = $_POST['Productpurchase']['orderunit'];
		  $model->purchasinggroupid = $_POST['Productpurchase']['purchasinggroupid'];
		  $model->validfrom = $_POST['Productpurchase']['validfrom'];
		  $model->validto = $_POST['Productpurchase']['validto'];
		  $model->isautoPO = $_POST['Productpurchase']['isautoPO'];
		}
		else
		{
		  $model = new Productpurchase();
		  $model->attributes=$_POST['Productpurchase'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Productpurchase']['productpurchaseid']);
              $this->GetSMessage('mmprinsertsuccess');
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
		  $model->delete();
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
	  $product=new Product('searchwstatus');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$plant=new Plant('searchwstatus');
	  $plant->unsetAttributes();  // clear any default values
	  if(isset($_GET['Plant']))
		$plant->attributes=$_GET['Plant'];

		$orderunit=new Unitofmeasure('searchwstatus');
	  $orderunit->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$orderunit->attributes=$_GET['Unitofmeasure'];

		$purchasinggroup=new Purchasinggroup('searchwstatus');
	  $purchasinggroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasinggroup']))
		$purchasinggroup->attributes=$_GET['Purchasinggroup'];
		$model=new Productpurchase('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productpurchase']))
			$model->attributes=$_GET['Productpurchase'];
			if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }

		$this->render('index',array(
			'model'=>$model,
				  'product'=>$product,
				  'plant'=>$plant,
				  'orderunit'=>$orderunit,
				  'purchasinggroup'=>$purchasinggroup
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
			  $model=Productpurchase::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Productpurchase();
			  }
			  $model->productpurchaseid = (int)$data[0];
			  $model->productid = $data[1];
			  $model->plantid = $data[2];
			  $model->orderunit = (int)$data[3];
			  $model->purchasinggroupid = (int)$data[4];
			  $model->validfrom = $data[5];
			  $model->validto = $data[6];
			  $model->isautoPO = (int)$data[7];
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
    $sql = "select c.productname,b.plantcode,d.uomcode as orderunit,e.purchasinggroupcode,
      a.validfrom,a.validto
      from productpurchase a
      left join plant b on b.plantid = a.plantid
      left join product c on c.productid = a.productid
      left join unitofmeasure d on d.unitofmeasureid = a.orderunit
      left join purchasinggroup e on e.purchasinggroupid = a.purchasinggroupid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.productpurchaseid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->title='Product Purchase List';
	  $this->pdf->AddPage('P');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    $this->pdf->colalign = array('C','C','C','C','C','C');
    $this->pdf->setwidths(array(80,15,15,30,25,25));
	$this->pdf->colheader = array('Product','Plant','Order Unit','Purchasing Group','Valid From','Valid To');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L','L','L','L','L');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['productname'],$row1['plantcode'],$row1['orderunit']
          ,$row1['purchasinggroupcode'],
		  date(Yii::app()->params["dateviewfromdb"], strtotime($row1['validfrom'])),
		  date(Yii::app()->params["dateviewfromdb"], strtotime($row1['validto']))));
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
		$model=Productpurchase::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productpurchase-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

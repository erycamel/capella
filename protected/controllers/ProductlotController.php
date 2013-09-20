<?php

class ProductlotController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'productlot';

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
		$model=new Productlot;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'product'=>$product), true)
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
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'productlotid'=>$model->productlotid,
				'productid'=>$model->productid,
				'productname'=>$model->product->productname,
				'lotno'=>$model->lotno,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'product'=>$product), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Productlot'], $_POST['Productlot']['productlotid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Productlot']))
	  {
		//$dataku->attributes=$_POST['Productlot'];
		if ((int)$_POST['Productlot'] > 0)
		{
		  $connection=Yii::app()->db;
		  $transaction=$connection->beginTransaction();
		  try
		  {
				$sql = 'call UpdateProductLot(:vproductlotid,:vproductid,
:vlotno, :vstartdate, :vdsled, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindParam(':vproductlotid',$_POST['Productlot']['productlotid'],PDO::PARAM_INT);
				$command->bindParam(':vproductid',$_POST['Productlot']['productid'],PDO::PARAM_INT);
				$command->bindParam(':vlotno',$_POST['Productlot']['lotno'],PDO::PARAM_STR);
				$command->bindParam(':vstartdate',$_POST['Productlot']['startdate'],PDO::PARAM_STR);
				$command->bindParam(':vlastupdateby', Yii::app()->user->name,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Productlot']['productlotid']);
				$this->GetSMessage('mmplinsertsuccess');
		  }
		  catch(Exception $e) // an exception is raised if a query fails
		  {
			$transaction->rollBack();
			$this->GetMessage($e->getMessage());
		  }
		}
		else
		{
		  $model = new Productlot();
		  $model->attributes=$_POST['Productlot'];
		  $connection=Yii::app()->db;
		  $transaction=$connection->beginTransaction();
		  try
		  {
				$sql = 'call InsertProductLot(:vproductid,
				  :vlotno, :vstartdate, :vcreatedby)';
				$command=$connection->createCommand($sql);
				$command->bindParam(':vproductid',$model->productid,PDO::PARAM_INT);
				$command->bindParam(':vlotno',$model->lotno,PDO::PARAM_STR);
				$command->bindParam(':vstartdate',$model->startdate,PDO::PARAM_STR);
				$command->bindParam(':vcreatedby', Yii::app()->user->name,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
              $this->DeleteLock($this->menuname, $_POST['Productlot']['productlotid']);
				$this->GetSMessage('mmplinsertsuccess');
		  }
		  catch(Exception $e) // an exception is raised if a query fails
		  {
			$transaction->rollBack();
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
	  $product=new Product('searchwstatus');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];
		$model=new Productlot('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productlot']))
			$model->attributes=$_GET['Productlot'];
if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('index',array(
			'model'=>$model,
			'product'=>$product
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
			  $model=Productlot::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Productlot();
			  }
			  $model->productconversionid = (int)$data[0];
			  $model->productid = $data[1];
			  $model->fromuom = $data[2];
			  $model->fromvalue = $data[3];
			  $model->touom = $data[4];
			  $model->tovalue = $data[5];
			  $model->recordstatus = (int)$data[6];
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
    $pdf->title='Product Conversion List';
    $pdf->AddPage('P');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Material Name','From UOM','From Value','To UOM','To Value');
    $model=new Productconversion('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($dataku);
    $w= array(10,15,50,40,40,40,40);

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
        $pdf->Cell($w[1],6,$datas['productconversionid'],'LR',0,'L',$fill);
        $pdf->Cell($w[2],6,Product::model()->findbypk($datas['productid']),'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,$datas['fromuom'],'LR',0,'L',$fill);
        $pdf->Cell($w[4],6,$datas['fromvalue'],'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,$datas['touom'],'LR',0,'L',$fill);
        $pdf->Cell($w[4],6,$datas['tovalue'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');
    // me-render ke browser
    $pdf->Output('productconversion.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Productlot::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productlot-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

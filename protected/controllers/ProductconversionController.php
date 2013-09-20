<?php

class ProductconversionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'productconversion';

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

	public $product,$fromuom,$touom;

	public function lookupdata()
	{
	  $this->product=new Product('searchwstatus');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

		$this->fromuom=new Unitofmeasure('searchwstatus');
	  $this->fromuom->unsetAttributes();  // clear any default values
	  if(isset($_GET['Fromuom']))
		$this->fromuom->attributes=$_GET['Fromuom'];

		$this->touom=new Unitofmeasure('searchwstatus');
	  $this->touom->unsetAttributes();  // clear any default values
	  if(isset($_GET['Touom']))
		$this->touom->attributes=$_GET['Touom'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();

		$model=new Productconversion;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'product'=>$this->product,
				  'fromuom'=>$this->fromuom,
				  'touom'=>$this->touom), true)
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
				'productconversionid'=>$model->productconversionid,
				'productid'=>$model->productid,
				'productname'=>($model->product!==null)?$model->product->productname:"",
				'fromuom'=>$model->fromuom,
				'fromuomcode'=>($model->fromuom0!==null)?$model->fromuom0->uomcode:"",
				'fromvalue'=>$model->fromvalue,
				'touom'=>$model->touom,
				'tovalue'=>$model->tovalue,
				'touomcode'=>($model->touom0!==null)?$model->touom0->uomcode:"",
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'product'=>$this->product,
				  'fromuom'=>$this->fromuom,
				  'touom'=>$this->touom), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Productconversion'], $_POST['Productconversion']['productconversionid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Productconversion']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Productconversion']['productid'],'mmpcemptyproductid','emptystring'),
                array($_POST['Productconversion']['fromuom'],'mmpcemptyfromuom','emptystring'),
                array($_POST['Productconversion']['fromvalue'],'mmpcemptyfromvalue','emptystring'),
                array($_POST['Productconversion']['touom'],'mmpcemptytouom','emptystring'),
                array($_POST['Productconversion']['tovalue'],'mmpcemptytovalue','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Productconversion']['productconversionid'] > 0)
		{
		  $model=$this->loadModel($_POST['Productconversion']['productconversionid']);
		  $model->productid = $_POST['Productconversion']['productid'];
		  $model->fromuom = $_POST['Productconversion']['fromuom'];
		  $model->fromvalue = $_POST['Productconversion']['fromvalue'];
		  $model->touom = $_POST['Productconversion']['touom'];
		  $model->tovalue = $_POST['Productconversion']['tovalue'];
		}
		else
		{
		  $model = new Productconversion();
		  $model->attributes=$_POST['Productconversion'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Productconversion']['productconversionid']);
              $this->GetSMessage('mmpcinsertsuccess');
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
	  $this->lookupdata();
		$model=new Productconversion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productconversion']))
			$model->attributes=$_GET['Productconversion'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
				  'product'=>$this->product,
				  'fromuom'=>$this->fromuom,
				  'touom'=>$this->touom
		));
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
			  $model=Productconversion::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Productconversion();
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
						  echo $model->getErrors();
						}
					  }
					  catch (Exception $e)
					  {
						echo $e->getMessage();;
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
    $sql = "select d.productname, b.uomcode as fromuom, a.fromvalue, c.uomcode as touom,a.tovalue
        from productconversion a
        left join unitofmeasure b on b.unitofmeasureid = a.fromuom
        left join unitofmeasure c on c.unitofmeasureid = a.touom
        left join product d on d.productid = a.productid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.productconversionid = ".$_GET['id'];
		}
		$sql=$sql . " order by a.productid ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

	  $this->pdf->title='Product Conversion List';
	  $this->pdf->AddPage('P');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    $this->pdf->colalign = array('C','C','C','C','C');
    $this->pdf->setwidths(array(70,30,30,30,30));
	$this->pdf->colheader= array('Material Name','From UOM','From Value','To UOM','To Value');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L','L','L','L');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['productname'],$row1['fromuom'],$row1['fromvalue'],$row1['touom'],$row1['tovalue']));
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
		$model=Productconversion::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productconversion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

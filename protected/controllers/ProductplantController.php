<?php

class ProductplantController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'productplant';

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

	$snro=new Snro('searchwstatus');
	  $snro->unsetAttributes();  // clear any default values
	  if(isset($_GET['Snro']))
		$snro->attributes=$_GET['Snro'];

	  $sloc=new Sloc('searchwstatus');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$unitofissue=new Unitofmeasure('searchwstatus');
	  $unitofissue->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofissue->attributes=$_GET['Unitofmeasure'];

		$model=new Productplant;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'product'=>$product,
				  'sloc'=>$sloc,
				  'unitofissue'=>$unitofissue,
				'snro'=>$snro), true)
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

		$snro=new Snro('searchwstatus');
	  $snro->unsetAttributes();  // clear any default values
	  if(isset($_GET['Snro']))
		$snro->attributes=$_GET['Snro'];

	  $sloc=new Sloc('searchwstatus');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$unitofissue=new Unitofmeasure('searchwstatus');
	  $unitofissue->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofissue->attributes=$_GET['Unitofmeasure'];

		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'productplantid'=>$model->productplantid,
				'productid'=>$model->productid,
				'productname'=>($model->product!==null)?$model->product->productname:"",
				'slocid'=>$model->slocid,
				'sloccode'=>($model->sloc!==null)?$model->sloc->description:"",
				'isautolot'=>$model->isautolot,
				'unitofissue'=>$model->unitofissue,
				'unitofissueuomcode'=>($model->unitofissue0!==null)?$model->unitofissue0->uomcode:"",
				'storagebin'=>$model->storagebin,
				'pickingarea'=>$model->pickingarea,
				'sled'=>$model->sled,
				'snroid'=>$model->snroid,
				'description'=>($model->snro!==null)?$model->snro->description:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'product'=>$product,
				  'sloc'=>$sloc,
				  'unitofissue'=>$unitofissue,
				'snro'=>$snro), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Productplant'], $_POST['Productplant']['productplantid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Productplant']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Productplant']['productid'],'mmplemptyproductid','emptystring'),
                array($_POST['Productplant']['slocid'],'mmplemptyslocid','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Productplant'];
		if ((int)$_POST['Productplant']['productplantid'] > 0)
		{
		  $model=$this->loadModel($_POST['Productplant']['productplantid']);
		  $model->productid = $_POST['Productplant']['productid'];
		  $model->slocid = $_POST['Productplant']['slocid'];
		  $model->unitofissue = $_POST['Productplant']['unitofissue'];
		  $model->isautolot = $_POST['Productplant']['isautolot'];
		  $model->recordstatus = $_POST['Productplant']['recordstatus'];
		  $model->snroid = $_POST['Productplant']['snroid'];
		}
		else
		{
		  $model = new Productplant();
		  $model->attributes=$_POST['Productplant'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Productplant']['productplantid']);
              $this->GetSMessage('mmplinsertsuccess');
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
	  $product=new Product('searchwstatus');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$snro=new Snro('searchwstatus');
	  $snro->unsetAttributes();  // clear any default values
	  if(isset($_GET['Snro']))
		$snro->attributes=$_GET['Snro'];

	  $sloc=new Sloc('searchwstatus');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$unitofissue=new Unitofmeasure('searchwstatus');
	  $unitofissue->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofissue->attributes=$_GET['Unitofmeasure'];

		$model=new Productplant('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productplant']))
			$model->attributes=$_GET['Productplant'];
		if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
				  'product'=>$product,
				  'sloc'=>$sloc,
				  'unitofissue'=>$unitofissue,
				  'snro'=>$snro
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
			  $model=Productplant::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Productplant();
			  }
			  $model->productplantid = (int)$data[0];
			  $model->productid = $data[1];
			  $model->slocid = (int)$data[2];
			  $model->unitofissue = (int)$data[3];
			  $model->isautolot = (int)$data[4];
			  $model->storagebin = $data[5];
			  $model->pickingarea = (int)$data[6];
			  $model->sled = (int)$data[7];
			  $model->snroid = (int)$data[8];
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
    $sql = "select b.productname, c.sloccode, d.uomcode as unitofissue, a.isautolot,
        a.storagebin,a.pickingarea,a.sled,e.formatdoc
      from productplant a
      left join product b on b.productid = a.productid
      left join sloc c on c.slocid = a.slocid
      left join unitofmeasure d on d.unitofmeasureid = a.unitofissue
      left join snro e on e.snroid = a.snroid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.productplantid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
    $this->pdf->title='Material Master - Plant Storage List';
    $this->pdf->AddPage('P');
    // definisi font
    $this->pdf->setFont('Arial','B',8);

    $this->pdf->colalign = array('C','C','C','C','C','C','C','C');
    $this->pdf->setwidths(array(50,20,10,20,20,20,20,30));
	$this->pdf->colheader = array('Material Name','Sloc','Unit','Is Autolot',
	   'Storage','Picking','SLED','SNRO');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','C','C','C','L','L','L','L');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['productname'],$row1['sloccode'],$row1['unitofissue'],
          ($row1['isautolot'] == 1)?'V':'',
		  $row1['storagebin'],$row1['pickingarea'],$row1['sled'],$row1['formatdoc']));
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
		$model=Productplant::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='productplant-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class DoheaderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'doheader';

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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $dodetail=new Dodetail('search');
	  $dodetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Dodetail']))
		$dodetail->attributes=$_GET['Dodetail'];

		$customer=new Customer('search');
	  $customer->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$customer->attributes=$_GET['Customer'];

		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

          $soheader=new Soheader('search');
	  $soheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Soheader']))
		$soheader->attributes=$_GET['Soheader'];

      $project=new Project('search');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];

		$model=new Doheader;
		$model->recordstatus=0;
		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'doheaderid'=>$model->doheaderid,
				  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
					'dodetail'=>$dodetail,
					'customer'=>$customer,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
                                      'soheader'=>$soheader,
                      'project'=>$project), true)
				  ));
			  Yii::app()->end();
			}
        }
	}

	public function actionCreatedetail()
	{
	  $product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$dodetail=new Dodetail;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formdetail',
				  array('model'=>$dodetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure), true)
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
	   $dodetail=new Dodetail('search');
	  $dodetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Dodetail']))
		$dodetail->attributes=$_GET['Dodetail'];

		$customer=new Customer('search');
	  $customer->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$customer->attributes=$_GET['Customer'];

		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

          $soheader=new Soheader('search');
	  $soheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Soheader']))
		$soheader->attributes=$_GET['Soheader'];

                $project=new Project('search');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];

		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'doheaderid'=>$model->doheaderid,
				'dono'=>$model->dono,
				'dodate'=>$model->dodate,
				'postdate'=>$model->postdate,
                'soheaderid'=>$model->soheaderid,
                'sono'=>($model->soheader!==null)?$model->soheader->sono:"",
                'projectid'=>$model->projectid,
                'projectno'=>($model->project!==null)?$model->project->projectno:"",
				'addressbookid'=>$model->addressbookid,
				'fullname'=>($model->customer!==null)?$model->customer->fullname:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
					'dodetail'=>$dodetail,
					'customer'=>$customer,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
                                      'soheader'=>$soheader,
                    'project'=>$project), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
	  	  $product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$id=$_POST['id'];
	  $dodetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'dodetailid'=>$dodetail->dodetailid,
				'productid'=>($dodetail->product!==null)?$dodetail->product->productid:"",
				'productname'=>($dodetail->product!==null)?$dodetail->product->productname:"",
				'unitofmeasureid'=>$dodetail->unitofmeasureid,
				'uomcode'=>($dodetail->unitofmeasure!==null)?$dodetail->unitofmeasure->uomcode:"",
				'qty'=>$dodetail->qty,
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$dodetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Doheader'], $_POST['Doheader']['doheaderid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Doheader']))
	  {
		if ((int)$_POST['Doheader']['doheaderid'] > 0)
		{
		  $model=$this->loadModel($_POST['Doheader']['doheaderid']);
		  $model->addressbookid = $_POST['Doheader']['addressbookid'];
		  $model->soheaderid = $_POST['Doheader']['soheaderid'];
		  $model->projectid = $_POST['Doheader']['projectid'];
		  $model->recordstatus = $_POST['Doheader']['recordstatus'];
		}
		else
		{
		  $model = new Doheader();
		  $model->attributes=$_POST['Doheader'];
		}
		  try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Doheader']['doheaderid']);
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

        public function actionGeneratedetail()
        {
            if(isset($_POST['id']) & isset($_POST['hid']))
	  {
                                $data = Soheader::model()->findbypk($_POST['id']);
              $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call GenerateDOSO(:vid, :vhid)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
				$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
                                            'customername'=> ($data->customer!==null)?$data->customer->fullname:"",
					  'div'=>"Data generated"
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

	public function actionWritedetail()
	{
	  if(isset($_POST['Dodetail']))
	  {
		if ((int)$_POST['Dodetail']['dodetailid'] > 0)
		{
		  $model=Dodetail::model()->findbyPK($_POST['Dodetail']['dodetailid']);
		  $model->doheaderid = $_POST['Dodetail']['doheaderid'];
		  $model->productid = $_POST['Dodetail']['productid'];
		  $model->unitofmeasureid = $_POST['Dodetail']['unitofmeasureid'];
		  $model->qty = $_POST['Dodetail']['qty'];
		}
		else
		{
		  $model = new Dodetail();
		  $model->attributes=$_POST['Dodetail'];
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
		  $model=Dodetail::model()->findbyPK($ids);
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
				$sql = 'call ApproveDO(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindValue(':vid',$model->doheaderid,PDO::PARAM_INT);
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
	  $dodetail=new Dodetail('search');
	  $dodetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Dodetail']))
		$dodetail->attributes=$_GET['Dodetail'];

		$customer=new Customer('search');
	  $customer->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$customer->attributes=$_GET['Customer'];

		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

          $soheader=new Soheader('search');
	  $soheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Soheader']))
		$soheader->attributes=$_GET['Soheader'];

		$model=new Doheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Doheader']))
			$model->attributes=$_GET['Doheader'];

        $project=new Project('search');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
					'dodetail'=>$dodetail,
					'customer'=>$customer,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'soheader'=>$soheader,
            'project'=>$project
		));
	}

	public function actionIndexdetail()
	{
	  $product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

	  $dodetail=new Dodetail('search');
	  $dodetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Dodetail']))
		$dodetail->attributes=$_GET['Dodetail'];

	  $this->renderPartial('indexdetail',
		array('dodetail'=>$dodetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure));
	  Yii::app()->end();
	}

	public function actionDownload()
  {
	parent::actionDownload();
    Yii::import('application.extensions.fpdf.*');
    require_once("pdf.php");
    $pdf = new PDF();
    $pdf->title='Delivery Order List';
    $pdf->AddPage('L');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Schedule Name','Absence In','Absence Out', 'Status', 'Wage Name', 'Currency', 'Insentif');
    $dataprovider=Doheader::model()->searchwstatus();
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
		$model=Doheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Dodetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='doheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='dodetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

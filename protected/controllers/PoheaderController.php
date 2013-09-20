<?php

class PoheaderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'poheader';

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
	  $purchasingorg=new Purchasingorg('search');
	  $purchasingorg->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasingorg']))
		$purchasingorg->attributes=$_GET['Purchasingorg'];

		$purchasinggroup=new Purchasinggroup('search');
	  $purchasinggroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasinggroup']))
		$purchasinggroup->attributes=$_GET['Purchasinggroup'];

		$supplier=new Supplier('search');
	  $supplier->unsetAttributes();  // clear any default values
	  if(isset($_GET['Supplier']))
		$supplier->attributes=$_GET['Supplier'];

      $paymentmethod=new Paymentmethod('search');
	  $paymentmethod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Paymentmethod']))
		$paymentmethod->attributes=$_GET['Paymentmethod'];

		$podetail=new Podetail('search');
	  $podetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Podetail']))
		$podetail->attributes=$_GET['Podetail'];

		$prheader=new Prmaterial('search');
	  $prheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$prheader->attributes=$_GET['Prmaterial'];
		
		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$currency=new Currency('search');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

		$sloc=new Sloc('search');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$tax=new Tax('search');
	  $tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$tax->attributes=$_GET['Tax'];

		$model=new Poheader;
		$model->recordstatus=Wfgroup::model()->findstatusbyuser('inspo');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'poheaderid'=>$model->poheaderid,
				  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'purchasingorg'=>$purchasingorg,
				  'purchasinggroup'=>$purchasinggroup,
                      'paymentmethod'=>$paymentmethod,
				  'supplier'=>$supplier,
				  'podetail'=>$podetail,
				  'prheader'=>$prheader,
				  'product'=>$product,
				  'unitofmeasure'=>$unitofmeasure,
				  'currency'=>$currency,
				  'sloc'=>$sloc,
				  'tax'=>$tax), true)
				  ));
			  Yii::app()->end();
			}
        }
	}

	public function actionCreatedetail()
	{
	  $prheader=new Prmaterial('search');
	  $prheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$prheader->attributes=$_GET['Prmaterial'];
		
		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$currency=new Currency('search');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

		$sloc=new Sloc('search');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$tax=new Tax('search');
	  $tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$tax->attributes=$_GET['Tax'];

		$podetail=new Podetail;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'currencyid'=>Company::model()->getcurrencyid(),
				'currencyname'=>Company::model()->getcurrencyname(),
                'divcreate'=>$this->renderPartial('_formdetail',
				  array('model'=>$podetail,
				  'prheader'=>$prheader,
			'product'=>$product,
			'unitofmeasure'=>$unitofmeasure,
			'currency'=>$currency,
			'sloc'=>$sloc,
			'tax'=>$tax), true)
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
	  $purchasingorg=new Purchasingorg('search');
	  $purchasingorg->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasingorg']))
		$purchasingorg->attributes=$_GET['Purchasingorg'];

		$purchasinggroup=new Purchasinggroup('search');
	  $purchasinggroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasinggroup']))
		$purchasinggroup->attributes=$_GET['Purchasinggroup'];

		$supplier=new Supplier('search');
	  $supplier->unsetAttributes();  // clear any default values
	  if(isset($_GET['Supplier']))
		$supplier->attributes=$_GET['Supplier'];

      $paymentmethod=new Paymentmethod('search');
	  $paymentmethod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Paymentmethod']))
		$paymentmethod->attributes=$_GET['Paymentmethod'];

		$podetail=new Podetail('search');
	  $podetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Podetail']))
		$podetail->attributes=$_GET['Podetail'];

		$prheader=new Prmaterial('search');
	  $prheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$prheader->attributes=$_GET['Prmaterial'];
		
		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$currency=new Currency('search');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

		$sloc=new Sloc('search');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$tax=new Tax('search');
	  $tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$tax->attributes=$_GET['Tax'];
		$id=$_POST['id'];
		$model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'poheaderid'=>$model->poheaderid,
				'purchasinggroupid'=>$model->purchasinggroupid,
				'purchasinggroupcode'=>($model->purchasinggroup!==null)?$model->purchasinggroup->description:"",
				'docdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->docdate)),
				'addressbookid'=>$model->addressbookid,
				'fullname'=>($model->supplier!==null)?$model->supplier->fullname:"",
				'paymentmethodid'=>$model->paymentmethodid,
				'paycode'=>($model->paymentmethod!==null)?$model->paymentmethod->paycode:"",
				'headernote'=>$model->headernote,
				'postdate'=>$model->postdate,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'purchasingorg'=>$purchasingorg,
			'purchasinggroup'=>$purchasinggroup,
                    'paymentmethod'=>$paymentmethod,
			'supplier'=>$supplier,
			'podetail'=>$podetail,
			'prheader'=>$prheader,
			'product'=>$product,
			'unitofmeasure'=>$unitofmeasure,
			'currency'=>$currency,
			'sloc'=>$sloc,
			'tax'=>$tax), true)
				));
            Yii::app()->end();
        }
      }
	}

	public function actionUpdatedetail()
	{
	  	 $prheader=new Prmaterial('search');
	  $prheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$prheader->attributes=$_GET['Prmaterial'];
		
		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$currency=new Currency('search');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

		$sloc=new Sloc('search');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$tax=new Tax('search');
	  $tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$tax->attributes=$_GET['Tax'];

		$id=$_POST['id'];
	  $podetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'podetailid'=>$podetail->podetailid,
				'productid'=>$podetail->productid,
				'productname'=>($podetail->product!==null)?$podetail->product->productname:"",
				'poqty'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$podetail->poqty),
				'unitofmeasureid'=>$podetail->unitofmeasureid,
				'uomcode'=>($podetail->unitofmeasure!==null)?$podetail->unitofmeasure->uomcode:"",
				'delvdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($podetail->delvdate)),
				'netprice'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$podetail->netprice),
				'ratevalue'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$podetail->ratevalue),
				'currencyid'=>$podetail->currencyid,
				'currencyname'=>($podetail->currency!==null)?$podetail->currency->currencyname:"",
				'slocid'=>$podetail->slocid,
				'description'=>($podetail->sloc!==null)?$podetail->sloc->description:"",
				'taxid'=>$podetail->taxid,
				'taxcode'=>($podetail->tax!==null)?$podetail->tax->taxcode:"",
				'itemtext'=>$podetail->itemtext,
                'underdelvtol'=>$podetail->underdelvtol,
                'overdelvtol'=>$podetail->overdelvtol,
                'prdetailid'=>$podetail->prdetailid,
                'prno'=>($podetail->prdetail!==null)?(($podetail->prdetail->prheader!==null)?$podetail->prdetail->prheader->prno:""):"",
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $model = Poheader::model()->findbypk($_POST['Poheader']['poheaderid']);
      if ($model != null)
      {
        $model->Delete();
      }
      $this->DeleteLockCloseForm($this->menuname, $_POST['Poheader'], $_POST['Poheader']['poheaderid']);
    }

	public function actionWrite()
	{
            parent::actionWrite();
	  if(isset($_POST['Poheader']))
	  {
      $messages = $this->ValidateData(
                array(
				array($_POST['Poheader']['docdate'],'emptydocdate','emptystring'),
				array($_POST['Poheader']['purchasinggroupid'],'emptypurchasinggroup','emptystring'),
            array($_POST['Poheader']['addressbookid'],'emptyaddressbook','emptystring'),
            array($_POST['Poheader']['paymentmethodid'],'emptypaymentmethod','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Poheader'];
		if ((int)$_POST['Poheader']['poheaderid'] > 0)
		{
		  $model=$this->loadModel($_POST['Poheader']['poheaderid']);
		  $model->purchasinggroupid = $_POST['Poheader']['purchasinggroupid'];
		  $model->addressbookid = $_POST['Poheader']['addressbookid'];
          $model->paymentmethodid = $_POST['Poheader']['paymentmethodid'];
		  $model->headernote = $_POST['Poheader']['headernote'];
          $model->docdate = $_POST['Poheader']['docdate'];
		}
		else
		{
		  $model = new Poheader();
		  $model->attributes=$_POST['Poheader'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Poheader']['poheaderid']);
              $this->GetSMessage('mmpoinsertsuccess');
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

        public function actionGeneratedetail()
        {
            if(isset($_POST['productid']) & isset($_POST['supplierid']) & isset($_POST['prmaterialid']))
	  {
                $podetail=Prmaterial::model()->findbysql('select * from prmaterial a inner join prheader b on b.prheaderid = a.prheaderid where prmaterialid = '.$_POST['prmaterialid'].
                        ' and productid = '.$_POST['productid'].
                        ' and qty > poqty '.
                        ' and b.prno is not null');
                $pirdetail=Purchinforec::model()->findbyattributes(array('addressbookid'=>$_POST['supplierid'],'productid'=>$_POST['productid']));

                echo CJSON::encode(array(
                'status'=>'success',
				'prdetailid'=>$podetail->prmaterialid,
				'prno'=>($podetail->prheader!==null)?$podetail->prheader->prno:"",
				'productid'=>$podetail->productid,
				'productname'=>($podetail->product!==null)?$podetail->product->productname:"",
				'poqty'=>($podetail->qty - $podetail->poqty),
				'unitofmeasureid'=>$podetail->unitofmeasureid,
				'uomcode'=>($podetail->unitofmeasure!==null)?$podetail->unitofmeasure->uomcode:"",
				'slocid'=>$podetail->prheader->slocid,
                    'itemtext'=>$podetail->itemtext,
				'reqdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($podetail->reqdate)),
				'description'=>($podetail->prheader!==null)?$podetail->prheader->sloc->description:"",
                    'underdelvtol'=>($pirdetail!==null)?$pirdetail->underdelvtol:"",
                    'overdelvtol'=>($pirdetail!==null)?$pirdetail->overdelvtol:""));
            Yii::app()->end();
            }
        }

	public function actionWritedetail()
	{
	  if(isset($_POST['Podetail']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Podetail']['productid'],'emptyproduct','emptystring'),
            array($_POST['Podetail']['poqty'],'emptyqty','emptystring'),
            array($_POST['Podetail']['unitofmeasureid'],'emptyunitofmeasure','emptystring'),
            array($_POST['Podetail']['netprice'],'emptynetprice','emptystring'),
            array($_POST['Podetail']['currencyid'],'emptycurrency','emptystring'),
            array($_POST['Podetail']['slocid'],'emptysloc','emptystring'),
            array($_POST['Podetail']['taxid'],'emptytax','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Podetail'];
		if ((int)$_POST['Podetail']['podetailid'] > 0)
		{
		  $model=Podetail::model()->findbyPK($_POST['Podetail']['podetailid']);
		  $model->poheaderid = $_POST['Podetail']['poheaderid'];
		  $model->productid = $_POST['Podetail']['productid'];
		  $model->poqty = $_POST['Podetail']['poqty'];
		  $model->unitofmeasureid = $_POST['Podetail']['unitofmeasureid'];
		  $model->delvdate = $_POST['Podetail']['delvdate'];
		  $model->netprice = $_POST['Podetail']['netprice'];
		  $model->currencyid = $_POST['Podetail']['currencyid'];
		  $model->slocid = $_POST['Podetail']['slocid'];
		  $model->taxid = $_POST['Podetail']['taxid'];
		  $model->itemtext = $_POST['Podetail']['itemtext'];
		  $model->underdelvtol = $_POST['Podetail']['underdelvtol'];
		  $model->prdetailid = $_POST['Podetail']['prdetailid'];
		  $model->overdelvtol = $_POST['Podetail']['overdelvtol'];
		  $model->ratevalue = $_POST['Podetail']['ratevalue'];
		$model->netprice = str_replace(",","",$model->netprice);
		$model->ratevalue = str_replace(",","",$model->ratevalue);
		$model->poqty = str_replace(",","",$model->poqty);
		}
		else
		{
		  $model = new Podetail();
		  $model->attributes=$_POST['Podetail'];
		$model->netprice = str_replace(",","",$model->netprice);
		$model->ratevalue = str_replace(",","",$model->ratevalue);
		$model->poqty = str_replace(",","",$model->poqty);
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Podetail']['podetailid']);
              $this->GetSMessage('mmpoinsertsuccess');
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
			if ($model->recordstatus>2)
			{
				$model->recordstatus=1;
			}
			else
			{
				$model->recordstatus=0;
			}
			$model->save();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	public function actionDeleteDetail()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Podetail::model()->findbyPK($ids);
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
				$sql = 'call ApprovePO(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$ids,PDO::PARAM_INT);
				$command->bindvalue(':vlastupdateby', $a,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->GetSMessage('pprinsertsuccess');
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
	  		$purchasingorg=new Purchasingorg('search');
	  $purchasingorg->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasingorg']))
		$purchasingorg->attributes=$_GET['Purchasingorg'];
      $paymentmethod=new Paymentmethod('search');
	  $paymentmethod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Paymentmethod']))
		$paymentmethod->attributes=$_GET['Paymentmethod'];

		$purchasinggroup=new Purchasinggroup('search');
	  $purchasinggroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasinggroup']))
		$purchasinggroup->attributes=$_GET['Purchasinggroup'];

		$supplier=new Supplier('search');
	  $supplier->unsetAttributes();  // clear any default values
	  if(isset($_GET['Supplier']))
		$supplier->attributes=$_GET['Supplier'];

		$podetail=new Podetail('search');
	  $podetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Podetail']))
		$podetail->attributes=$_GET['Podetail'];

	$prheader=new Prmaterial('search');
	  $prheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$prheader->attributes=$_GET['Prmaterial'];
		
		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$currency=new Currency('search');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

		$sloc=new Sloc('search');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$tax=new Tax('search');
	  $tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$tax->attributes=$_GET['Tax'];

		$model=new Poheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Poheader']))
			$model->attributes=$_GET['Poheader'];
			
			if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'purchasingorg'=>$purchasingorg,
			'purchasinggroup'=>$purchasinggroup,
            'paymentmethod'=>$paymentmethod,
			'supplier'=>$supplier,
			'podetail'=>$podetail,
			'prheader'=>$prheader,
			'product'=>$product,
			'unitofmeasure'=>$unitofmeasure,
			'currency'=>$currency,
			'sloc'=>$sloc,
			'tax'=>$tax,
                    'podetail'=>$podetail
		));
	}

	public function actionIndexDetail()
	{
	  $prheader=new Prmaterial('search');
	  $prheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$prheader->attributes=$_GET['Prmaterial'];
		
		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$sloc=new Sloc('search');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$currency=new Currency('search');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

		$tax=new Tax('search');
	  $tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$tax->attributes=$_GET['Tax'];

		$podetail=new Podetail('searchbypoheaderid');
		$podetail->unsetAttributes();  // clear any default values
		if(isset($_GET['Podetail']))
			$podetail->attributes=$_GET['Podetail'];
if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('indexdetail',array(
			'podetail'=>$podetail,
			'prheader'=>$prheader,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'sloc'=>$sloc,
					'currency'=>$currency,
					'tax'=>$tax
		));
	}
    
    public function actionDownload()
	{
	parent::actionDownload();
		if ($_GET['id'] !== '') {
				$sql = "update poheader set printke = ifnull(printke,0) + 1 
	  where poheaderid = ".$_GET['id'];
		}	  
	  $command=$this->connection->createCommand($sql);
	  $command->execute();
	  $sql = "select b.fullname, a.pono, a.docdate,b.addressbookid,a.poheaderid,c.paymentname,a.headernote,a.printke
      from poheader a
      left join addressbook b on b.addressbookid = a.addressbookid
      left join paymentmethod c on c.paymentmethodid = a.paymentmethodid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.poheaderid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
$this->pdf->isheader=false;
	  $this->pdf->title='Purchase Order';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',8);
	  $this->pdf->isprint=true;

    foreach($dataReader as $row)
    {
	$this->pdf->printke = $row['printke'];
      $sql1 = "select b.addresstypename, a.addressname, c.cityname, a.phoneno, a.faxno
        from address a
        left join addresstype b on b.addresstypeid = a.addresstypeid
        left join city c on c.cityid = a.cityid
        where addressbookid = ".$row['addressbookid'].
        " order by addressid ".
        " limit 1";
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      foreach($dataReader1 as $row1)
      {
	  $sql2 = "select a.addresscontactname, a.phoneno, a.mobilephone
        from addresscontact a
        where addressbookid = ".$row['addressbookid'].
        " order by addresscontactid ".
        " limit 1";
      $command2=$this->connection->createCommand($sql2);
      $dataReader2=$command2->queryAll();
	  $contact = '';

      foreach($dataReader2 as $row2)
      {
		$contact = $row2['addresscontactname'];
	  }
        $this->pdf->setFont('Arial','B',8);
        $this->pdf->Rect(10,60,195,40);
        $this->pdf->setFont('Arial','',8);
        $this->pdf->text(15,65,'Supplier');$this->pdf->text(40,65,': '.$row['fullname']);
        $this->pdf->text(15,70,'Attention');$this->pdf->text(40,70,': '.$contact);
        $this->pdf->text(15,75,'Address');$this->pdf->text(40,75,': '.$row1['addressname']);
        $this->pdf->text(15,80,'Phone');$this->pdf->text(40,80,': '.$row1['phoneno']);
        $this->pdf->text(15,85,'Fax');$this->pdf->text(40,85,': '.$row1['faxno']);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->text(120,65,'Purchase Order No ');$this->pdf->text(150,65,$row['pono']);
      $this->pdf->text(120,70,'PO Date ');$this->pdf->text(150,70,date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));

      }

      $sql1 = "select a.poheaderid,c.uomcode,a.poqty,a.delvdate,a.netprice,(poqty * netprice + (taxvalue * poqty * netprice) / 100) as total,b.productname,
        d.symbol,d.i18n,e.taxvalue,a.itemtext
        from podetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        left join currency d on d.currencyid = a.currencyid
        left join tax e on e.taxid = a.taxid
        where poheaderid = ".$row['poheaderid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $total = 0;
      $this->pdf->sety($this->pdf->gety()+80);
      $this->pdf->setFont('Arial','B',7);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(15,10,50,18,23,26,18,35));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array('Qty','Units','Item', 'Unit Price','Tax','Total','Delivery Date','Remarks');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',7);
      $this->pdf->coldetailalign = array('R','C','L','R','R','R','R','L');
	  $symbol = '';
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array(
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['poqty']),
			$row1['uomcode'],
			iconv("UTF-8", "ISO-8859-1", $row1['productname']),
            Yii::app()->numberFormatter->formatCurrency($row1['netprice'], $row1['symbol']),
			Yii::app()->numberFormatter->formatCurrency(($row1['taxvalue']*$row1['netprice']*$row1['poqty'])/100, $row1['symbol']),
            Yii::app()->numberFormatter->formatCurrency($row1['total'], $row1['symbol']),
			date(Yii::app()->params['dateviewfromdb'], strtotime($row1['delvdate'])),
			$row1['itemtext']));
        $total = $row1['total'] + $total;
$symbol = $row1['symbol'];
      }
	  $this->pdf->row(array('','','','','Total',
            Yii::app()->numberFormatter->formatCurrency($total,$symbol),'',''));
	  $this->pdf->title='';
	  $this->pdf->checknewpage(100);
		$this->pdf->sety($this->pdf->gety()+5);
	  $this->pdf->setFont('Arial','BU',8);
	  $this->pdf->text(10,$this->pdf->gety()+5,'TERM OF CONDITIONS');

		$this->pdf->sety($this->pdf->gety()+10);
      $this->pdf->setFont('Arial','B',7);
      $this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(50,130));
	  $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
	  $this->pdf->colheader = array('','');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L');
	  
	  $this->pdf->setFont('Arial','',8);
	  $this->pdf->row(array(
		'Material Certificate',
		'YES [ DIKIRIM BERSAMAAN DENGAN DATANGNYA BARANG ]'
	  ));
	  $this->pdf->row(array(
		'Manual Book / Catalogue',
		'Yes / No'
	  ));
	  $this->pdf->row(array(
		'Guarantee',
		'6 Months / 12 Months'
	  ));
	  $this->pdf->row(array(
		'Delivery Condition',
		'Return if not accepted without any charge'
	  ));
	  $this->pdf->row(array(
		'Payment Schedule',
		'Every 3th Friday'
	  ));
	  $this->pdf->row(array(
		'Payment Term',
		$row['paymentname']
	  ));
	  $this->pdf->row(array(
		'Note:',
		$row['headernote']
	  ));
	  
	 $this->pdf->setFont('Arial','',7);
	 $company = Company::model()->findbysql('select * from company limit 1');
	 $this->pdf->CheckPageBreak(60);
	  $this->pdf->sety($this->pdf->gety()+5);
      $this->pdf->text(10,$this->pdf->gety()+5,'Thanking you and assuring our best attention we remain.');
      $this->pdf->text(10,$this->pdf->gety()+10,'Sincerrely Yours');
      $this->pdf->text(10,$this->pdf->gety()+15,$company->companyname);$this->pdf->text(135,$this->pdf->gety()+15,'Confirmed and Accepted by Supplier');
	  $this->pdf->setFont('Arial','B',8);
      $this->pdf->text(10,$this->pdf->gety()+35,'TEDDY SUJARWANTO');
      $this->pdf->text(10,$this->pdf->gety()+36,'____________________');$this->pdf->text(135,$this->pdf->gety()+36,'__________________________');
	  $this->pdf->setFont('Arial','',7);
      $this->pdf->text(10,$this->pdf->gety()+40,'Director');
      $this->pdf->text(10,$this->pdf->gety()+45,'cc : Finance & Purchasing Manager');

	  $this->pdf->setFont('Arial','BU',7);
	  $this->pdf->text(10,$this->pdf->gety()+55,'#Note: Mohon tidak memberikan gift atau uang kepada staff kami#');
	  $this->pdf->setFont('Arial','',7);
	  $this->pdf->text(10,$this->pdf->gety()+60,'NAMA PKP : '.$company->companyname);
	  $this->pdf->text(10,$this->pdf->gety()+65,'NPWP : '.$company->taxno);
	  $this->pdf->text(10,$this->pdf->gety()+70,'ALAMAT PKP : '.$company->address);
    }
	  $this->pdf->Output();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Poheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Podetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='poheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

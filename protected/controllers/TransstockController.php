<?php

class TransstockController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        protected $menuname = 'transstock';

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
	  $transstockdet=new Transstockdet('search');
	  $transstockdet->unsetAttributes();  // clear any default values
	  if(isset($_GET['Transstockdet']))
		$transstockdet->attributes=$_GET['Transstockdet'];

		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$slocfrom=new Sloc('search');
	  $slocfrom->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$slocfrom->attributes=$_GET['Sloc'];

      $slocto=new Sloc('search');
	  $slocto->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$slocto->attributes=$_GET['Sloc'];

		$model=new Transstock;
		$model->recordstatus=0;

		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'transstockid'=>$model->transstockid,
				  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
					'transstockdet'=>$transstockdet,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'slocfrom'=>$slocfrom,
                      'slocto'=>$slocto), true)
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
		$transstockdet=new Transstockdet;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formdetail',
				  array('model'=>$transstockdet,'product'=>$product,
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
		$transstockdet=new Transstockdet('search');
	  $transstockdet->unsetAttributes();  // clear any default values
	  if(isset($_GET['Transstockdet']))
		$transstockdet->attributes=$_GET['Transstockdet'];

		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$slocfrom=new Sloc('search');
	  $slocfrom->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$slocfrom->attributes=$_GET['Sloc'];

      $slocto=new Sloc('search');
	  $slocto->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$slocto->attributes=$_GET['Sloc'];


		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

		// Uncomment the following line if AJAX validation is needed
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'transstockid'=>$model->transstockid,
				'headernote'=>$model->headernote,
				'slocfromid'=>$model->slocfromid,
				'slocfromcode'=>($model->slocfrom!==null)?$model->slocfrom->sloccode:"",
                'sloctoid'=>$model->sloctoid,
                'sloctocode'=>($model->slocto!==null)?$model->slocto->sloccode:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
					'transstockdet'=>$transstockdet,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'slocfrom'=>$slocfrom,
					'slocto'=>$slocto), true)
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
	  $transstockdet=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'transstockdetid'=>$transstockdet->transstockdetid,
				'productid'=>$transstockdet->productid,
				'productname'=>($transstockdet->product!==null)?$transstockdet->product->productname:"",
				'qty'=>$transstockdet->qty,
				'unitofmeasureid'=>$transstockdet->unitofmeasureid,
				'uomcode'=>($transstockdet->unitofmeasure!==null)?$transstockdet->unitofmeasure->uomcode:"",
                'itemtext'=>$transstockdet->itemtext,
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$transstockdet,'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'sloc'=>$sloc,
					'requestedby'=>$requestedby), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname,$_POST['Transstock'],$_POST['Transstock']['transstockid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Transstock']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Transstock']['slocfromid'],'itsemptyslocfrom','emptystring'),
            array($_POST['Transstock']['sloctoid'],'itsemptyslocto','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Transstock'];
		if ((int)$_POST['Transstock']['transstockid'] > 0)
		{
		  $model=$this->loadModel($_POST['Transstock']['transstockid']);
		  $model->headernote = $_POST['Transstock']['headernote'];
		  $model->slocfromid = $_POST['Transstock']['slocfromid'];
		  $model->sloctoid = $_POST['Transstock']['sloctoid'];
          if ($model->recordstatus == 0)
          {
            $model->recordstatus=Wfgroup::model()->findstatusbyuser('insts');
          }
		}
		else
		{
		  $model = new Transstock();
		  $model->attributes=$_POST['Transstock'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Transstock']['transstockid']);
              $this->GetSMessage('itsinsertsuccess');
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
	  if(isset($_POST['Transstockdet']))
	  {
		//$dataku->attributes=$_POST['Transstockdet'];
		if ((int)$_POST['Transstockdet']['transstockdetid'] > 0)
		{
		  $model=Transstockdet::model()->findbyPK($_POST['Transstockdet']['transstockdetid']);
		  $model->transstockid = $_POST['Transstockdet']['transstockid'];
		  $model->productid = $_POST['Transstockdet']['productid'];
		  $model->qty = $_POST['Transstockdet']['qty'];
		  $model->itemtext = $_POST['Transstockdet']['itemtext'];
		}
		else
		{
		  $model = new Transstockdet();
		  $model->attributes=$_POST['Transstockdet'];
		}
		try
          {
            if($model->save())
            {
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
				$sql = 'call ApproveTS(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindValue(':vid',$model->transstockid,PDO::PARAM_INT);
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
	  $transstockdet=new Transstockdet('search');
	  $transstockdet->unsetAttributes();  // clear any default values
	  if(isset($_GET['Transstockdet']))
		$transstockdet->attributes=$_GET['Transstockdet'];

		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$slocfrom=new Sloc('search');
	  $slocfrom->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$slocfrom->attributes=$_GET['Sloc'];

      $slocto=new Sloc('search');
	  $slocto->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$slocto->attributes=$_GET['Sloc'];

		$requestedby=new Requestedby('search');
	  $requestedby->unsetAttributes();  // clear any default values
	  if(isset($_GET['Requestedby']))
		$requestedby->attributes=$_GET['Requestedby'];

		$model=new Transstock('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Transstock']))
			$model->attributes=$_GET['Transstock'];
if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('index',array(
			'model'=>$model,
					'transstockdet'=>$transstockdet,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'slocfrom'=>$slocfrom,
					'slocto'=>$slocto,
					'requestedby'=>$requestedby
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

		$sloc=new Sloc('search');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$requestedby=new Requestedby('search');
	  $requestedby->unsetAttributes();  // clear any default values
	  if(isset($_GET['Requestedby']))
		$requestedby->attributes=$_GET['Requestedby'];

		$transstockdet=new Transstockdet('search');
	  $transstockdet->unsetAttributes();  // clear any default values
	  if(isset($_GET['Transstockdet']))
		$transstockdet->attributes=$_GET['Transstockdet'];

	  $this->renderPartial('indexdetail',
		array('transstockdet'=>$transstockdet,'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'sloc'=>$sloc,
					'requestedby'=>$requestedby));
	  Yii::app()->end();
	}

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

	public function actionDeletedetail()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Transstockdet::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Transstock::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Transstockdet::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='transstock-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

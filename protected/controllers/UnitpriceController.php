<?php

class UnitpriceController extends Controller
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
	  $currency=new Currency('searchwstatus');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

	  $pricetype=new Pricetype('searchwstatus');
	  $pricetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Pricetype']))
		$pricetype->attributes=$_GET['Pricetype'];

		$model=new Unitprice;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure',
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'currency'=>$currency,
			'pricetype'=>$pricetype), true)
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
	 $currency=new Currency('searchwstatus');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

	  $pricetype=new Pricetype('searchwstatus');
	  $pricetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Pricetype']))
		$pricetype->attributes=$_GET['Pricetype'];
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'failure',
				'unitpriceid'=>$model->unitpriceid,
				'pricetypeid'=>$model->pricetypeid,
				'pricetypename'=>$model->pricetype->pricetypename,
				'currencyid'=>$model->currencyid,
				'currencyname'=>$model->currency->currencyname,
				'price'=>$model->price,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
			'currency'=>$currency,
			'pricetype'=>$pricetype), true)
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Unitprice'], $_POST['Unitprice']['unitpriceid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Unitprice']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Unitprice']['pricetypeid'],'hrptuemptypricetypeid','emptystring'),
            array($_POST['Unitprice']['currencyid'],'hrptuemptycurrencyid','emptystring'),
            array($_POST['Unitprice']['price'],'hrptuemptyprice','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Unitprice']['unitpriceid'] > 0)
		{
		  $model=$this->loadModel($_POST['Unitprice']['unitpriceid']);
		  $model->pricetypeid = $_POST['Unitprice']['pricetypeid'];
		  $model->currencyid = $_POST['Unitprice']['currencyid'];
		  $model->price = $_POST['Unitprice']['price'];
		  $model->recordstatus = $_POST['Unitprice']['recordstatus'];
		}
		else
		{
		  $model = new Unitprice();
		  $model->attributes=$_POST['Unitprice'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Unitprice']['unitpriceid']);
              $this->GetSMessage('hrptuinsertsuccess');
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
	public function actionDelete($id)
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
	  $currency=new Currency('searchwstatus');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

	  $pricetype=new Pricetype('searchwstatus');
	  $pricetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Pricetype']))
		$pricetype->attributes=$_GET['Pricetype'];
		$model=new Unitprice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Unitprice']))
			$model->attributes=$_GET['Unitprice'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
			'currency'=>$currency,
			'pricetype'=>$pricetype
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Unitprice::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='unitprice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

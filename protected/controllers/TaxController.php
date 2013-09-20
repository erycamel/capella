<?php

class TaxController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'tax';

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
		$model=new Tax;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'div'=>$this->renderPartial('_form', array('model'=>$model), true)
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
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'taxid'=>$model->taxid,
				'taxcode'=>$model->taxcode,
				'taxvalue'=>$model->taxvalue,
				'description'=>$model->description,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model), true)
				));
            Yii::app()->end();
        }
      }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Tax'], $_POST['Tax']['taxid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Tax']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Tax']['taxcode'],'emptytaxcode','emptystring'),
                array($_POST['Tax']['taxvalue'],'emptytaxvalue','emptystring'),
                array($_POST['Tax']['description'],'emptydescription','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Tax'];
		if ((int)$_POST['Tax']['taxid'] > 0)
		{
		  $model=$this->loadModel($_POST['Tax']['taxid']);
		  $model->taxcode = $_POST['Tax']['taxcode'];
		  $model->taxvalue = $_POST['Tax']['taxvalue'];
		  $model->description = $_POST['Tax']['description'];
		  $model->recordstatus = $_POST['Tax']['recordstatus'];
		}
		else
		{
		  $model = new Tax();
		  $model->attributes=$_POST['Tax'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Tax']['taxid']);
              $this->GetSMessage('atxinsertsuccess');
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
	
	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select taxcode, taxvalue, description
				from tax a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.taxid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Tax List';
		$this->pdf->AddPage('P');
		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(40,50,90));
		$this->pdf->colheader = array('Tax Code','Tax Value','Description');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','L');
		$this->pdf->setFont('Arial','',8);
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['taxcode'],$row1['taxvalue'],$row1['description']));
		}
		// me-render ke browser
		$this->pdf->Output();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
		$model=new Tax('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tax']))
			$model->attributes=$_GET['Tax'];
		if (isset($_GET['pageSize']))
		  {
			Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
			unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		  }
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Tax::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tax-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

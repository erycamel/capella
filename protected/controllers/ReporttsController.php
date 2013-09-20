<?php

class ReporttsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        protected $menuname = 'reportts';

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

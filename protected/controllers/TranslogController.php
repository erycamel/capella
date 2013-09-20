<?php

class TranslogController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'translog';

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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
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
	
	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select *
				from translog a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.translogid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Transaction Log List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C','C','C','C','C','C'));
		$this->pdf->setwidths(array(20,20,30,30,30,30,30));
		$this->pdf->Row(array('User Name','Model','User Action','Created Date','Field Name','New Value','Old Value'));
		$this->pdf->setaligns(array('L','L','L','L','L','L','L'));
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['username'],$row1['model'],$row1['useraction'],$row1['createddate'],
			$row1['fieldname'],$row1['fieldnewvalue'],$row1['fieldoldvalue']));
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
    $model=new Translog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Translog']))
			$model->attributes=$_GET['Translog'];
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
		$model=Translog::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='translog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

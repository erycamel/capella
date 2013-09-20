<?php

class RepempoverController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeeover';

	public function actionHelp()
	{
		$txt = '';
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $txt = '_help'; break;
				case 2 : $txt = '_helpmodif'; break;
				case 3 : $txt = '_helpdetail'; break;
				case 4 : $txt = '_helpdetailmodif'; break;
			}
		}
		parent::actionHelp($txt);
	}
	
	public $employeeoverdet;
	

	public function lookupdata()
	{
	  $this->employeeoverdet=new Employeeoverdet('search');
	  $this->employeeoverdet->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeeoverdet']))
		$this->employeeoverdet->attributes=$_GET['Employeeoverdet'];
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();
		$model=new Employeeover('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employeeover']))
			$model->attributes=$_GET['Employeeover'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'employeeoverdet'=>$this->employeeoverdet
		));
	}

	public function actionIndexdetail()
	{
	  $this->lookupdata();
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->renderPartial('indexdetail',
		array('employeeoverdet'=>$this->employeeoverdet));
	  Yii::app()->end();
	}

	public function actionDownload()
  {
	parent::actionDownload();
    $pdf = new PDF();
	  $pdf->title='Overtime Transaction List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select employeeoverid,overtimeno,overtimedate
      from employeeover a";
    $command=$connection->createCommand($sql);
    $dataReader=$command->queryAll();

    foreach($dataReader as $row)
    {
      $pdf->setFont('Arial','B',10);
      $pdf->text(50,30,'Overtime No: '.$row['overtimeno']);
      $pdf->text(50,40,'Overtime Date: '.$row['overtimedate']);

      $sql1 = "select  b.fullname, a.overtime, a.overtimeend
        from employeeoverdet a
        left join employee b on b.employeeid = a.employeeid
        where employeeoverid = ".$row['employeeoverid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $pdf->text(10,50,'Overtime List');
      $pdf->SetY(55);
      $pdf->setaligns(array('C','C','C'));
      $pdf->setwidths(array(70,45,45));
      $pdf->Row(array('Employee','Overtime Start','Overtime End'));
      $pdf->setaligns(array('L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $pdf->row(array($row1['fullname'],$row1['overtime'],$row1['overtimeend']));
      }
      $pdf->AddPage('P');
    }
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
		$model=Repempover::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Repempoverdet::model()->findByPk((int)$id);
		//if($model===null)
		//	throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeeover-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeeoverdet-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

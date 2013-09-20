<?php

class EmployeebroadcastController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'employeebroadcast';
  	
	public function actionSendMessage()
	{
	  parent::actionCreate();
	  if(isset($_POST['messages']))
		{
		  $messages = $_POST['messages'];
				$connection=Yii::app()->db;
				$transaction=$connection->beginTransaction();
				try
				{
				  $sql = 'call EmployeeBroadcast(:vmessages)';
				  $command=$connection->createCommand($sql);
				  $command->bindParam(':vmessages',$messages,PDO::PARAM_STR);
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
	}
  
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	      $model=new Employee('searchwstatus');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employee']))
			$model->attributes=$_GET['Employee'];
			if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model
		));
	}

	public function actionDownload()
  {
	parent::actionDownload();
    $pdf = new PDF();
    $pdf->title='Employee List';
    $pdf->AddPage('P');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Full Name','Old Nik','New Nik','Structure');
    $model=new Employee('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($dataku);
    $w= array(20,25,30,40,40,40);

    $pdf->SetTableHeader();
    //Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $pdf->Ln();
    $pdf->SetTableData();
    //Data
    $fill=false;
    $i=0;
    foreach($data as $datas)
    {
        $i=$i+1;
        $pdf->Cell($w[0],6,$i,'LR',0,'L',$fill);
        $pdf->Cell($w[1],6,$datas['employeeid'],'LR',0,'C',$fill);
        $pdf->Cell($w[2],6,$datas['fullname'],'LR',0,'C',$fill);
        $pdf->Cell($w[3],6,$datas['oldnik'],'LR',0,'C',$fill);
        $pdf->Cell($w[4],6,$datas['newnik'],'LR',0,'C',$fill);
        $pdf->Cell($w[5],6,Orgstructure::model()->findByPk($datas['orgstructureid'])->structurename,'LR',0,'C',$fill);
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
		$model=Employee::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employee-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

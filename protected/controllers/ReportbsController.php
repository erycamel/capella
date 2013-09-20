<?php

class ReportbsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'reportbs';

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

	public $bsdetail,$sloc,$product,$unitofmeasure;

	public function lookupdetail()
	{
		$this->sloc=new Sloc('search');
	  $this->sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$this->sloc->attributes=$_GET['Sloc'];

	  $this->product=new Product('search');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

		$this->unitofmeasure=new Unitofmeasure('search');
	  $this->unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$this->unitofmeasure->attributes=$_GET['Unitofmeasure'];
	}

	public function lookupdata()
	{
		$this->bsdetail=new Bsdetail('search');
	  $this->bsdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Bsdetail']))
		$this->bsdetail->attributes=$_GET['Bsdetail'];

		$this->lookupdetail();
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
	  $this->lookupdata();
		$model=new Bsheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bsheader']))
			$model->attributes=$_GET['Bsheader'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
					'bsdetail'=>$this->bsdetail,
					'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
				  'sloc'=>$this->sloc
		));
	}

	public function actionIndexdetail()
	{
		$this->lookupdata();
	  $this->renderPartial('indexdetail',
		array('bsdetail'=>$this->bsdetail,
					'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
				  'sloc'=>$this->sloc));
	  Yii::app()->end();
	}

	public function actionDownload()
  {
    Yii::import('application.extensions.fpdf.*');
    require_once("pdf.php");
    $pdf = new PDF();
    $pdf->title='Absence Schedule List';
    $pdf->AddPage('L');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Schedule Name','Absence In','Absence Out', 'Status', 'Wage Name', 'Currency', 'Insentif');
    $model=new Absschedule('searchwstatus');
    $dataprovider=$model->searchwstatus();
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
		$model=Bsheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Bsdetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='bsheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='bsdetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

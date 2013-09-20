<?php

class ReportglController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'reportgl';

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
	
	public $journaldetail;
	

	public function lookupdata()
	{
	  $this->journaldetail=new Journaldetail('search');
	  $this->journaldetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Journaldetail']))
		$this->journaldetail->attributes=$_GET['Journaldetail'];
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();
		$model=new Genjournal('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Genjournal']))
			$model->attributes=$_GET['Genjournal'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'journaldetail'=>$this->journaldetail
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
		array('journaldetail'=>$this->journaldetail));
	  Yii::app()->end();
	}

	public function actionDownload()
  {
	parent::actionDownload();
	  $this->pdf->title='General Journal';
	  $this->pdf->AddPage('P');
	  $this->pdf->iscustomborder = false;
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select a.referenceno,a.journalnote,a.journaldate,a.genjournalid,a.recordstatus,a.journalno
      from genjournal a ";
	  if ($_GET['id'] !== '') {
				$sql = $sql . "where a.genjournalid = ".$_GET['id'];
		}
    $command=$connection->createCommand($sql);
    $dataReader=$command->queryAll();

    foreach($dataReader as $row)
    {
	if ($this->checkprint($this->menuname,'prigenjournal',$row['recordstatus']))
		{
      $this->pdf->setFont('Arial','B',10);
	  $this->pdf->Rect(10,60,190,25);
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['journalno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Ref No ');$this->pdf->text(50,$this->pdf->gety()+10,': '.$row['referenceno']);
      $this->pdf->text(15,$this->pdf->gety()+15,'Date ');$this->pdf->text(50,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['journaldate'])));
      $this->pdf->text(15,$this->pdf->gety()+20,'Note ');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['journalnote']);

      $sql1 = "select b.accountcode,b.accountname, a.debit,a.credit,c.symbol,a.detailnote,a.ratevalue
        from journaldetail a
        left join account b on b.accountid = a.accountid
        left join currency c on c.currencyid = a.currencyid
        where genjournalid = ".$row['genjournalid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

	  $this->pdf->SetY($this->pdf->gety()+25);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,60,25,25,20,50));
	  $this->pdf->colheader = array('No','Account','Debit','Credit','Rate','Detail Note');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',7);
      $this->pdf->coldetailalign = array('L','L','R','R','R','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['accountcode'].' '.$row1['accountname'],
            Yii::app()->numberFormatter->formatCurrency($row1['debit'],$row1['symbol']),
            Yii::app()->numberFormatter->formatCurrency($row1['credit'],$row1['symbol']),
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row1['ratevalue']),
            $row1['detailnote']));
      }
      
      $this->pdf->setFont('Arial','',8);
      $this->pdf->text(170,$this->pdf->gety()+15,'Jakarta, '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['journaldate'])));
      $this->pdf->text(10,$this->pdf->gety()+20,'Approved By');$this->pdf->text(170,$this->pdf->gety()+20,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+40,'------------ ');$this->pdf->text(170,$this->pdf->gety()+40,'------------');

      $this->pdf->CheckNewPage(10);
      }
	  }

    // me-render ke browser
    $this->pdf->Output();
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Reportgl::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Journaldetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='genjournal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='journaldetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

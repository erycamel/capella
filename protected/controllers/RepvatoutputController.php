<?php

class RepvatoutputController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'repvatoutput';

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
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
			if (isset($_POST['startperiod']) && isset($_POST['endperiod']))
      {
        $this->pdf->title='VAT Output Report';
	  $this->pdf->AddPage('L');
		$this->pdf->iscustomborder = false;
		$this->pdf->isneedpage = true;
		$connection=Yii::app()->db;
		$sql = "select c.accountcode,c.accountname,a.fakturpajakno,a.invoiceid,d.invoiceno,b.debit,d.invoicedate,e.sono,e.sodate,
d.amount,f.fullname
from fakturpajak a
left join invoiceacc b on b.invoiceid = a.invoiceid
left join invoice d on d.invoiceid = b.invoiceid
left join account c on c.accountid = b.accountid
left join soheader e on e.soheaderid = d.soheaderid
left join addressbook f on f.addressbookid = e.addressbookid
where c.accountcode = '1.5.010.06' and d.invoicedate between '". $_POST['startperiod']. "' and '". $_POST['endperiod']."'";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$this->pdf->Cell(0,10,'PERIODE : '. date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['startperiod'])) . 
				' Up To '.date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['endperiod'])),0,0,'C');
		
      $this->pdf->SetY($this->pdf->gety()+15);
		$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,20,40,30,30,30,20,30,20,20,30));
	  $this->pdf->colheader = array(
		'No',
		'Account No',
		'Customer Name',
		'SO No',
		'Invoice No',
		'Invoice Date',
		'Invoice Amount',
		'VAT No',
		'VAT Date',
		'VAT Amount'
		);
      $this->pdf->RowHeader();
		$this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','L','L','L','L','R','R','L','L','R');
	  $totalamount = 0;$i=0;$totaltax=0;
		foreach($dataReader as $row)
          {
		  $i+=1;
$this->pdf->Row(array(
		$i,
		$row['accountcode'],
		$row['fullname'],
		$row['sono'],
		$row['invoiceno'],
		date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
		Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['amount']),
		$row['fakturpajakno'],
		date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
		Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['debit']),		
		));
		      $this->pdf->text(12,$this->pdf->gety()+10,'NOTE : Print Report as per Voucher Date and Account Name');
			  $totalamount += $row['amount'];
			  $totaltax += $row['debit'];
		$this->pdf->CheckPageBreak(0);
		  		  }
				  $this->pdf->Row(array(
		'',
		'',
		'',
		'',
		'',
		'Total',
		Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$totalamount),
		'',
		'',
		Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$totaltax),		
		));
          $this->pdf->Output();
	  }
	  else
	  {
		$this->render('index');
	  }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Genledger::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='genledger-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

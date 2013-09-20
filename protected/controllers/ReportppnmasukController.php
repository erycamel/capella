<?php

class ReportppnmasukController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'reportppnmasuk';

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
        $this->pdf->title='Laporan Pajak Masukan';
	  $this->pdf->AddPage('L','Legal');
		$this->pdf->iscustomborder = false;
		$this->pdf->isneedpage = true;
		$connection=Yii::app()->db;
		$sql = "select a.fpno,a.fpdate,c.fullname,c.taxno,a.amount,(d.taxvalue * a.amount/100) as taxvalue,(a.amount) + (d.taxvalue*a.amount/100) as total,
b.pono,b.docdate,a.invoiceno,a.invoicedate,a.headernote,e.symbol
from invoice a
inner join poheader b on b.poheaderid = a.poheaderid
left join addressbook c on c.addressbookid = b.addressbookid
left join tax d on d.taxid = a.taxid
left join currency e on e.currencyid = a.currencyid
where invoicedate between '". $_POST['startperiod']. "' and '".$_POST['endperiod']."' and fpno <> ''";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$this->pdf->Cell(0,10,'Date : '. date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['startperiod'])) . ' - ' . date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['endperiod'])),0,0,'C');
		
      $this->pdf->SetY($this->pdf->gety()+15);
		$this->pdf->setFont('Arial','B',10);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,25,25,40,30,30,30,30,20,20,20,20,40));
	  $this->pdf->colheader = array(
		'No',
		'Tax No',
		'Tax Date',
		'Supplier',
		'NPWP',
		'DPP',
		'PPN',
		'Total Price',
		'PO No',
		'PO Date',
		'Invoice No',
		'Invoice Date',
		'Keterangan'
		);
      $this->pdf->RowHeader();
		$this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','L','L','L','R','R','R','L','L','L','L','L');
	  $totaldpp = 0;$i=0;$totaltax=0;$symbol='';$total=0;
		foreach($dataReader as $row)
          {
		  $i+=1;
$this->pdf->Row(array(
		$i,
		$row['fpno'],
		date(Yii::app()->params['dateviewfromdb'], strtotime($row['fpdate'])),
		$row['fullname'],
		$row['taxno'],
		Yii::app()->numberFormatter->formatCurrency($row['amount'],$row['symbol']),
		Yii::app()->numberFormatter->formatCurrency($row['taxvalue'],$row['symbol']),
		Yii::app()->numberFormatter->formatCurrency($row['total'],$row['symbol']),
		$row['pono'],
		date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])),
		$row['invoiceno'],
		date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
		$row['headernote'],
		));
		$symbol = $row['symbol'];
			  $totaldpp += $row['amount'];
			  $totaltax += $row['taxvalue'];
			  $total += $row['total'];
		$this->pdf->CheckPageBreak(0);
		  		  }
				  $this->pdf->Row(array(
		'',
		'',
		'',
		'',
		'Total',
		Yii::app()->numberFormatter->formatCurrency($totaldpp,$symbol),
		Yii::app()->numberFormatter->formatCurrency($totaltax,$symbol),
		Yii::app()->numberFormatter->formatCurrency($total,$symbol),
		'',
		'',
		'',
		'',
		'',
		));
				$this->pdf->setFont('Arial','',10);
	$this->pdf->text(10,$this->pdf->gety()+35,'Prepared By');
      $this->pdf->text(10,$this->pdf->gety()+55,'(------------------)');

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

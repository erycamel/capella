<?php

class RepreqpayController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'repreqpay';

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
			if (isset($_POST['startperiod']))
      {
        $this->pdf->title='Payment Request';
	  $this->pdf->AddPage('L');
		$this->pdf->iscustomborder = false;
		$this->pdf->isneedpage = true;
		$connection=Yii::app()->db;
		$sql = "select *
from
(
select  a.invoiceno,c.pono,a.invoicedate,a.amount,e.fullname,a.headernote,f.symbol,
date_add(a.invoicedate, interval b.paydays DAY) as payday,d.taxcode,((ifnull(d.taxvalue,0) * a.amount) / 100) + a.amount as total
from invoice a 
left join paymentmethod b on b.paymentmethodid = a.paymentmethodid
left join poheader c on c.poheaderid = a.poheaderid
left join addressbook e on e.addressbookid = c.addressbookid
left join tax d on d.taxid = a.taxid
left join currency f on f.currencyid = a.currencyid
where a.invoicetypeid = 1 and a.invoiceid not in (select invoiceid from cashbank where cashbankid = 1)
) z1
where payday <= '". $_POST['startperiod']. "'";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$this->pdf->Cell(0,10,'Due Date : '. date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['startperiod'])),0,0,'C');
		
      $this->pdf->SetY($this->pdf->gety()+15);
		$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,50,40,30,40,40,60));
	  $this->pdf->colheader = array(
		'No',
		'Supplier Name',
		'Invoice No',
		'Invoice Date',
		'PO No',
		'Invoice Amount',
		'Description',
		);
      $this->pdf->RowHeader();
		$this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','L','L','L','R','L','L');
	  $totalamount = 0;$i=0;$totaltax=0;$symbol='';
		foreach($dataReader as $row)
          {
		  $i+=1;
$this->pdf->Row(array(
		$i,
		$row['fullname'],
		$row['invoiceno'],
		date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
		$row['pono'],
		Yii::app()->numberFormatter->formatCurrency($row['total'],$row['symbol']),
		$row['headernote'],
		));
		$symbol = $row['symbol'];
			  $totalamount += $row['total'];
		$this->pdf->CheckPageBreak(0);
		  		  }
		      $this->pdf->text(12,$this->pdf->gety()+10,'NOTE : Print Report as per Voucher Date and Account Name');
				  $this->pdf->Row(array(
		'',
		'',
		'',
		'',
		'Total',
		Yii::app()->numberFormatter->formatCurrency($totalamount,$symbol),
		''
		));
				$this->pdf->setFont('Arial','',10);
	$this->pdf->text(10,$this->pdf->gety()+35,'Prepared By');$this->pdf->text(60,$this->pdf->gety()+35,'Checked By');
      $this->pdf->text(10,$this->pdf->gety()+55,'(------------------)');$this->pdf->text(60,$this->pdf->gety()+55,'(------------------)');
	$this->pdf->text(130,$this->pdf->gety()+35,'Approved By');$this->pdf->text(200,$this->pdf->gety()+35,'Acknowladge By');
      $this->pdf->text(130,$this->pdf->gety()+55,'(------------------)');$this->pdf->text(200,$this->pdf->gety()+55,'(------------------)');

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

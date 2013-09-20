<?php

class RepdailyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'repdaily';

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
        $this->pdf->title='Daily Transaction Report';
	  $this->pdf->AddPage('L');
		$this->pdf->iscustomborder = false;
		$this->pdf->isneedpage = true;
		$connection=Yii::app()->db;
		$sql = "
		select *
		from
		(	
			select a.cashbankno,a.transdate,a.description,'' as pono,'' as supplier,'' as sono,'' as customer,f.accountcode,f.accountname,g.symbol,a.amount as debit,0 as credit,a.currencyrate,'' as invoiceno
from cashbank a
left join account f on f.accountid = a.accountid
left join currency g on g.currencyid = a.currencyid
where a.cashbanktypeid = 1 
and a.transdate between '". $_POST['startperiod']. "' and '". $_POST['endperiod']."' and a.recordstatus > 1

			union
			
			select a.cashbankno,a.transdate,a.description,'','','','',f.accountcode,f.accountname,g.symbol,0,a.amount,a.currencyrate,'' as invoiceno
from cashbank a
left join account f on f.accountid = a.accountid
left join currency g on g.currencyid = a.currencyid
where a.cashbanktypeid = 2  
and a.transdate between '". $_POST['startperiod']. "' and '". $_POST['endperiod']."' and a.recordstatus > 1

			union
			
			select a.cashbankno,a.transdate,a.description,d.pono,e.fullname,'', '', f.accountcode,f.accountname,g.symbol,b.debit,b.credit,b.currencyrate,c.invoiceno
from cashbankacc b
left join cashbank a on a.cashbankid = b.cashbankid
left join invoice c on c.invoiceid = a.invoiceid
left join poheader d on d.poheaderid = c.poheaderid
left join addressbook e on e.addressbookid = d.addressbookid
left join account f on f.accountid = b.accountid
left join currency g on g.currencyid = a.currencyid
where  a.transdate between '". $_POST['startperiod']. "' and '". $_POST['endperiod']."' and a.cashbanktypeid = 1 and a.recordstatus > 1

union

select a.cashbankno,a.transdate,a.description,'','',d.sono,e.fullname,f.accountcode,f.accountname,g.symbol,b.debit,b.credit,b.currencyrate,c.invoiceno
from cashbankacc b
left join cashbank a on a.cashbankid = b.cashbankid
left join invoice c on c.invoiceid = a.invoiceid
left join soheader d on d.soheaderid = c.soheaderid
left join addressbook e on e.addressbookid = d.addressbookid
left join account f on f.accountid = b.accountid
left join currency g on g.currencyid = a.currencyid
where  a.transdate between '". $_POST['startperiod']. "' and '". $_POST['endperiod']."' and a.cashbanktypeid = 2 and a.recordstatus > 1		
			
			) zz
			order by transdate,cashbankno

";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$this->pdf->Cell(0,10,'PERIODE : '. date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['startperiod'])) . 
				' Up To '.date(Yii::app()->params['dateviewfromdb'], strtotime($_POST['endperiod'])),0,0,'C');
		
      $this->pdf->SetY($this->pdf->gety()+15);
		$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,30,55,25,25,25,20,30,30,30,30));
	  $this->pdf->colheader = array(
		'No',
		'Voucher',
		'Description',
		'PO No',
		'SO No',
		'Invoice',
		'Account No',
		'Account Name',
		'Debit',
		'Credit'
		);
      $this->pdf->RowHeader();
		$this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign = array('L','L','L','L','L','L','L','R','R','R');
	  $totaldebit = 0;$totalcredit = 0;$i=0;$totaltax=0;$symbol = "";$oldcbno="";$total= 0;
		foreach($dataReader as $row)
          {
		  ($oldcbno !== $row['cashbankno'])?$i+=1:0;
$this->pdf->Row(array(
		($oldcbno !== $row['cashbankno'])?$i:"",
		($oldcbno !== $row['cashbankno'])?$row['cashbankno'] . " " .date(Yii::app()->params['dateviewfromdb'], strtotime($row['transdate'])):"",	
		$row['description'],
		$row['pono'],
		$row['sono'],
		$row['invoiceno'] . " " .empty($row['invoicedate'])?"":date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])),
		$row['accountcode'],
		$row['accountname'],
		Yii::app()->numberFormatter->formatCurrency($row['debit'],$row['symbol']),
		Yii::app()->numberFormatter->formatCurrency($row['credit'],$row['symbol']),
		));
			  $totaldebit += ($row['debit']*$row['currencyrate']);
			  $totalcredit += ($row['credit']*$row['currencyrate']);
			  $totaltax += ($row['debit']*$row['currencyrate']);
			  $symbol = $row['symbol'];
			  $oldcbno=$row['cashbankno'];
		$this->pdf->CheckPageBreak(0);
		  		  }
				  $total= $totaldebit-$totalcredit;
				  $this->pdf->Row(array(
		'',
		'',
		'',
		'',
		'',
		'Total',
		'',
		'',
		Yii::app()->numberFormatter->formatCurrency($totaldebit,$symbol),
		Yii::app()->numberFormatter->formatCurrency($totalcredit,$symbol),	
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

<?php

class ReportpoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'reportpo';

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
	  		$purchasingorg=new Purchasingorg('search');
	  $purchasingorg->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasingorg']))
		$purchasingorg->attributes=$_GET['Purchasingorg'];
      $paymentmethod=new Paymentmethod('search');
	  $paymentmethod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Paymentmethod']))
		$paymentmethod->attributes=$_GET['Paymentmethod'];

		$purchasinggroup=new Purchasinggroup('search');
	  $purchasinggroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Purchasinggroup']))
		$purchasinggroup->attributes=$_GET['Purchasinggroup'];

		$supplier=new Supplier('search');
	  $supplier->unsetAttributes();  // clear any default values
	  if(isset($_GET['Supplier']))
		$supplier->attributes=$_GET['Supplier'];

		$podetail=new Podetail('search');
	  $podetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Podetail']))
		$podetail->attributes=$_GET['Podetail'];

	$product=new Prmaterial('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$product->attributes=$_GET['Prmaterial'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$currency=new Currency('search');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];

		$sloc=new Sloc('search');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$tax=new Tax('search');
	  $tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$tax->attributes=$_GET['Tax'];

		$model=new Poheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Poheader']))
			$model->attributes=$_GET['Poheader'];
			
			if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'purchasingorg'=>$purchasingorg,
			'purchasinggroup'=>$purchasinggroup,
            'paymentmethod'=>$paymentmethod,
			'supplier'=>$supplier,
			'podetail'=>$podetail,
			'product'=>$product,
			'unitofmeasure'=>$unitofmeasure,
			'currency'=>$currency,
			'sloc'=>$sloc,
			'tax'=>$tax,
                    'podetail'=>$podetail
		));
	}
    
     public function actionDownload()
	{
	  parent::actionDownload();
		if ($_GET['id'] !== '') {
				$sql = "update poheader set printke = ifnull(printke,0) + 1 
	  where poheaderid = ".$_GET['id'];
		}	  
	  $command=$this->connection->createCommand($sql);
	  $command->execute();
	  $sql = "select b.fullname, a.pono, a.docdate,b.addressbookid,a.poheaderid,c.paymentname,a.headernote,a.printke
      from poheader a
      left join addressbook b on b.addressbookid = a.addressbookid
      left join paymentmethod c on c.paymentmethodid = a.paymentmethodid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.poheaderid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
$this->pdf->isheader=false;
	  $this->pdf->title='Purchase Order';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',8);
	  $this->pdf->isprint=true;

    foreach($dataReader as $row)
    {
	$this->pdf->printke = $row['printke'];
      $sql1 = "select b.addresstypename, a.addressname, c.cityname, a.phoneno, a.faxno
        from address a
        left join addresstype b on b.addresstypeid = a.addresstypeid
        left join city c on c.cityid = a.cityid
        where addressbookid = ".$row['addressbookid'].
        " order by addressid ".
        " limit 1";
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      foreach($dataReader1 as $row1)
      {
	  $sql2 = "select a.addresscontactname, a.phoneno, a.mobilephone
        from addresscontact a
        where addressbookid = ".$row['addressbookid'].
        " order by addresscontactid ".
        " limit 1";
      $command2=$this->connection->createCommand($sql2);
      $dataReader2=$command2->queryAll();
	  $contact = '';

      foreach($dataReader2 as $row2)
      {
		$contact = $row2['addresscontactname'];
	  }
        $this->pdf->setFont('Arial','B',8);
        $this->pdf->Rect(10,60,195,40);
        $this->pdf->setFont('Arial','',8);
        $this->pdf->text(15,65,'Supplier');$this->pdf->text(40,65,': '.$row['fullname']);
        $this->pdf->text(15,70,'Attention');$this->pdf->text(40,70,': '.$contact);
        $this->pdf->text(15,75,'Address');$this->pdf->text(40,75,': '.$row1['addressname']);
        $this->pdf->text(15,80,'Phone');$this->pdf->text(40,80,': '.$row1['phoneno']);
        $this->pdf->text(15,85,'Fax');$this->pdf->text(40,85,': '.$row1['faxno']);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->text(120,65,'Purchase Order No ');$this->pdf->text(150,65,$row['pono']);
      $this->pdf->text(120,70,'PO Date ');$this->pdf->text(150,70,date(Yii::app()->params['dateviewfromdb'], strtotime($row['docdate'])));

      }

      $sql1 = "select a.poheaderid,c.uomcode,a.poqty,a.delvdate,a.netprice,(poqty * netprice + (taxvalue * poqty * netprice) / 100) as total,b.productname,
        d.symbol,d.i18n,e.taxvalue,a.itemtext
        from podetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        left join currency d on d.currencyid = a.currencyid
        left join tax e on e.taxid = a.taxid
        where poheaderid = ".$row['poheaderid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $total = 0;
      $this->pdf->sety($this->pdf->gety()+80);
      $this->pdf->setFont('Arial','B',7);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(15,10,50,18,23,26,18,35));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array('Qty','Units','Item', 'Unit Price','Tax','Total','Delivery Date','Remarks');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',7);
      $this->pdf->coldetailalign = array('R','C','L','R','R','R','R','L');
	  $symbol = '';
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array(
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['poqty']),
			$row1['uomcode'],
			iconv("UTF-8", "ISO-8859-1", $row1['productname']),
            Yii::app()->numberFormatter->formatCurrency($row1['netprice'], $row1['symbol']),
			Yii::app()->numberFormatter->formatCurrency(($row1['taxvalue']*$row1['netprice']*$row1['poqty'])/100, $row1['symbol']),
            Yii::app()->numberFormatter->formatCurrency($row1['total'], $row1['symbol']),
			date(Yii::app()->params['dateviewfromdb'], strtotime($row1['delvdate'])),
			$row1['itemtext']));
        $total = $row1['total'] + $total;
$symbol = $row1['symbol'];
      }
	  $this->pdf->row(array('','','','','Total',
            Yii::app()->numberFormatter->formatCurrency($total,$symbol),'',''));
	  $this->pdf->title='';
	  $this->pdf->checknewpage(100);
		$this->pdf->sety($this->pdf->gety()+5);
	  $this->pdf->setFont('Arial','BU',8);
	  $this->pdf->text(10,$this->pdf->gety()+5,'TERM OF CONDITIONS');

		$this->pdf->sety($this->pdf->gety()+10);
      $this->pdf->setFont('Arial','B',7);
      $this->pdf->colalign = array('C','C');
      $this->pdf->setwidths(array(50,130));
	  $this->pdf->iscustomborder = false;
      $this->pdf->setbordercell(array('none','none'));
	  $this->pdf->colheader = array('','');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L');
	  
	  $this->pdf->setFont('Arial','',8);
	  $this->pdf->row(array(
		'Material Certificate',
		'YES [ DIKIRIM BERSAMAAN DENGAN DATANGNYA BARANG ]'
	  ));
	  $this->pdf->row(array(
		'Manual Book / Catalogue',
		'Yes / No'
	  ));
	  $this->pdf->row(array(
		'Guarantee',
		'6 Months / 12 Months'
	  ));
	  $this->pdf->row(array(
		'Delivery Condition',
		'Return if not accepted without any charge'
	  ));
	  $this->pdf->row(array(
		'Payment Schedule',
		'Every 3th Friday'
	  ));
	  $this->pdf->row(array(
		'Payment Term',
		$row['paymentname']
	  ));
	  $this->pdf->row(array(
		'Note:',
		$row['headernote']
	  ));
	  
	 $this->pdf->setFont('Arial','',7);
	 $company = Company::model()->findbysql('select * from company limit 1');
	 $this->pdf->CheckPageBreak(60);
	  $this->pdf->sety($this->pdf->gety()+5);
      $this->pdf->text(10,$this->pdf->gety()+5,'Thanking you and assuring our best attention we remain.');
      $this->pdf->text(10,$this->pdf->gety()+10,'Sincerrely Yours');
      $this->pdf->text(10,$this->pdf->gety()+15,$company->companyname);$this->pdf->text(135,$this->pdf->gety()+15,'Confirmed and Accepted by Supplier');
	  $this->pdf->setFont('Arial','B',8);
      $this->pdf->text(10,$this->pdf->gety()+35,'TEDDY SUJARWANTO');
      $this->pdf->text(10,$this->pdf->gety()+36,'____________________');$this->pdf->text(135,$this->pdf->gety()+36,'__________________________');
	  $this->pdf->setFont('Arial','',7);
      $this->pdf->text(10,$this->pdf->gety()+40,'Director');
      $this->pdf->text(10,$this->pdf->gety()+45,'cc : Finance & Purchasing Manager');

	  $this->pdf->setFont('Arial','BU',7);
	  $this->pdf->text(10,$this->pdf->gety()+55,'#Note: Mohon tidak memberikan gift atau uang kepada staff kami#');
	  $this->pdf->setFont('Arial','',7);
	  $this->pdf->text(10,$this->pdf->gety()+60,'NAMA PKP : '.$company->companyname);
	  $this->pdf->text(10,$this->pdf->gety()+65,'NPWP : '.$company->taxno);
	  $this->pdf->text(10,$this->pdf->gety()+70,'ALAMAT PKP : '.$company->address);
    }
	  $this->pdf->Output();
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Reportpo::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='poheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

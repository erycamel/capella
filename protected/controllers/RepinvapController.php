<?php

class RepinvapController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'repinvap';

	public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpservice'; break;
				case 4 : $this->txt = '_helpservicemodif'; break;
				case 5 : $this->txt = '_helppic'; break;
				case 6 : $this->txt = '_helppicmodif'; break;
				case 7 : $this->txt = '_helplocation'; break;
				case 8 : $this->txt = '_helplocationmodif'; break;
				case 9 : $this->txt = '_helpdocument'; break;
				case 10 : $this->txt = '_helpdocumentmodif'; break;
				case 11 : $this->txt = '_helpnetwork'; break;
				case 12 : $this->txt = '_helpnetworkmodif'; break;
			}
		}
		parent::actionHelp();
	}

	public $invoicedet,$invoiceacc;

	public function lookupdata()
	{
		$this->invoicedet=new Invoicedet('search');
		$this->invoicedet->unsetAttributes();  
		if(isset($_GET['Invoicedet']))
		$this->invoicedet->attributes=$_GET['Invoicedet'];
		
		$this->invoiceacc=new Invoiceacc('search');
		$this->invoiceacc->unsetAttributes();  
		if(isset($_GET['Invoiceacc']))
		$this->invoiceacc->attributes=$_GET['Invoiceacc'];

	}
	
	public function actionDownload()
	{
	  parent::actionDownload();
	   $sql = "select journalno,invoiceid,invoiceno,f.pono,fullname,amount,symbol,rate,invoicedate,a.headernote, taxvalue,
	   (select addressname from address e where e.addressbookid = f.addressbookid limit 1) as addressname,
	   (select cityname from address e left join city f on f.cityid = e.cityid where e.addressbookid = f.addressbookid limit 1) as cityname
		from invoice a 
		left join poheader f on f.poheaderid = a.poheaderid
		left join currency b on b.currencyid = a.currencyid 
		left join tax c on c.taxid = a.taxid 
		left join addressbook d on d.addressbookid = f.addressbookid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.invoiceid = ".$_GET['id'];
		}
		$sql = $sql . " order by invoiceid ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->title='Journal Adjustment';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',8);

    foreach($dataReader as $row)
    {
		$this->pdf->rect(10,60,190,30);
		$this->pdf->setFont('Arial','B',10);
		$this->pdf->text(20,$this->pdf->gety()+5,'PO No: '.$row['pono']);
		$this->pdf->text(150,$this->pdf->gety()+5,'Tanggal: '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
		$this->pdf->text(20,$this->pdf->gety()+10,'J.NO: '.$row['journalno']);
		$this->pdf->text(20,$this->pdf->gety()+15,'Note: '.$row['headernote']);
	  
      $sql1 = "select accountcode, accountname,debit,credit,a.currencyid,currencyrate,a.description,symbol
        from invoiceacc a
		left join currency b on b.currencyid = a.currencyid
		left join account d on d.accountid = a.accountid 
        where invoiceid = ".$row['invoiceid'] . " order by debit desc ";
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->SetY($this->pdf->gety()+30);
		$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(20,30,30,30,30,50));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array('Account Code','Account Name','Debit','Credit','Rate','Description');
      $this->pdf->RowHeader();
		$this->pdf->setFont('Arial','',8);
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
      $this->pdf->coldetailalign = array('L','L','R','R','R','L');
      foreach($dataReader1 as $row1)
      {

        $this->pdf->row(array($row1['accountcode'],
		$row1['accountname'],
			Yii::app()->numberFormatter->formatCurrency($row1['debit'],$row1['symbol']),
			Yii::app()->numberFormatter->formatCurrency($row1['credit'],$row1['symbol']),
			Yii::app()->numberFormatter->formatCurrency($row1['currencyrate'],$row1['symbol']),
			$row1['description']
));
      }
      $this->pdf->setbordercell(array('LTB','TB','TB','TB','TB','TB','LTRB'));
      $this->pdf->setaligns(array('R','L','R','C','R','R','R'));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
$sql1 = "select sum(ifnull(a.debit,0)) as amount
        from invoiceacc a
		left join currency b on b.currencyid = a.currencyid
		left join account d on d.accountid = a.accountid 
        where invoiceid = ".$row['invoiceid'] . " order by debit desc ";
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();
foreach($dataReader1 as $row1)
      {
$this->pdf->text(10,$this->pdf->gety()+5,'INWORD : '.strtoupper($this->eja($row1['amount'])));
}
		
		$this->pdf->setFont('Arial','',10);
	$this->pdf->text(10,$this->pdf->gety()+35,'Prepared By');$this->pdf->text(50,$this->pdf->gety()+35,'Checked By');
      $this->pdf->text(10,$this->pdf->gety()+55,'(------------------)');$this->pdf->text(50,$this->pdf->gety()+55,'(------------------)');
	$this->pdf->text(90,$this->pdf->gety()+35,'Approved By');$this->pdf->text(130,$this->pdf->gety()+35,'Acknowladge By');
      $this->pdf->text(90,$this->pdf->gety()+55,'(------------------)');$this->pdf->text(130,$this->pdf->gety()+55,'(------------------)');
	$this->pdf->text(175,$this->pdf->gety()+35,'Received By');
      $this->pdf->text(175,$this->pdf->gety()+55,'(------------------)');
	
    }
	  $this->pdf->Output();
	  }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
	  $this->lookupdata();
		$model=new Invoice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Invoice']))
			$model->attributes=$_GET['Invoice'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
				  'invoicedet'=>$this->invoicedet,
				  'invoiceacc'=>$this->invoiceacc
		));
	}

	public function actionIndexinvoicedet()
	{
		$this->lookupdata();
	  $this->renderPartial('indexinvoicedet',
		array('invoicedet'=>$this->invoicedet));
	  Yii::app()->end();
	}
	
	public function actionIndexinvoiceacc()
	{
		$this->lookupdata();
	  $this->renderPartial('indexinvoiceacc',
		array('invoiceacc'=>$this->invoiceacc));
	  Yii::app()->end();
	}
		
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Invoice::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelinvoicedet($id)
	{
		$model=Invoicedet::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModeldetailinvoiceacc($id)
	{
		$model=Invoiceacc::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoiceap-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoiceapservice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

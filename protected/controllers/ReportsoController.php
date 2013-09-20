<?php

class ReportsoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'soheader';

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

	public $sodetail;
		
	public function lookupdata()
	{
		$this->sodetail=new Sodetail('search');
	  $this->sodetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sodetail']))
		$this->sodetail->attributes=$_GET['Sodetail'];
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
	  		$this->lookupdata();

		$model=new Soheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Soheader']))
			$model->attributes=$_GET['Soheader'];
			
			if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'sodetail'=>$this->sodetail,
		));
	}

	public function actionIndexDetail()
	{
	  		$sodetail=new Sodetail('searchbysoheaderid');
		$sodetail->unsetAttributes();  // clear any default values
		if(isset($_GET['Sodetail']))
			$sodetail->attributes=$_GET['Sodetail'];
if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('indexdetail',array(
			'sodetail'=>$sodetail
		));
	}
    
    public function actionDownload()
	{
	  parent::actionDownload();
	  $sql = "select a.soheaderid,a.sono, b.fullname as customername, a.sodate, e.currencyname, c.paymentname, a.addressbookid, a.headernote
      from soheader a
      left join addressbook b on b.addressbookid = a.addressbookid
	  left join addressbook d on d.addressbookid = a.employeeid
      left join paymentmethod c on c.paymentmethodid = a.paymentmethodid
		left join currency e on e.currencyid = a.currencyid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.soheaderid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

	  $this->pdf->title='Sales Order';
	  $this->pdf->AddPage('P');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    foreach($dataReader as $row)
    {
        $this->pdf->Rect(10,65,180,25);
      $this->pdf->text(120,$this->pdf->gety()+10,'Sales Order No ');$this->pdf->text(150,$this->pdf->gety()+10,$row['sono']);
      $this->pdf->text(120,$this->pdf->gety()+15,'SO Date ');$this->pdf->text(150,$this->pdf->gety()+15,date(Yii::app()->params['dateviewfromdb'], strtotime($row['sodate'])));
      $this->pdf->text(120,$this->pdf->gety()+20,'Payment ');$this->pdf->text(150,$this->pdf->gety()+20,$row['paymentname']);

	  	if ($row['addressbookid'] > 0) 
	{
      $sql1 = "select b.addresstypename, a.addressname, c.cityname, a.phoneno
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
        $this->pdf->setFont('Arial','B',8);
        $this->pdf->text(15,$this->pdf->gety()+10,'Customer');
        $this->pdf->setFont('Arial','',8);
        $this->pdf->text(15,$this->pdf->gety()+15,'Name');$this->pdf->text(30,$this->pdf->gety()+15,': '.$row['customername']);
        $this->pdf->text(15,$this->pdf->gety()+20,'Address');$this->pdf->text(30,$this->pdf->gety()+20,': '.$row1['addressname']);
        $this->pdf->text(15,$this->pdf->gety()+25,'Phone');$this->pdf->text(30,$this->pdf->gety()+25,': '.$row1['phoneno']);
      }

      $sql1 = "select a.soheaderid,c.uomcode,a.qty,a.price,(qty * price) + (e.taxvalue * qty * price / 100) as total,b.productname,
        d.symbol,d.i18n,(e.taxvalue * qty * price / 100) as taxvalue
        from sodetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        left join currency d on d.currencyid = a.currencyid
        left join tax e on e.taxid = a.taxid
        where soheaderid = ".$row['soheaderid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $total = 0;
      $this->pdf->sety($this->pdf->gety()+30);
      $this->pdf->setFont('Arial','B',7);
      $this->pdf->colalign = array('C','C','C','C','C','C');
      $this->pdf->setwidths(array(20,15,55,30,30,30));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array('Qty','Units','Description', 'Unit Price','Tax','Total');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('R','C','L','R','R','R');
      $this->pdf->setFont('Arial','',7);
      foreach($dataReader1 as $row1)
      {
        Yii::app()->setLanguage($row1['i18n']);
        $this->pdf->row(array($row1['qty'],$row1['uomcode'],$row1['productname'],
            Yii::app()->numberFormatter->formatCurrency($row1['price'], $row1['symbol']),
			Yii::app()->numberFormatter->formatCurrency($row1['taxvalue'], $row1['symbol']),
            Yii::app()->numberFormatter->formatCurrency($row1['total'], $row1['symbol'])));
        $total = $row1['total'] + $total;
      }
	  $this->pdf->row(array('','','','','Total',
            Yii::app()->numberFormatter->formatCurrency($total, $row1['symbol'])));

	  $this->pdf->text(10,$this->pdf->gety()+5,'Note');
	  $this->pdf->text(10,$this->pdf->gety()+10,$row['headernote']);

	  
	  $this->pdf->setFont('Arial','B',8);
      $this->pdf->text(10,$this->pdf->gety()+55,'Approved By');$this->pdf->text(100,$this->pdf->gety()+55,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+75,'___________________ ');$this->pdf->text(100,$this->pdf->gety()+75,'___________________');
	  }
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
		$model=Soheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Sodetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='soheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

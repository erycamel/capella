<?php

class FakturpajakController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'fakturpajak';

public $invoice;
	
	public function lookupdata()
	{
	  $this->invoice=new Invoice('searchwfstatus');
	  $this->invoice->unsetAttributes();  // clear any default values
	  if(isset($_GET['Invoice']))
		$this->invoice->attributes=$_GET['Invoice'];
	}


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
	
/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Fakturpajak;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				'invoice'=>$this->invoice), true)
			  ));
		  Yii::app()->end();
	  }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
	  parent::actionUpdate();
	  $this->lookupdata();
	  $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
	  if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
		  echo CJSON::encode(array(
			  'status'=>'success',
'fakturpajakid'=>$model->fakturpajakid,
			  'invoiceid'=>$model->invoiceid,
			  'invoiceno'=>$model->invoice->invoiceno,
			  'fakturpajakno'=>$model->fakturpajakno,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
				'invoice'=>$this->invoice), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
	  $this->DeleteLockCloseForm($this->menuname, $_POST['Fakturpajak'], $_POST['Fakturpajak']['fakturpajakid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Fakturpajak']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Fakturpajak']['fakturpajakno'],'emptyfakturpajakno','emptystring'),
                array($_POST['Fakturpajak']['invoiceid'],'emptyinvoiceid','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Fakturpajak'];
		if ((int)$_POST['Fakturpajak']['fakturpajakid'] > 0)
		{
		  $model=$this->loadModel($_POST['Fakturpajak']['fakturpajakid']);
		  $model->fakturpajakno = $_POST['Fakturpajak']['fakturpajakno'];
		  $model->invoiceid = $_POST['Fakturpajak']['invoiceid'];
		}
		else
		{
		  $model = new Fakturpajak();
		  $model->attributes=$_POST['Fakturpajak'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname,$_POST['Fakturpajak']['fakturpajakid']);
              $this->GetSMessage('aaccinsertsuccess');
            }
            else
            {
              $this->GetMessage($model->getErrors());
            }
          }
          catch (Exception $e)
          {
            $this->GetMessage($e->getMessage());
          }
        }
	  }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
      parent::actionDelete();
      $id=$_POST['id'];
      foreach($id as $ids)
      {
        $model=$this->loadModel($ids);
        $model->recordstatus=0;
        $model->save();
      }
      echo CJSON::encode(array(
              'status'=>'success',
              'div'=>'Data deleted'
              ));
      Yii::app()->end();
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
 $this->lookupdata();
		$model=new Fakturpajak('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Fakturpajak']))
			$model->attributes=$_GET['Fakturpajak'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,'invoice'=>$this->invoice
		));
	}

	
	public function actionDownload()
	{
	  parent::actionDownload();
	   $sql = "select b.invoiceid,a.fakturpajakno,fullname,invoicedate,b.invoiceno,
				(select addressname as custaddress from address z where z.addressbookid = c.addressbookid order by z.addressid desc limit 1) as addressname,
				(select cityname from city y left join address x on x.cityid = y.cityid where x.addressbookid = c.addressbookid limit 1) as cityname,
				c.taxno,d.taxvalue,
				(select companyname from company limit 1) as companyname,
				(select address from company limit 1) as companyaddressname,
				(select cityname from company w  limit 1) as companycityname,
				(select taxno from company limit 1) as companytaxno
			from fakturpajak a
			left join invoice b on b.invoiceid = a.invoiceid
			left join soheader e on e.soheaderid = b.soheaderid
			left join addressbook c on c.addressbookid = e.addressbookid 
			left join tax d on d.taxid = b.taxid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.fakturpajakid = ".$_GET['id'];
		}
		$sql = $sql . " order by fakturpajakid";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->isheader = false;
	  $this->pdf->iscustomborder=true;
	  $this->pdf->AddPage('P');

    foreach($dataReader as $row)
    {
      $this->pdf->setFont('Arial','B',12);
	  $this->pdf->rect(10,20,180,15);
      $this->pdf->text(90,30,'FAKTUR PAJAK');

      $this->pdf->setFont('Arial','',8);
	  $this->pdf->rect(10,35,180,6);
      $this->pdf->text(12,39,'Kode dan Nomor Seri Faktur Pajak : '.$row['fakturpajakno']);
      $this->pdf->text(140,39,'Invoice No : '.$row['invoiceno']);
	  $this->pdf->rect(10,41,180,6);
      $this->pdf->text(12,45,'Pengusaha Kena Pajak');
	  $this->pdf->rect(10,47,180,20);
      $this->pdf->text(12,51,'N a m a');$this->pdf->text(50,51,':');$this->pdf->text(60,51,$row['companyname']);
      $this->pdf->text(12,56,'A l a m a t');$this->pdf->text(50,56,':');$this->pdf->text(60,56,$row['companyaddressname']);
      $this->pdf->text(12,61,'');$this->pdf->text(50,61,'');$this->pdf->text(60,61,$row['companycityname']);
      $this->pdf->text(12,66,'NPWP');$this->pdf->text(50,66,':');$this->pdf->text(60,66,$row['companytaxno']);
	  $this->pdf->rect(10,67,180,6);
      $this->pdf->text(12,71,'Pembeli Barang Kena Pajak / Penerima Jasa Kena Pajak');
	  $this->pdf->rect(10,73,180,22);
      $this->pdf->text(12,78,'N a m a');$this->pdf->text(50,78,':');$this->pdf->text(60,78,$row['fullname']);
      $this->pdf->text(12,83,'A l a m a t');$this->pdf->text(50,83,':');$this->pdf->text(60,83,$row['addressname']);
      $this->pdf->text(12,88,'');$this->pdf->text(50,88,'');$this->pdf->text(60,88,$row['cityname']);
      $this->pdf->text(12,93,'NPWP');$this->pdf->text(50,93,':');$this->pdf->text(60,93,$row['taxno']);

	  
       $sql1 = "select d.productname,qty,uomcode,price*qty as price,symbol,rate,a.description,
	    price * qty * ".$row['taxvalue']. "/100 as taxvalue
        from invoicedet a
		left join currency b on b.currencyid = a.currencyid
		left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
		left join product d on d.productid = a.productid
        where invoiceid = ".$row['invoiceid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->SetY($this->pdf->gety()+85);
		$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign=array('C','C','C');
      $this->pdf->setwidths(array(15,95,70));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array(
		'No Urut',
		'Nama Barang Kena Pajak / Jasa Kena Pajak',
		'Harga Jual/Penggantian/Uang Muka/Termin');
      $this->pdf->RowHeader();
		$this->pdf->setFont('Arial','',8);
      $this->pdf->coldetailalign=array('C','L','R');
      $this->pdf->setbordercell(array('LR','LR','LR'));
	  $total = 0;$i=0;$symbol="";
      foreach($dataReader1 as $row1)
      {
		$i = $i+1;
        $this->pdf->row(array($i,$row1['productname'] . $row1['description'],
			Yii::app()->numberFormatter->formatCurrency($row1['price'],$row1['symbol'])));
		$total = $total + ($row1['price']);
		$symbol = $row1['symbol'];
      }
	  for ($i=0;$i<10;$i++)
	  {
        $this->pdf->row(array(' ',' ',' '));
	  }
      $this->pdf->setbordercell(array('LTB','TRB','LTRB'));
        $this->pdf->row(array('','Harga Jual/Penggantian/Uang Muka/Termin**)',
			Yii::app()->numberFormatter->formatCurrency($total,$symbol)));
        $this->pdf->row(array('','Dikurangi Potongan Harga',
			'-'));
        $this->pdf->row(array('','Dikurangi Uang Muka yang telah diterima',
			'-'));
        $this->pdf->row(array('','Dasar Pengenaan Pajak',
			Yii::app()->numberFormatter->formatCurrency($total,$symbol)));
        $this->pdf->row(array('','PPN = 10% x Dasar Pengenaan Pajak',
			Yii::app()->numberFormatter->formatCurrency($total*$row['taxvalue']/100,$symbol)));

		$this->pdf->sety($this->pdf->gety()+10);
      $this->pdf->text(12,$this->pdf->gety(),'Pajak Penjualan Atas Barang Mewah');
		$this->pdf->text(150,$this->pdf->gety(),'Tanggal: '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['invoicedate'])));
		$this->pdf->sety($this->pdf->gety()+10);
	        $this->pdf->setaligns(array('C','C','C'));
      $this->pdf->setwidths(array(15,15,15));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB'));
      $this->pdf->Row(array(
		'Tarif',
		'DPP',
		'PPnBM'));
      $this->pdf->setbordercell(array('LR','LR','LR'));
      $this->pdf->Row(array(
		'.........%',
		'Rp........',
		'Rp........'));
      $this->pdf->Row(array(
		'.........%',
		'Rp........',
		'Rp........'));
      $this->pdf->Row(array(
		'.........%',
		'Rp........',
		'Rp........'));
      $this->pdf->Row(array(
		'.........%',
		'Rp........',
		'Rp........'));
      $this->pdf->setbordercell(array('LTB','RTB','LRTB'));
      $this->pdf->Row(array(
		'Jumlah',
		'',
		'Rp........'));

	      $this->pdf->text(12,$this->pdf->gety()+20,'**) Coret yang tidak perlu');
  
	      $this->pdf->text(150,$this->pdf->gety(),'TEDDY SUJARWANTO');
	      $this->pdf->text(150,$this->pdf->gety()+5,'Direktur');

			//$this->pdf->AddPage('P');
			$this->pdf->CheckPageBreak(0);
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
		$model=Fakturpajak::model()->findByPk((int)$id);
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

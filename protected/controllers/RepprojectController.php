<?php

class RepprojectController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'repproject';

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

	public $projectservice, $projectpic, $projectlocation, $projectdocument, $projectnetwork,$projectemp,$srftime;

	public function lookupdata()
	{
		$this->projectservice=new Projectservice('search');
	  $this->projectservice->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectservice']))
		$this->projectservice->attributes=$_GET['Projectservice'];

		$this->projectpic=new Projectpic('search');
	  $this->projectpic->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectpic']))
		$this->projectpic->attributes=$_GET['Projectpic'];
		
		$this->projectlocation=new Projectlocation('search');
	  $this->projectlocation->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectlocation']))
		$this->projectlocation->attributes=$_GET['Projectlocation'];
		
		$this->projectdocument=new Projectdocument('search');
	  $this->projectdocument->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectdocument']))
		$this->projectdocument->attributes=$_GET['Projectdocument'];
		
		$this->projectnetwork=new Projectnetwork('search');
	  $this->projectnetwork->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectnetwork']))
		$this->projectnetwork->attributes=$_GET['Projectnetwork'];
		
		$this->projectemp=new Projectemp('search');
	  $this->projectemp->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projectemp']))
		$this->projectemp->attributes=$_GET['Projectemp'];
		
		$this->srftime=new Srftime('search');
	  $this->srftime->unsetAttributes();  // clear any default values
	  if(isset($_GET['Srftime']))
		$this->srftime->attributes=$_GET['Srftime'];
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
	  $this->lookupdata();
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
					'projectservice'=>$this->projectservice,
					'projectpic'=>$this->projectpic,
										'projectlocation'=>$this->projectlocation,
										'projectdocument'=>$this->projectdocument,
										'projectnetwork'=>$this->projectnetwork,
										'projectemp'=>$this->projectemp,
										'srftime'=>$this->srftime
		));
	}

	public function actionIndexservice()
	{
		$this->lookupdata();
	  $this->renderPartial('indexservice',
		array('projectservice'=>$this->projectservice));
	  Yii::app()->end();
	}
	
	public function actionIndexpic()
	{
		$this->lookupdata();
	  $this->renderPartial('indexpic',
		array('projectpic'=>$this->projectpic));
	  Yii::app()->end();
	}
	
	public function actionIndexdocument()
	{
		$this->lookupdata();
	  $this->renderPartial('indexdocument',
		array('projectdocument'=>$this->projectdocument));
	  Yii::app()->end();
	}
	
	public function actionIndexlocation()
	{
		$this->lookupdata();
	  $this->renderPartial('indexlocation',
		array('projectlocation'=>$this->projectlocation));
	  Yii::app()->end();
	}
	
	public function actionDownload()
	{
		parent::actionDownload();
			$sql = "select a.projectid,a.projectno,a.projectdate,c.description,b.projectname,b.contractno,b.addressbookid,a.serviceno
			  from project a 
			  inner join soheader b on b.soheaderid = a.soheaderid
			  inner join projecttype c on c.projecttypeid = b.projecttypeid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.projectid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
			$this->pdf->title='Service Request Form';
			$this->pdf->AddPage('P');
			$this->pdf->setFont('Arial','B',12);

			foreach($dataReader as $row)
			{
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,30,180,8,'DF');
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->text(20,35,'Data Utama');
				$this->pdf->setfillcolor(255,255,255);
				$this->pdf->rect(15,38,180,30,'D');
				$this->pdf->text(20,43,'Tgl SRF');$this->pdf->text(40,43,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['projectdate'])));
				$this->pdf->text(20,50,'No SRF');$this->pdf->text(40,50,': '.$row['projectno']);
				$this->pdf->text(20,55,'Nama Proyek');$this->pdf->text(40,55,': '.$row['projectname']);
				$this->pdf->text(20,60,'Jenis Proyek');$this->pdf->text(40,60,': '.$row['description']);
				$this->pdf->text(20,65,'No SPK / LOI');$this->pdf->text(40,65,': '.$row['contractno']);
				$this->pdf->text(80,65,'No Service');$this->pdf->text(100,65,': '.$row['serviceno']);


				$sql1 = "select b.requestforname,a.dateofdelivery,a.dateofdeliverydevice,a.estimatedelivery,a.installdate,a.onlinedate,c.contracttermname
					  from projectservice a 
					  inner join requestfor b on b.requestforid = a.requestforid
					  inner join contractterm c on c.contracttermid = a.contracttermid
					  where projectid = ". $row['projectid'];
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();

				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,70,180,8,'DF');
				$this->pdf->text(20,75,'Data Permintaan');
				$this->pdf->setFont('Arial','B',6);
				$this->pdf->setaligns(array('C','C','C','C','C','C','C'));
				$this->pdf->setwidths(array(40,20,30,20,20,20,30));
				$this->pdf->setFont('Arial','',6);
				$this->pdf->setxy(15,78);
				$this->pdf->Row(array('Request For','Date of Delivery','Date of Delivery Device','Estimate Delivery','Install Date','Online Date','Contract Term'));
				$this->pdf->setaligns(array('L','L','L','L','L','L','L'));
				$this->pdf->setx(15);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->setx(15);
					$this->pdf->row(array($row1['requestforname'],
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['dateofdelivery'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['dateofdeliverydevice'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['estimatedelivery'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['installdate'])),						
						date(Yii::app()->params['dateviewfromdb'], strtotime($row1['onlinedate'])),			
						$row1['contracttermname']));
				}
				
				$sql1 = "select fullname,b.addressname, c.cityname, d.provincename, b.phoneno
					  from addressbook a 
					  left join address b on b.addressbookid = a.addressbookid
					  left join city c on c.cityid = b.cityid
					  left join province d on d.provinceid = c.provinceid
					  where a.addressbookid = ". $row['addressbookid'] . " limit 1 ";
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				
				$this->pdf->sety($this->pdf->gety()+2);
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->rect(15,$this->pdf->gety(),180,8,'DF');
				$this->pdf->text(20,$this->pdf->gety()+5,'Informasi Perusahaan');
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,$this->pdf->gety()+8,180,30,'D');
				$this->pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->text(20,$this->pdf->gety()+15,'Nama Perusahaan');$this->pdf->text(40,$this->pdf->gety()+15,': '.$row1['fullname']);
					$this->pdf->text(20,$this->pdf->gety()+20,'Alamat ');$this->pdf->text(40,$this->pdf->gety()+20,': '.$row1['addressname']);
					$this->pdf->text(20,$this->pdf->gety()+25,'Kota Perusahaan');$this->pdf->text(40,$this->pdf->gety()+25,': '.$row1['cityname']);
					$this->pdf->text(20,$this->pdf->gety()+30,'Propinsi / Negara');$this->pdf->text(40,$this->pdf->gety()+30,': '.$row1['provincename']);
					$this->pdf->text(20,$this->pdf->gety()+35,'Nomor Telepon');$this->pdf->text(40,$this->pdf->gety()+30,': '.$row1['phoneno']);
				}
				
				$sql1 = "select picname,picfunction,picemail,picdept,pictelp
					  from projectpic a 
					  where projectid = ". $row['projectid'];
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();

				$this->pdf->setxy(15,$this->pdf->gety()+40);
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,$this->pdf->gety(),180,8,'DF');
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->text(20,$this->pdf->gety()+5,'Data Penanggung Jawab');
				$this->pdf->setxy(15,$this->pdf->gety()+8);
				$this->pdf->setaligns(array('C','C','C','C','C','C','C'));
				$this->pdf->setwidths(array(40,40,30,40,30,60,40));
				$this->pdf->Row(array('Nama','Bagian','No Telp','Email','Fungsi'));
				$this->pdf->setaligns(array('L','L','L','L','L','L','L'));
				$this->pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->setx(15);
					$this->pdf->row(array($row1['picname'],$row1['picdept'],$row1['pictelp'],$row1['picemail'],$row1['picfunction']));
				}
				
				$sql1 = "select b.fullname as originname, c.fullname as destname, a.originaddress,a.destaddress, d.cityname as origincityname,
					  e.cityname as destcityname
					  from projectlocation a 
					  left join addressbook b on b.addressbookid = a.originid
					  left join addressbook c on c.addressbookid = a.destid
					  left join city d on d.cityid = a.origincityid
					  left join city e on e.cityid = a.destcityid
					  where a.projectid = ". $row['projectid'] . " limit 1 ";
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				
				$this->pdf->setxy(15,$this->pdf->gety()+3);
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->rect(15,$this->pdf->gety(),180,8,'DF');
				$this->pdf->text(20,$this->pdf->gety()+5,'Data Lokasi');
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,$this->pdf->gety()+8,60,8,'DF');
				$this->pdf->rect(75,$this->pdf->gety()+8,60,8,'DF');
				$this->pdf->rect(135,$this->pdf->gety()+8,60,8,'DF');
				$this->pdf->text(20,$this->pdf->gety()+13,'Keterangan');
				$this->pdf->text(80,$this->pdf->gety()+13,'Asal');
				$this->pdf->text(140,$this->pdf->gety()+13,'Tujuan');
				$this->pdf->rect(15,$this->pdf->gety()+16,60,15,'D');
				$this->pdf->rect(75,$this->pdf->gety()+16,60,15,'D');
				$this->pdf->rect(135,$this->pdf->gety()+16,60,15,'D');
				$this->pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->text(20,$this->pdf->gety()+19,'Perusahaan');$this->pdf->text(80,$this->pdf->gety()+19,$row1['originname']);$this->pdf->text(140,$this->pdf->gety()+19,$row1['destname']);
					$this->pdf->text(20,$this->pdf->gety()+24,'Alamat ');$this->pdf->text(80,$this->pdf->gety()+24,$row1['originaddress']);$this->pdf->text(140,$this->pdf->gety()+24,$row1['destaddress']);
					$this->pdf->text(20,$this->pdf->gety()+29,'Kota ');$this->pdf->text(80,$this->pdf->gety()+29,$row1['origincityname']);$this->pdf->text(140,$this->pdf->gety()+29,$row1['destcityname']);
				}
				
				$sql1 = "select a.application,a.technology,a.upstream,a.downstream, b. accessmethodname, a.originipaddress, 
					  a.destipaddress,a.originnetmask,a.destnetmask
					  from projectnetwork a 
					  inner join accessmethod b on b.accessmethodid = a.accessmethodid
					  where a.projectid = ". $row['projectid'] . " limit 1 ";
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				
				$this->pdf->setxy(15,$this->pdf->gety()+35);
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->rect(15,$this->pdf->gety(),180,8,'DF');
				$this->pdf->text(20,$this->pdf->gety()+5,'Spesifikasi Jaringan');
				$this->pdf->setfillcolor(248,244,244);
				$this->pdf->rect(15,$this->pdf->gety()+8,180,50,'D');
				$this->pdf->setFont('Arial','',6);
				foreach($dataReader1 as $row1)
				{
					$this->pdf->text(20,$this->pdf->gety()+13,'Aplikasi');$this->pdf->text(60,$this->pdf->gety()+13,' : '.$row1['application']);
					$this->pdf->text(20,$this->pdf->gety()+18,'Teknologi');$this->pdf->text(60,$this->pdf->gety()+18,' : '.$row1['technology']);
					$this->pdf->text(20,$this->pdf->gety()+23,'Kecepatan Upstream (Kbps)');$this->pdf->text(60,$this->pdf->gety()+23,' : '.$row1['upstream']);
					$this->pdf->text(20,$this->pdf->gety()+28,'Kecepatan Downstream (Kbps)');$this->pdf->text(60,$this->pdf->gety()+28,' : '.$row1['downstream']);
					$this->pdf->text(20,$this->pdf->gety()+33,'Access Method');$this->pdf->text(60,$this->pdf->gety()+33,' : '.$row1['accessmethodname']);
					$this->pdf->text(20,$this->pdf->gety()+38,'IP Address Asal');$this->pdf->text(60,$this->pdf->gety()+38,' : '.$row1['originipaddress']);
					$this->pdf->text(20,$this->pdf->gety()+43,'IP Address Tujuan');$this->pdf->text(60,$this->pdf->gety()+43,' : '.$row1['destipaddress']);
					$this->pdf->text(20,$this->pdf->gety()+48,'Netmask Asal');$this->pdf->text(60,$this->pdf->gety()+48,' : '.$row1['originnetmask']);
					$this->pdf->text(20,$this->pdf->gety()+53,'Netmask Tujuan');$this->pdf->text(60,$this->pdf->gety()+53,' : '.$row1['destnetmask']);
				}
				
				$this->pdf->AddPage('P');
				$this->pdf->text(20,$this->pdf->gety(),'Dengan ini kami menyatakan bahwa informasi yang kami berikan adalah benar adanya dan bisa dipertanggung jawabkan');
				$this->pdf->setFont('Arial','B',8);
				$this->pdf->text(50,$this->pdf->gety()+15,'PEMOHON');
				$this->pdf->text(150,$this->pdf->gety()+15,'PELAKSANA');
				$this->pdf->text(40,$this->pdf->gety()+35,'');
				$this->pdf->text(155,$this->pdf->gety()+35,'');
				$this->pdf->line(40,$this->pdf->gety()+37,80,$this->pdf->gety()+37);
				$this->pdf->line(135,$this->pdf->gety()+37,180,$this->pdf->gety()+37);			
				
				$this->pdf->AddPage('P');
			}
			// me-render ke browser
			$this->pdf->Output();
	}
	
	public function actionDownload1()
  {
  parent::actionDownload();
   $sql = "SELECT a.projectno,c.fullname,a.projectnote,d.servicetypename,a.priceotc,a.priceotr
FROM project a
LEFT JOIN soheader b ON b.soheaderid = a.soheaderid
LEFT JOIN employee c ON c.employeeid = b.employeeid
LEFT JOIN servicetype d ON d.servicetypeid = b.servicetypeid
WHERE a.projectno != '' ";
		
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

    $this->pdf->title='Report All SRF';
		$this->pdf->AddPage('L');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C','C','C','C'));
		$this->pdf->setwidths(array(35,50,50,30,35,35));
		$this->pdf->Row(array('SRF No','Sales','Note','Service Type','Biaya Awal','Biaya Per Bulan'));
		$this->pdf->setaligns(array('C','C','C','C','R','R'));
		foreach($dataReader as $row1)
		{
		  
		  $this->pdf->row(array($row1['projectno'],$row1['fullname'],
		  $row1['projectnote'],$row1['servicetypename'],		  
		   Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['priceotc']),
		  Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['priceotr']),
		  ));

		}
		
		$sql1 = "SELECT sum(a.priceotc) as totalb,sum(a.priceotr) as total
FROM project a
LEFT JOIN soheader b ON b.soheaderid = a.soheaderid
LEFT JOIN employee c ON c.employeeid = b.employeeid
LEFT JOIN servicetype d ON d.servicetypeid = b.servicetypeid
WHERE a.projectno != ''";
		
		$command1=$this->connection->createCommand($sql1);
		$dataReader1=$command1->queryAll();
		foreach($dataReader1 as $row2)
		{
		  $this->pdf->row(array(
				'','','','','Total Pendapatan',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row2['total']),
		  ));

		}
		
		$sql22 = "SELECT a.sono, a.sodate, b.fullname,  a.contractno, a.startdate, a.enddate, a.projectvalue, c.projecttypecode, a.projectname, a.personincharge, 
d.fullname AS employeename, e.currencyname, f.servicetypename
FROM soheader a
LEFT JOIN addressbook b ON b.addressbookid = a.addressbookid
LEFT JOIN projecttype c ON c.projecttypeid = a.projecttypeid
LEFT JOIN employee d ON d.employeeid = a.employeeid
LEFT JOIN currency e ON e.currencyid = a.currencyid
LEFT JOIN servicetype f ON f.servicetypeid = a.servicetypeid 
WHERE a.sono != ''";
		
		$command=$this->connection->createCommand($sql22);
		$dataReader=$command->queryAll();

    $this->pdf->title='Sales Order List';
		$this->pdf->Ln();
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C','C','C','C'));
		$this->pdf->setwidths(array(45,70,50,35,35));
		$this->pdf->Row(array('SO No','Customer','Sales','Service Type','Project Value'));
		$this->pdf->setaligns(array('C','C','C','R','R'));
		foreach($dataReader as $row1)
		{
		  
		  $this->pdf->row(array($row1['sono'],$row1['fullname'],
		  $row1['employeename'],$row1['servicetypename'],
		  Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['projectvalue']),
		  ));

		}
		
		$sql221 = "SELECT SUM( projectvalue ) AS total FROM soheader";
		
		$command1=$this->connection->createCommand($sql221);
		$dataReader1=$command1->queryAll();
		foreach($dataReader1 as $row3)
		{
		  $this->pdf->row(array(
				'','','','Total Pendapatan',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row3['total']),
		  ));

		}
		
		
		//untuk total seluruh
		$this->pdf->Ln();
		$tot1 = $row2['total'];
		$tot2 = $row3['total'];
		$tota = $row2['totalb'];
		$totb = $tot1+$tot2;
		$tots = $tot1 + $tot2+$row2['totalb'];
		$this->pdf->row(array('Total Biaya Awal',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$tota)));
		$this->pdf->row(array('Total Perbulan',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$totb)));
		$this->pdf->row(array('Total Penghasilan',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$tots)));
		// me-render ke browser
		$this->pdf->Output();
  }
  
  public function actionDownloaddetailservice()
  {
		parent::actionDownload();
		$sql = "SELECT a.projectno,c.fullname,a.projectnote,d.servicetypename,a.priceotc,a.priceotr
		FROM project a
		LEFT JOIN soheader b ON b.soheaderid = a.soheaderid
		LEFT JOIN employee c ON c.employeeid = b.employeeid
		LEFT JOIN servicetype d ON d.servicetypeid = b.servicetypeid
		WHERE a.projectno != '' and b.servicetypeid=1";
		
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Report SRF Detail Service Type';
		$this->pdf->AddPage('L');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);
		
		$this->pdf->setaligns(array('C','C','C','C','C'));
		$this->pdf->setwidths(array(35,50,50,30,35,35));
		$this->pdf->Row(array('SRF No','Sales','Note','Service Type','Biaya Awal','Biaya Per Bulan'));
		$this->pdf->setaligns(array('C','C','C','C','R','R'));
		foreach($dataReader as $row1)
		{
		  
		  $this->pdf->row(array($row1['projectno'],$row1['fullname'],
		  $row1['projectnote'],$row1['servicetypename'],		  
		   Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['priceotc']),
		  Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['priceotr']),
		  ));

		}
		$this->pdf->Ln();
		$sql1 = "SELECT a.projectno,c.fullname,a.projectnote,d.servicetypename,a.priceotc,a.priceotr
		FROM project a
		LEFT JOIN soheader b ON b.soheaderid = a.soheaderid
		LEFT JOIN employee c ON c.employeeid = b.employeeid
		LEFT JOIN servicetype d ON d.servicetypeid = b.servicetypeid
		WHERE a.projectno != '' and b.servicetypeid=2";
		
		$command1=$this->connection->createCommand($sql1);
		$dataReader1=$command1->queryAll();

		
		// definisi font
		$this->pdf->setFont('Arial','B',8);
		
	
		$this->pdf->setaligns(array('C','C','C','C','C'));
		$this->pdf->setwidths(array(35,50,50,30,35,35));
		$this->pdf->Row(array('SRF No','Sales','Note','Service Type','Biaya Awal','Biaya Per Bulan'));
		$this->pdf->setaligns(array('C','C','C','C','R','R'));
		
		foreach($dataReader1 as $row2)
		{
		  
		  $this->pdf->row(array($row2['projectno'],$row2['fullname'],
		  $row2['projectnote'],$row2['servicetypename'],		  
		   Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row2['priceotc']),
		  Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row2['priceotr']),
		  ));

		}
		
		$this->pdf->Ln();
		$sql2 = "SELECT a.projectno,c.fullname,a.projectnote,d.servicetypename,a.priceotc,a.priceotr
		FROM project a
		LEFT JOIN soheader b ON b.soheaderid = a.soheaderid
		LEFT JOIN employee c ON c.employeeid = b.employeeid
		LEFT JOIN servicetype d ON d.servicetypeid = b.servicetypeid
		WHERE a.projectno != '' and b.servicetypeid=3";
		
		$command2=$this->connection->createCommand($sql2);
		$dataReader2=$command2->queryAll();

		
		// definisi font
		$this->pdf->setFont('Arial','B',8);
		
	
		$this->pdf->setaligns(array('C','C','C','C','C'));
		$this->pdf->setwidths(array(35,50,50,30,35,35));
		$this->pdf->Row(array('SRF No','Sales','Note','Service Type','Biaya Awal','Biaya Per Bulan'));
		$this->pdf->setaligns(array('C','C','C','C','R','R'));
		
		foreach($dataReader2 as $row3)
		{
		  
		  $this->pdf->row(array($row3['projectno'],$row3['fullname'],
		  $row3['projectnote'],$row3['servicetypename'],		  
		   Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row3['priceotc']),
		  Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row3['priceotr']),
		  ));

		}
		
		
		//cari sub total
		$sql11 = "SELECT SUM(a.priceotr) as totala, sum(a.priceotc) as totalb
		FROM project a
		LEFT JOIN soheader b ON b.soheaderid = a.soheaderid
		LEFT JOIN employee c ON c.employeeid = b.employeeid
		LEFT JOIN servicetype d ON d.servicetypeid = b.servicetypeid
		WHERE a.projectno != '' and b.servicetypeid=1";
		
		$command11=$this->connection->createCommand($sql11);
		$dataReader11=$command11->queryAll();
		foreach($dataReader11 as $row11)
		{
			$row11['totala'];
			$row11['totalb'];
		}
		$sql22 = "SELECT SUM(a.priceotr) as totala, sum(a.priceotc) as totalb
		FROM project a
		LEFT JOIN soheader b ON b.soheaderid = a.soheaderid
		LEFT JOIN employee c ON c.employeeid = b.employeeid
		LEFT JOIN servicetype d ON d.servicetypeid = b.servicetypeid
		WHERE a.projectno != '' and b.servicetypeid=2";
		
		$command22=$this->connection->createCommand($sql22);
		$dataReader22=$command22->queryAll();
		foreach($dataReader22 as $row22)
		{
			$row22['totala'];
			$row22['totalb'];
		}
		
		$sql33 = "SELECT SUM(a.priceotr) as totala, sum(a.priceotc) as totalb
		FROM project a
		LEFT JOIN soheader b ON b.soheaderid = a.soheaderid
		LEFT JOIN employee c ON c.employeeid = b.employeeid
		LEFT JOIN servicetype d ON d.servicetypeid = b.servicetypeid
		WHERE a.projectno != '' and b.servicetypeid=3";
		
		$command33=$this->connection->createCommand($sql33);
		$dataReader33=$command33->queryAll();
		foreach($dataReader33 as $row33)
		{
			$row33['totala'];
			$row33['totalb'];
		}
		
		//menjumlahkan total berdasarkan subtotal
		$this->pdf->ln();
		$this->pdf->ln();
		
		$total = $row11['totala'] + $row22['totala'] + $row33['totala']; //+$row11['totalb']+$row22['totalb']+$row33['totalb'];
		$this->pdf->row(array('Total Biaya Awal',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row11['totalb']+$row22['totalb']+$row33['totalb'])));
		$this->pdf->row(array('Total Biaya Bulanan',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$total)));
		$this->pdf->row(array('Total Seluruh',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row11['totalb']+$row22['totalb']+$row33['totalb']+$total)));
		$this->pdf->Output();
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Project::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Projectservice::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelpic($id)
	{
		$model=Projectpic::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModellocation($id)
	{
		$model=Projectlocation::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModeldocument($id)
	{
		$model=Projectdocument::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelnetwork($id)
	{
		$model=Projectnetwork::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='projectservice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

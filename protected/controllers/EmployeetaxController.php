<?php

class EmployeetaxController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeetax';

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
	
public $employee,$wagetype,$currency,$employeetaxdetail;

	public function lookupdata()
	{
	  $this->employee=new Employee('searchwstatus');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$this->employee->attributes=$_GET['Employee'];

	   $this->employeetaxdetail=new Employeetaxdetail('searchwstatus');
	  $this->employeetaxdetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeetaxdetail']))
		$this->employeetaxdetail->attributes=$_GET['Employeetaxdetail'];
      $this->lookupdetail();
	}

	public function lookupdetail()
	{
	  $this->wagetype=new Wagetype('searchwstatus');
	  $this->wagetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Wagetype']))
		$this->wagetype->attributes=$_GET['Wagetype'];

	  $this->currency=new Currency('searchwstatus');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Employeetax;
	  $model->recordstatus=0;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  if ($model->save()) {
			echo CJSON::encode(array(
				'status'=>'success',
				'employeetaxid'=>$model->employeetaxid,
				'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'employeetaxdetail'=>$this->employeetaxdetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype), true)
				));
			Yii::app()->end();
		  }
	  }
	}

	public function actionCreatedetail()
	{
	  $employeetaxdetail=new Employeetaxdetail;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_formdetail',
				array('model'=>$employeetaxdetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype), true)
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
				'employeetaxid'=>$model->employeetaxid,
				'employeeid'=>$model->employeeid,
                'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'employeetaxdetail'=>$this->employeetaxdetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
		$id=$_POST['id'];
	  $employeetaxdetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'employeetaxdetailid'=>$employeetaxdetail->employeetaxdetailid,
				'wagetypeid'=>$employeetaxdetail->wagetypeid,
				'wagetypename'=>($employeetaxdetail->wagetype!==null)?$employeetaxdetail->wagetype->wagename:"",
				'amount'=>$employeetaxdetail->amount,
				'currencyid'=>$employeetaxdetail->currencyid,
				'currencyname'=>($employeetaxdetail->currency!==null)?$employeetaxdetail->currency->currencyname:"",
				'startdate'=>$employeetaxdetail->startdate,
				'enddate'=>$employeetaxdetail->enddate,
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$employeetaxdetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeetax'], $_POST['Employeetax']['employeetaxid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeetax']))
	  {
        $messages = $this->ValidateData(
                array(
                array($_POST['Employeetax']['employeeid'],'agjemptyemployeeid','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Employeetax'];
		if ((int)$_POST['Employeetax']['employeetaxid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeetax']['employeetaxid']);
		  $model->employeeid = $_POST['Employeetax']['employeeid'];
		  $model->recordstatus = $_POST['Employeetax']['recordstatus'];
		}
		else
		{
		  $model = new Employeetax();
		  $model->attributes=$_POST['Employeetax'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeetax']['employeetaxid']);
              $this->GetSMessage('agjinsertsuccess');
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

	public function actionWritedetail()
	{
	  if(isset($_POST['Employeetaxdetail']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeetaxdetail']['wagetypeid'],'agjemptyaccount','emptystring'),
                array($_POST['Employeetaxdetail']['startdate'],'agjemptydebit','emptystring'),
                array($_POST['Employeetaxdetail']['enddate'],'agjemptycredit','emptystring'),
                array($_POST['Employeetaxdetail']['amount'],'agjemptycredit','emptystring'),
                array($_POST['Employeetaxdetail']['currencyid'],'agjemptycredit','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Employeetaxdetail'];
          if ((int)$_POST['Employeetaxdetail']['employeetaxdetailid'] > 0)
          {
            $model=Employeetaxdetail::model()->findbyPK($_POST['Employeetaxdetail']['employeetaxdetailid']);
            $model->wagetypeid = $_POST['Employeetaxdetail']['wagetypeid'];
            $model->startdate = $_POST['Employeetaxdetail']['startdate'];
            $model->enddate = $_POST['Employeetaxdetail']['enddate'];
            $model->amount = $_POST['Employeetaxdetail']['amount'];
            $model->currencyid = $_POST['Employeetaxdetail']['currencyid'];
          }
          else
          {
            $model = new Employeetaxdetail();
            $model->attributes=$_POST['Employeetaxdetail'];
          }
          try
          {
            if($model->save())
            {
              $this->GetSMessage('agjinsertsuccess');
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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletedetail()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Employeetaxdetail::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	public function actionApprove()
	{
	  parent::actionApprove();
      $id=$_POST['id'];
      foreach($id as $ids)
      {
        //$model=$this->loadModel($ids);
        $a = Yii::app()->user->name;
        $connection=Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try
        {
          $sql = 'call ApproveEmployeeWage(:vid, :vlastupdateby)';
          $command=$connection->createCommand($sql);
          $command->bindValue(':vid',$ids,PDO::PARAM_INT);
          $command->bindValue(':vlastupdateby', $a,PDO::PARAM_STR);
          $command->execute();
          $transaction->commit();
        }
        catch(Exception $e) // an exception is raised if a query fails
        {
            $transaction->rollBack();
            $this->GetMessage($e->getMessage());
        }
      }
      Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();
		$model=new Employeetax('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employeetax']))
			$model->attributes=$_GET['Employeetax'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'employeetaxdetail'=>$this->employeetaxdetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype
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
		array('employeetaxdetail'=>$this->employeetaxdetail,'currency'=>$this->currency,
                    'wagetype'=>$this->wagetype));
	  Yii::app()->end();
	}

    public function actionUpload()
    {
      parent::actionUpload();
      Yii::import("ext.EAjaxUpload.qqFileUploader");
	  $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
	  $allowedExtensions = array("csv");
	  $sizeLimit = (int)Yii::app()->params['sizeLimit'];// maximum file size in bytes
	  $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	  $result = $uploader->handleUpload($folder,true);
	  $row = 0;
      $oldid = 0;
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Employeetax::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Employeetax();
                $model->journaldate = $data[2];
                $model->postdate = $data[2];
                $model->referenceno = $data[3];
			  }
              $model->employeetaxid = (int)$data[0];
              $model->recordstatus = 1;
			  try
			  {
				if(!$model->save())
				{
				  $errormessage=$model->getErrors();
				  if (Yii::app()->request->isAjaxRequest)
				  {
					echo CJSON::encode(array(
					  'status'=>'failure',
					  'div'=>$errormessage
					));
				  }
				}
                else {
                  $detail=Employeetaxdetail::model()->findByPk((int)$data[1]);
                  if ($detail=== null) {
                    $detail = new Employeetaxdetail();
                  }
                  $detail->employeetaxdetailid = (int)$data[1];
                  $detail->employeetaxid = (int)$data[0];
                  $detail->accountid = Account::model()->findbysql("select accountid from account where upper(accountcode) = '".$data[4]."'")->accountid;
                  if ($data[5] != '') 
                  {
                    $detail->debit = $data[5];
                    $detail->credit = 0;
                  }
                  if ($data[6] != '')
                  {
                    $detail->debit = 0;
                    $detail->credit = $data[6];
                  }
                  $detail->currencyid = Currency::model()->findbysql("select currencyid from currency where upper(currencyname) = '".$data[7]."'")->currencyid;
                  $detail->detailnote = $data[3];
                  if(!$detail->save())
                  {
                    $errormessage=$detail->getErrors();
                    if (Yii::app()->request->isAjaxRequest)
                    {
                      echo CJSON::encode(array(
                        'status'=>'failure',
                        'div'=>$errormessage
                      ));
                    }
                  }

                }
			  }
			  catch (Exception $e)
			  {
				$errormessage=$e->getMessage();
				if (Yii::app()->request->isAjaxRequest)
				  {
					echo CJSON::encode(array(
					  'status'=>'failure',
					  'div'=>$errormessage
					));
				  }
			  }
			}
			$row++;
		  }
		  fclose($handle);
	  }
	  $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	  echo $result;
  }

	public function actionDownload()
  {
	parent::actionDownload();
	$sql = "select e.sexname, a.employeetaxid,b.taxno,a.employeeid,b.fullname,b.oldnik,c.employeetypename,d.employeestatusname,a.taxstartperiod,a.taxendperiod
		from employeetax a 
		inner join employee b on b.employeeid = a.employeeid 
		left join employeetype c on c.employeetypeid = b.employeetypeid
		left join employeestatus d on d.employeestatusid = b.employeestatusid
		left join sex e on e.sexid = b.sexid		";
	if ($_GET['id'] !== '') {
				$sql = $sql . "where a.employeetaxid in (".$_GET['id']." ) ";
		}
		$sql = $sql . " order by a.employeeid";
	$folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';
	Yii::import('application.extensions.PHPExcel.PHPExcel',true);
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load($folder.'1721-ERP.xls');
	$command=$this->connection->createCommand($sql);
    $dataReader=$command->queryAll();
	$i=0;
	foreach($dataReader as $row)
    {
		$i=$i+1;
		$j=$i+6;
		$daywork = 0;
		$sql1 = "select getdaywork(".$row['employeeid'].",'".$row['taxstartperiod']."','".$row['taxendperiod']."') as daywork";
		$command1=$this->connection->createCommand($sql1);
		$dataReader1=$command1->queryAll();
		foreach($dataReader1 as $row1)
		{
			$daywork = $row1['daywork'];
		}
		$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $i)
        ->setCellValue('B'.$j, $row['fullname'])
        ->setCellValue('C'.$j, "'".$row['oldnik'])
        ->setCellValue('D'.$j, $row['taxno'])
        ->setCellValue('E'.$j, $row['sexname'])	
        ->setCellValue('F'.$j, $row['employeetypename'])	
        ->setCellValue('G'.$j, $row['employeestatusname'])
        ->setCellValue('H'.$j, $daywork);	
		
		$sql1 = "select wagetypeid,abs(sum(amount)) as amount from employeetaxdetail a where employeetaxid = ".$row['employeetaxid']." group by wagetypeid";
		$command1=$this->connection->createCommand($sql1);
		$dataReader1=$command1->queryAll();
		foreach($dataReader1 as $row1)
		{
			//gaji pokok
			if ($row1['wagetypeid'] == 1) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('I'.$j, $row1['amount']);
			}
			//tj jabatan
			if ($row1['wagetypeid'] == 2) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('J'.$j, $row1['amount']);
			}
			//tj makan
			if ($row1['wagetypeid'] == 3) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('K'.$j, $row1['amount']);
			}
			//tj transport
			if ($row1['wagetypeid'] == 4) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('L'.$j, $row1['amount']);
			}
			//tj peralihan
			if ($row1['wagetypeid'] == 8) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('O'.$j, $row1['amount']);
			}
			//tj hp
			if ($row1['wagetypeid'] == 6) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('P'.$j, $row1['amount']);
			}
			//tj khusus
			if ($row1['wagetypeid'] == 5) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('Q'.$j, $row1['amount']);
			}
			//jkk
			if ($row1['wagetypeid'] == 12) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('R'.$j, $row1['amount']);
			}
			//jk
			if ($row1['wagetypeid'] == 11) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('S'.$j, $row1['amount']);
			}
			//jht perusahaan
			if ($row1['wagetypeid'] == 9) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('T'.$j, $row1['amount']);
			}
			//jpk
			if (($row1['wagetypeid'] == 13) or ($row1['wagetypeid'] == 14)) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('U'.$j, $row1['amount']);
			}
			//psl
			if ($row1['wagetypeid'] == 21) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('V'.$j, $row1['amount']);
			}
			//dplk perusahaan
			if ($row1['wagetypeid'] == 15) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('W'.$j, $row1['amount']);
			}
			//tj pph
			if ($row1['wagetypeid'] == 23)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('X'.$j, $row1['amount']);
			}
			//lembur
			if ($row1['wagetypeid'] == 7)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('Z'.$j, $row1['amount']);
			}
			//asuransi
			if ($row1['wagetypeid'] == 20)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AA'.$j, $row1['amount']);
			}
			//thr
			if ($row1['wagetypeid'] == 26)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AB'.$j, $row1['amount']);
			}
			//tbpct
			if ($row1['wagetypeid'] == 17)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AC'.$j, $row1['amount']);
			}
			//tbpcb
			if ($row1['wagetypeid'] == 18)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AD'.$j, $row1['amount']);
			}
			//jualcb
			if ($row1['wagetypeid'] == 19)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AE'.$j, $row1['amount']);
			}
			//IMB
			if ($row1['wagetypeid'] == 19)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AF'.$j, $row1['amount']);
			}
			//Bonus
			if ($row1['wagetypeid'] == 28)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AG'.$j, $row1['amount']);
			}
			//Insentif / Komisi
			if ($row1['wagetypeid'] == 22)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AH'.$j, $row1['amount']);
			}
			//JHT Karyawan
			if ($row1['wagetypeid'] == 10)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AK'.$j, $row1['amount']);
			}
			//DPLK Karyawan
			if ($row1['wagetypeid'] == 16)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AL'.$j, $row1['amount']);
			}
			//Penalty
			if ($row1['wagetypeid'] == 25)  {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('AN'.$j, $row1['amount']);
			}
		}	
	}
	ob_end_clean();
    ob_start();
    
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="1721-Data.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
	Yii::app()->end();
	/*
	$sql = "select a.employeeid, a.taxstartperiod as wagestartperiod,a.taxendperiod as wageendperiod, a.employeetaxid, b.fullname, c.levelorgname, d.structurename,
          a.taxvalue
          from employeetax a
          left join employee b on b.employeeid = a.employeeid
          left join levelorg c on c.levelorgid = b.levelorgid
          left join orgstructure d on d.orgstructureid = b.orgstructureid ";
		  if ($_GET['id'] !== '') {
				$sql = $sql . " where a.employeetaxid = ". $_GET['id'];
		}
        $command=$this->connection->createCommand($sql);
        $dataReader=$command->queryAll();
		
		$this->pdf->SetMargins(10,0,0);
		$this->pdf->SetBorder(0);
        $this->pdf->title=' Slip Gaji';
        $this->pdf->AddPage('P','GAJI');		
        $this->pdf->setFont('Arial','B',8);

		$this->pdf->SetAligns(5);
        foreach($dataReader as $row)
        {
			//$this->pdf->setFont('Arial','B',12);
			//$this->pdf->text(90,24,'Slip Gaji');
			//$this->pdf->row(array(' '));
        	$this->pdf->setFont('Arial','B',8);
			$this->pdf->text(10,26,'No Slip  ');
			$this->pdf->text(40,27,$row['employeetaxid']);
			
			$this->pdf->setFont('Arial','B',8);
			$this->pdf->text(10,31,'Nama    ');
			$this->pdf->text(40,32,$row['fullname']);
        	$this->pdf->setFont('Arial','B',8);
			
			$this->pdf->text(10,36,'Status   ');
			$this->pdf->text(40,37,$row['levelorgname']);
			$this->pdf->text(10,41,'Posisi    ');
			$this->pdf->text(40,42,$row['structurename']);
			$this->pdf->text(40,46,'Tax Value: '.Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['taxvalue']));
			
          // menuliskan detail
          $sql1 = "select *
from (
select a.employeetaxid, b.wagename, sum(a.amount) as penambah, 0 as pengurang
from employeetaxdetail a inner join wagetype b on b.wagetypeid = a.wagetypeid
where a.amount >= 0 and b.isprint = 1
group by a.wagetypeid,a.employeetaxid

union



select ".$row['employeetaxid'].",'Tunjangan PSL',a.amount as penambah, 0 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (21)

union

select ".$row['employeetaxid'].",'Tunjangan Pajak', taxvalue as penambah, 0 as pengurang
from
employeetax a
where employeeid = ".$row['employeeid']." and
date('".$row['wagestartperiod']."') <= date(a.taxendperiod) and
date('".$row['wageendperiod']."') >= date(a.taxstartperiod)

union

select ".$row['employeetaxid'].",'Tunjangan JHT',a.amount as penambah, 0 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (9)

union

select ".$row['employeetaxid'].",'Tunjangan JK',a.amount as penambah, 0 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (11)

union

select ".$row['employeetaxid'].",'Tunjangan JKK',a.amount as penambah, 0 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (12)

union

select ".$row['employeetaxid'].",'Tunjangan JPK Lajang',a.amount as penambah, 0 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (13)

union

select ".$row['employeetaxid'].",'Tunjangan JPK Keluarga',a.amount as penambah, 0 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (14)

union

select ".$row['employeetaxid'].",'Tunjangan DPLK',a.amount as penambah, 0 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (15)

union

select a.employeetaxid, b.wagename, 0 as penambah, sum(a.amount) as pengurang
from employeetaxdetail a
inner join wagetype b on b.wagetypeid = a.wagetypeid
where a.amount < 0  and b.isprint = 1
group by a.wagetypeid,a.employeetaxid

union

select ".$row['employeetaxid'].",c.wagename,case when a.amount >= 0 then a.amount else 0 end as penambah, case when a.amount <= 0 then a.amount else 0 end as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
date('".$row['wagestartperiod']."') <= date(a.enddate) and
date('".$row['wageendperiod']."') >= date(a.startdate) and
a.wagetypeid not in
(select y.wagetypeid
from employeetax z
inner join employeetaxdetail y on y.employeetaxid = z.employeetaxid
where z.employeetaxid = ".$row['employeetaxid'].") and isfinal=1

union

select ".$row['employeetaxid'].",'Potongan Pajak', 0 as penambah, taxvalue*-1 as pengurang
from
employeetax a
where employeeid = ".$row['employeeid']." and
date('".$row['wagestartperiod']."') <= date(a.taxendperiod) and
date('".$row['wageendperiod']."') >= date(a.taxstartperiod)
 
union

select ".$row['employeetaxid'].",'Potongan JHT',0 as penambah, a.amount*-1 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (9)

union

select ".$row['employeetaxid'].",'Potongan JK',0 as penambah, a.amount*-1 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (11)

union

select ".$row['employeetaxid'].",'Potongan JKK',0 as penambah, a.amount*-1 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (12)

union

select ".$row['employeetaxid'].",'Potongan JPK Lajang',0 as penambah, a.amount*-1 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (13)

union

select ".$row['employeetaxid'].",'Potongan JPK Keluarga',0 as penambah, a.amount*-1 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (14)

union

select ".$row['employeetaxid'].",'Potongan DPLK',0 as penambah, a.amount*-1 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (15)

union

select ".$row['employeetaxid'].",'Potongan PSL',0 as penambah, a.amount*-1 as pengurang
from employeebenefitdetail a
inner join employeebenefit b on b.employeebenefitid = a.employeebenefitid
inner join wagetype c on c.wagetypeid = a.wagetypeid
where b.employeeid = ".$row['employeeid']." and
a.wagetypeid in (21)

) at1 where at1.employeetaxid = ".$row['employeetaxid'];
          $command1=$this->connection->createCommand($sql1);
          $dataReader1=$command1->queryAll();
		
		$this->pdf->row(array(' '));
$this->pdf->setY(50);
		  
          $this->pdf->setwidths(array(55,22,22));
		  
          $this->pdf->SetAligns(array('L','R','R'));
          $this->pdf->setFont('Arial','B',8);
		  $this->pdf->row(array(' '));
          $this->pdf->row(array('Wage Name','Addiction','Deduction'));
		  
          $this->pdf->SetTableData();
$totaladd = 0;
$totaldec = 0;
 
          foreach($dataReader1 as $row1)
          {
			
		  
$penambah = $row1['penambah'];$totaladd = $totaladd + $penambah;
$pengurang = $row1['pengurang']*-1;$totaldec = $totaldec + $pengurang;
if (($penambah >= 0) & ($pengurang == 0))
{
$this->pdf->row(array($row1['wagename'],Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$penambah),''));
 } else
if ($pengurang >=0) 
{
$this->pdf->row(array($row1['wagename'],'',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$pengurang)));
}         
}

// menampilkan subtotal & total
$this->pdf->row(array(' '));
$this->pdf->SetFont('','B');
$this->pdf->row(array('Sub Total',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$totaladd),
Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$totaldec)));
$sel = $totaladd-$totaldec;
$sel1 = $totaldec-$totaladd;
if ($totaladd > $totaldec) 
{
$this->pdf->row(array('Total',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$sel),''));
} else {
$this->pdf->row(array('Total','',Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$sel1)));
}
          $this->pdf->AddPage('P','GAJI');	

        }
    // me-render ke browser
    $this->pdf->Output();
	*/
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Employeetax::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Employeetaxdetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeetax-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeetaxdetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

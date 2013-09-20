<?php

class ReportabsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'reportabs';

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
	  if (isset($_POST['payrollperiodid']))
	  {
        $pdf = new PDF();
        $pdf->title='Report Akumulasi Kehadiran';
        $pdf->AddPage('P');
        $pdf->setFont('Arial','B',12);

        // definisi font
        $pdf->setFont('Arial','B',8);

        // menuliskan tabel
        $connection=Yii::app()->db;
        $sql = "select a.employeeid,a.fullname, a.oldnik, b.levelorgname, c.structurename,d.positionname,e.employeetypename,
            f.sexname,joindate,email,phoneno,alternateemail,hpno,a.addressbookid,a.accountno,a.taxno,g.maritalstatusname,
            h.religionname,a.birthdate,i.cityname
          from employee a
          left join levelorg b on b.levelorgid = a.levelorgid
          left join orgstructure c on c.orgstructureid = a.orgstructureid
          left join position d on d.positionid = a.positionid
          left join employeetype e on e.employeetypeid = a.employeetypeid
          left join sex f on f.sexid = a.sexid
          left join maritalstatus g on g.maritalstatusid = a.maritalstatusid
          left join religion h on h.religionid = a.religionid
          left join city i on i.cityid = a.birthcityid
          order by employeeid ";
        $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();

        foreach($dataReader as $row)
        {
          if (file_exists($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'.$row['oldnik'].'.jpg'))
          {
            $pdf->Image($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'. $row['oldnik'] .'.jpg',10,30,30);
          }
          $pdf->setFont('Arial','B',10);
          $pdf->text(50,30,'Nama: '.$row['fullname']);
          $pdf->setFont('Arial','',8);
          $pdf->text(50,35,'NIP: '.$row['oldnik']);
          $pdf->text(50,40,'Posisi: '.$row['positionname']);
          $pdf->text(50,45,'Struktur: '.$row['structurename']);
          $pdf->text(50,50,'Golongan: '.$row['levelorgname']);
        
          $sql2 = "select startdate,enddate
            from payrollperiod
            where payrollperiodid = ".$_POST['payrollperiodid'];
          $command2=$connection->createCommand($sql2);
          $dataReader2=$command2->queryAll();
          
          foreach($dataReader2 as $row2)
          {          
            $sql1 = "select date(absdate) as absdate, hourin,hourout,schedulename,statusin 
              from reportperday
              where date(absdate) between '".$row2['startdate']."' and '".$row2['enddate'].
                    "' and employeeid = ".$row['employeeid'].
                    " order by absdate";
            $command1=$connection->createCommand($sql1);
            $dataReader1=$command1->queryAll();

            $pdf->text(10,80,'Detail Kehadiran');
            $pdf->SetY(85);
            $pdf->setaligns(array('C','C','C','C','C'));
            $pdf->setwidths(array(50,30,30,30,30));
            $pdf->Row(array('Tanggal','Masuk','Keluar','Schedule','Kode Absen'));
            $pdf->setaligns(array('L','C','C','L','L'));
            foreach($dataReader1 as $row1)
            {
              $pdf->row(array(
                  date('D, d-M-Y', strtotime($row1['absdate'])),
                  $row1['hourin'],$row1['hourout'],
                  $row1['schedulename'],$row1['statusin']));
            }
            
            $sql1 = "select a.shortstat, count(1) as jumlah
                from absstatus a inner join
                reportperday b on b.statusin = a.shortstat
                where date(absdate) between '".$row2['startdate']."' and '".$row2['enddate'].
                "' and employeeid = ".$row['employeeid'].
                " group by shortstat";
            $command1=$connection->createCommand($sql1);
            $dataReader1=$command1->queryAll();

            $pdf->text(10,$pdf->gety()+10,'Summary Kehadiran');
            $pdf->sety($pdf->gety()+15);
            $pdf->setaligns(array('C','C'));
            $pdf->setwidths(array(30,30));
            $pdf->Row(array('Status','Jumlah'));
            $pdf->setaligns(array('L','L'));
            foreach($dataReader1 as $row1)
            {
              $pdf->row(array($row1['shortstat'],$row1['jumlah']));
            }
          }
          $pdf->AddPage('P');
        }        
        $pdf->Output();
      }
      else {
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
		$model=Reportabs::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='payrollprocess-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

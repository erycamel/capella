<?php

class ReportjamsostekController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'rinciangaji';

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

    public function actionDownload()
    {
           
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
      parent::actionIndex();
      if (isset($_POST['payrollperiodid']))
      {
		if ((int)$_POST['payrollperiodid'] > 0)
		{
		$pdf = new PDF();
		$pdf->isheader=false;
        $pdf->AddPage('L');
        $pdf->setFont('Arial','B',12);
		$connection=Yii::app()->db;
        $sql = "select a.startdate, a.enddate
			from payrollperiod a
			where payrollperiodid = ".$_POST['payrollperiodid'];
		$command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
		foreach($dataReader as $row)
        {
			$sql = "select *,z.iuranjkk+z.iuranjkm+z.iuranjpk+z.iuranjhttk+z.iuranjhtpe as total
				from (select
				b.fullname,
				b.oldnik,
				b.birthdate,
				(
				  select jamsostekno
				  from employeejamsostek
				  order by jamsostekdate desc
				  limit 1
				) as jamsostekno,
				(
				  select b.amount
				  from employeebenefit a
				  inner join employeebenefitdetail b on b.employeebenefitid = a.employeebenefitid
				  where b.startdate <= '".$row['startdate']."' and b.enddate >= '".$row['enddate']."' and wagetypeid = 1 and a.employeeid = b.employeeid
				) as dataupah,
				(
				  select b.amount
				  from employeebenefit a
				  inner join employeebenefitdetail b on b.employeebenefitid = a.employeebenefitid
				  where b.startdate <= '".$row['startdate']."' and b.enddate >= '".$row['enddate']."'  and wagetypeid = 12 and a.employeeid = b.employeeid
				) as iuranjkk,
				(
				  select b.amount
				  from employeebenefit a
				  inner join employeebenefitdetail b on b.employeebenefitid = a.employeebenefitid
				  where b.startdate <= '".$row['startdate']."' and b.enddate >= '".$row['enddate']."'  and wagetypeid = 11 and a.employeeid = b.employeeid
				) as iuranjkm,
				(
				  select b.amount
				  from employeebenefit a
				  inner join employeebenefitdetail b on b.employeebenefitid = a.employeebenefitid
				  where b.startdate <= '".$row['startdate']."' and b.enddate >= '".$row['enddate']."'  and wagetypeid = 13 and a.employeeid = b.employeeid
				) as iuranjpk,
				(
				  select case when b.amount > 0 then b.amount else b.amount*-1 end
				  from employeebenefit a
				  inner join employeebenefitdetail b on b.employeebenefitid = a.employeebenefitid
				  where b.startdate <= '".$row['startdate']."' and b.enddate >= '".$row['enddate']."'  and wagetypeid = 10 and a.employeeid = b.employeeid
				) as iuranjhttk,
				(
				  select case when b.amount > 0 then b.amount else b.amount*-1 end
				  from employeebenefit a
				  inner join employeebenefitdetail b on b.employeebenefitid = a.employeebenefitid
				  where b.startdate <= '".$row['startdate']."' and b.enddate >= '".$row['enddate']."'  and wagetypeid = 9 and a.employeeid = b.employeeid
				) as iuranjhtpe
				from employee b) z";
			$command1=$connection->createCommand($sql);
			$dataReader1=$command1->queryAll();
			$i=0;
			$pdf->setFont('Arial','B',6);
			$pdf->setwidths(array(10,20,20,40,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20));
			/* $pdf->setaligns(array('C','C','C','C','C','C','C','C','C','C','C','C')); */
/* 			$pdf->row(array('No','Nomor KPJ','Nomor NIK','Nama Tenaga Kerja','Tgl Lahir (tgl/bulan/tahun)',
					'Data Upah (Rp.)','Iuran JKK 0,24% (Rp.)','Iuran JKM 0,3% (Rp.)','Iuran JPK 3% (Rp.)',
					'Iuran JHT TK 2% (Rp.)','Iuran JHT Perusahaan 3,7% (Rp.)','Total (Rp.)')); */
			$pdf->setaligns(array('L','L','L','L','L','L','L','L','L','L','L','L'));
			/* $pdf->SetTableData(); */
			foreach($dataReader1 as $row1)
			{
				foreach($dataReader as $row)
				{
					$i+=1;
					$pdf->text(5,($pdf->gety()*$i),$i.','.$row1['jamsostekno'].','.$row1['oldnik'].','.
					$row1['fullname'].','.date(Yii::app()->params["dateviewfromdb"], strtotime($row1['birthdate'])).','.
					$row1['dataupah'].','.$row1['iuranjkk'].','.$row1['iuranjkm'].','.$row1['iuranjpk'].','.$row1['iuranjhttk'].','.
					$row1['iuranjhtpe'].','.$row1['total']);
					/* $pdf->row(array($i,$row1['jamsostekno'],$row1['oldnik'],
					$row1['fullname'],
					date(Yii::app()->params["dateviewfromdb"], strtotime($row1['birthdate'])),
					$row1['dataupah'],
					$row1['iuranjkk'],
					$row1['iuranjkm'],
					$row1['iuranjpk'],
					$row1['iuranjhttk'],
					$row1['iuranjhtpe'],
					$row1['total'])); */
				}
			}
		}
        $pdf->Output('reportjamsostek.pdf','D');
		}
		else
		{
			echo "Payroll Period harus diisi";
		}
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
		$model=Rinciangaji::model()->findByPk((int)$id);
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

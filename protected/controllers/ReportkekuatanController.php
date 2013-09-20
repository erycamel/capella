<?php

class ReportkekuatanController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'reportkekuatan';

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
        $pdf = new PDF();
        $pdf->title='Report Kekuatan Pegawai';
        $pdf->AddPage('L');
        $pdf->setFont('Arial','B',12);

        // definisi font
        $pdf->setFont('Arial','B',8);

        // menuliskan tabel
        $connection=Yii::app()->db;
        $sql = "select a.sexid,a.sexname
          from sex a";
        $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
		
		$pdf->SetY(35);
		$pdf->setaligns(array('C','C','C','C','C','C','C','C','C','C','C','C'));
		$pdf->setwidths(array(30,30,30,30,20,20,20,20,20,20,20,20));
		$pdf->Row(array('Jenis Kelamin','Status Tetap','Status Kontrak','Total','SD','SMP','SMA','D3','S1','S2','S3','Total'));
		$pdf->setaligns(array('L','C','C','C','C','C','C','C','C','C','C','C'));

		$totaljumlahtetap=0;
		$totaljumlahkontrak=0;
		$totaltotal=0;
		$totalsd=0;
		$totalsmp=0;
		$totalsma=0;
		$totald3=0;
		$totals1=0;
		$totals2=0;
		$totals3=0;
		$totaltotal1=0;
        foreach($dataReader as $row)
        {        
		  $jumlahtetap = 0;
          $sql2 = "select count(1) as jumlahtetap
            from employee
            where sexid = ".$row['sexid']." and employeestatusid = 1";
          $command2=$connection->createCommand($sql2);
          $dataReader2=$command2->queryAll();
		  
          foreach($dataReader2 as $row2)
          {          
			$jumlahtetap = $row2['jumlahtetap'];
          }
		  
		  $jumlahkontrak = 0;
		  
		  $sql2 = "select count(1) as jumlahkontrak
            from employee
            where sexid = ".$row['sexid']." and employeestatusid = 2";
          $command2=$connection->createCommand($sql2);
          $dataReader2=$command2->queryAll();
		  
          foreach($dataReader2 as $row2)
          {          
			$jumlahkontrak = $row2['jumlahkontrak'];
          }
		  $sd=0;
		  $smp=0;
		  $sma=0;
		  $d3=0;
		  $s1=0;
		  $s2=0;
		  $s3=0;
		  
		  $sql2 = "select a.employeeid
            from employee a
            where a.sexid = ".$row['sexid']." ";
          $command2=$connection->createCommand($sql2);
          $dataReader2=$command2->queryAll();
		  
          foreach($dataReader2 as $row2)
          {          
			$sql3 = "select a.educationid
            from employeeeducation a
            where a.employeeid = ".$row2['employeeid']." order by yeargraduate desc limit 1";
			$command3=$connection->createCommand($sql3);
			$dataReader3=$command3->queryAll();
			  
			foreach($dataReader3 as $row3)
			{
				if ($row3['educationid'] == 1) 
				{
					$sd += 1;
				} else
				if ($row3['educationid'] == 2) 
				{
					$smp += 1;
				} else
				if ($row3['educationid'] == 3) 
				{
					$sma += 1;
				} else
				if ($row3['educationid'] == 4) 
				{
					$d3 += 1;
				} else
				if ($row3['educationid'] == 5) 
				{
					$s1 += 1;
				} else
				if ($row3['educationid'] == 6) 
				{
					$s2 += 1;
				} else
				if ($row3['educationid'] == 7) 
				{
					$s3 += 1;
				}
			}			
          }
          $pdf->Row(array($row['sexname'],$jumlahtetap,$jumlahkontrak,$jumlahtetap+$jumlahkontrak,
			$sd,$smp,$sma,$d3,$s1,$s2,$s3,$sd+$smp+$sma+$d3+$s1+$s2+$s3));
		
			$totaljumlahtetap += $jumlahtetap;
			$totaljumlahkontrak += $jumlahkontrak;
			$totalsd += $sd;
			$totalsmp += $smp;
			$totalsma += $sma;
			$totald3 += $d3;
			$totals1 += $s1;
			$totals2 += $s2;
			$totals3 += $s3;	
			
        }        
          $pdf->Row(array('Grand Total',$totaljumlahtetap,$totaljumlahkontrak,$totaljumlahtetap+$totaljumlahkontrak,
			$totalsd,$totalsmp,$totalsma,$totald3,$totals1,$totals2,$totals3,$totalsd+$totalsmp+$totalsma+$totald3+$totals1+$totals2+$totals3));
        $pdf->Output();
        $this->render('index');
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

<?php

class RinciangajiController extends Controller
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
        if (isset($_POST['startperiod']))
      {
         $pdf = new PDF();
        $pdf->title='Rincian Gaji';
        $pdf->AddPage('L');
        $pdf->setFont('Arial','B',12);
		$connection=Yii::app()->db;
          $sql = "select b.fullname, b.oldnik,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 1) as BasicSalary,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 2) as PositionAllowance,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 3) as Meals,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 4) as Transport,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 5) as Costofliving,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 6) as Cellular_HP,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 7) as Overtime,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 8) as TransitionAllowance,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 10) as JamsostekyangditanggungolehKaryawan,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 12) as DPLKyangditanggungolehkaryawan,
(select sum(amount)
from employeewagedetail c
where c.employeewageid = a.employeewageid and wagetypeid = 5) as SpecialAllowance,
wagevalue,
(
	select count(1) as jumlah
    from absstatus z inner join
    reportperday y on y.statusin = z.shortstat
    where date(absdate) between '".$_POST['startperiod']."' and '".$_POST['startperiod'].
    "' and employeeid = b.employeeid and z.shortstat = 'H' group by shortstat
) as jumlahkehadiran
from employeewage a
inner join employee b on b.employeeid = a.employeeid
where date(wagestartperiod) between date('".$_POST['startperiod']."') and date('".$_POST['endperiod']."')";
          $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
          $pdf->setFont('Arial','B',6);
          $pdf->setwidths(array(30,20,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,15,20));
          $pdf->row(array('Employee','NIP','Jumlah Kehadiran','Basic Salary','Jabatan','Makan','Transport','Khusus',
              'Telepon','Lembur','Peralihan','Khusus',
              'JHT Karyawan','DPLK Karyawan','Total THP'));
          $pdf->SetTableData();
		  $basic = 0;
		  $position = 0;
		  $meals = 0;
		  $transport = 0;
		  $cost = 0;
		  $telp = 0;
		  $over = 0;
		  $trans = 0;
		  $spec = 0;
		  $jamsostek = 0;
		  $dplk = 0;
		  $wagevalue = 0;
          foreach($dataReader as $row)
          {
            $pdf->row(array($row['fullname'],$row['oldnik'],
                $row['jumlahkehadiran'],
                $row['BasicSalary'],
                $row['PositionAllowance'],
                $row['Meals'],
                $row['Transport'],
                $row['Costofliving'],
                $row['Cellular_HP'],
                $row['Overtime'],
                $row['TransitionAllowance'],
				$row['SpecialAllowance'],
                $row['JamsostekyangditanggungolehKaryawan'],
                $row['DPLKyangditanggungolehkaryawan'],                
                $row['wagevalue']));	
			$basic += $row['BasicSalary'];
			$position += $row['PositionAllowance'];
			$meals += $row['Meals'];
			$transport += $row['Transport'];
			$cost += $row['Costofliving'];
			$telp += $row['Cellular_HP'];
			$over += $row['Overtime'];
			$trans += $row['TransitionAllowance'];
			$spec += $row['SpecialAllowance'];
			$jamsostek += $row['JamsostekyangditanggungolehKaryawan'];
			$dplk += $row['DPLKyangditanggungolehkaryawan'];
			$wagevalue += $row['wagevalue'];
          }
		  $pdf->row(array('Total','',
                '',
                $basic,
                $position,
                $meals,
                $transport,
                $cost,
                $telp,
                $over,
                $trans,
				$spec,
                $jamsostek,
                $dplk,                
                $wagevalue));		
          $pdf->Output('rinciangaji.pdf','D');
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

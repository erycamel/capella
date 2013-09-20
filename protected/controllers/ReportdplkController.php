<?php

class ReportdplkController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'reportdplk';

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
		$pdf->title='Report DPLK';
        $pdf->AddPage('P');
        $pdf->setFont('Arial','B',12);
		$connection=Yii::app()->db;
        $sql = "select a.startdate, a.enddate
			from payrollperiod a
			where payrollperiodid = ".$_POST['payrollperiodid'];
		$command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
		foreach($dataReader as $row)
        {
			$sql = "select *, z.basicsalary*10/100 as dplk,z.psl/72 as pslnl,z.basicsalary*2.5/100 as iuran
				from
				(
				select z.oldnik,z.fullname,
				(
				  select b.amount
				  from employeebenefit a
				  inner join employeebenefitdetail b on b.employeebenefitid = a.employeebenefitid
				  where b.startdate <= '".$row['startdate']."' and b.enddate >= '".$row['enddate']."' and wagetypeid = 1 and a.employeeid = z.employeeid
				) as basicsalary,
				(
				  select b.amount
				  from employeebenefit a
				  inner join employeebenefitdetail b on b.employeebenefitid = a.employeebenefitid
				  where b.startdate <= '".$row['startdate']."' and b.enddate >= '".$row['enddate']."' and wagetypeid = 21 and a.employeeid = z.employeeid
				) as psl
				from employee z
				) z";
			$command1=$connection->createCommand($sql);
			$dataReader1=$command1->queryAll();
			$i=0;
			$pdf->setFont('Arial','B',6);
			$pdf->setwidths(array(10,20,40,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20));
			$pdf->setaligns(array('C','C','C','C','C','C','C','C','C','C','C','C'));
			$pdf->row(array('No','Nomor NIK','Nama','Basic Salary','PSL','DPLK','PSL NL',
					'Iuran Pekerja'));
			$pdf->setaligns(array('C','C','L','C','C','C','C','C','C','C','C','C'));
			$pdf->SetTableData();
			foreach($dataReader1 as $row1)
			{
				foreach($dataReader as $row)
				{
					$i+=1;
					$pdf->row(array($i,$row1['oldnik'],$row1['fullname'],
					$row1['basicsalary'],
					$row1['psl'],
					$row1['dplk'],
					$row1['pslnl'],
					$row1['iuran']));
				}
			}
		}
        $pdf->Output('reportdplk.pdf','D');
		}
		else {
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

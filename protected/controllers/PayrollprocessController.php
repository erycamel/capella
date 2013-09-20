  <?php

class PayrollprocessController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'payrollprocess';

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
	
	public function grossup($vtotalbebanpajakrutinperusahaan=0,$vtotalbebanpajaknonrutinperusahaan=0,
		$vtotalbebanpajakrutinpekerja=0,
		$vpenalty=0,
		$vptkp=0,
		$vtunjanganpph,
		$vpercenttaxcost=0,$vtaxcostlimit=0)
	{
					$vbrutosetahun = (($vtotalbebanpajakrutinperusahaan+$vtunjanganpph)*12) + 
						$vtotalbebanpajaknonrutinperusahaan;
					$vbiayajabatansetahun = $vpercenttaxcost * ($vbrutosetahun/100);
					if ($vbiayajabatansetahun > $vtaxcostlimit)
					{
						$vbiayajabatansetahun = $vtaxcostlimit; 
					}
					$vnettosetahun = $vbrutosetahun - ($vtotalbebanpajakrutinpekerja*12) - $vpenalty - $vbiayajabatansetahun;
					if ($vnettosetahun > $vptkp)
					{
						$vpkp = $vnettosetahun - $vptkp;
					}					
					if ($vpkp > 500000000)
					{
						$vpph = 3/100*($vpkp-500000000)+95000000;
					}
					else 
					if ($vpkp > 250000000)
					{
						$vpph = 25/100*($vpkp-250000000)+32500000;
					}
					else 
					if ($vpkp>50000000)
					{
						$vpph = 15/100*($vpkp-50000000)+2500000;
					}
					else 
					{
						$vpph = $vpkp*(5/100);
					}
					$vpph = round($vpph);
					$vpphsebulan = $vpph / 12;
					echo $vtunjanganpph. " <br> " .$vpphsebulan;
					if ($vpphsebulan == $vtunjanganpph)
					{
						$vtunjanganpph = $vpphsebulan;
					}
					else
					{
						$this->grossup($vtotalbebanpajakrutinperusahaan,
							$vtotalbebanpajaknonrutinperusahaan,
							$vtotalbebanpajakrutinpekerja,
							$vpenalty,
							$vpphsebulan,
							$vpercenttaxcost,
							$vtaxcostlimit);
					}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
      parent::actionIndex();
	  if (isset($_POST['payrollperiodid']))
	  {
		//variable
		$startdate;
		$enddate;
		$accperiod;
		$connection=Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try
        {
          $sql = 'call payrollprocess(:vid)';
          $command=$connection->createCommand($sql);
          $command->bindvalue(':vid',$_POST['payrollperiodid'],PDO::PARAM_INT);
          $command->execute();
/*		  
          $sql1 = 'select payrollperiodid from payrollperiod where parentperiodid = '.$_POST['payrollperiodid'];
          $command1=$connection->createCommand($sql1);
          $dataReader=$command1->queryAll();
          foreach($dataReader as $row)
          {
            $sql = 'call payrollprocess(:vid)';
            $command=$connection->createCommand($sql);
            $command->bindvalue(':vid',$row['payrollperiodid'],PDO::PARAM_INT);
            $command->execute();
          }	
			//ambil data start,end dari tabel payrollperiod
			$sql = "select startdate,enddate
				from payrollperiod
				where payrollperiodid = ".$_POST['payrollperiodid'];
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
			foreach($dataReader as $row)
			{
				$startdate = $row['startdate'];
				$enddate = $row['enddate'];
			}
			$vtotalbebanpajakrutinperusahaan;
			$vtotalbebanpajaknonrutinperusahaan;
			$vtotalbebanpajakrutinpekerja;
			$vptkp;
			$vpenalty;
			$sql = "SELECT a.employeeid,a.employeewageid
				FROM employeewage a
				where date('".$enddate."') = date(wageendperiod)
				and date('".$startdate."') = date(wagestartperiod);";
			$command=$connection->createCommand($sql);
			$dataReader=$command->queryAll();
			foreach($dataReader as $row)
			{
				$sql1 = "select ifnull(sum(amount),0) as hitung
					  from employeewagedetail a
					  inner join wagetype b on b.wagetypeid = a.wagetypeid
					  where a.employeewageid = ".$row['employeewageid']." and b.ispph = 1 and b.isrutin=1 
					  and paidbycompany=1;";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				foreach($dataReader1 as $row1)
				{
					$vtotalbebanpajakrutinperusahaan = $row1['hitung'];
				}

				$sql1 = "select ifnull(sum(amount),0) as hitung
					from employeewagedetail a
					inner join wagetype b on b.wagetypeid = a.wagetypeid
					where a.employeewageid = ".$row['employeewageid']." and b.ispph = 1 and b.isrutin=0 and 
					paidbycompany=1";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				foreach($dataReader1 as $row1)
				{
					$vtotalbebanpajaknonrutinperusahaan = $row1['hitung'];
				}

				$sql1 = "select ifnull(sum(amount),0)*-1 as hitung
					from employeewagedetail a
					inner join wagetype b on b.wagetypeid = a.wagetypeid
					where a.employeewageid = ".$row['employeewageid']." and b.ispph = 1 and b.isrutin=1 and 
					paidbycompany=0";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				foreach($dataReader1 as $row1)
				{
					$vtotalbebanpajakrutinpekerja = $row1['hitung'];
				}

				$sql1 = "select ifnull(a.taxvalue,0) * 12 as hitung
					from employeestatus a
					inner join employee b on b.employeestatusid = a.employeestatusid
					where b.employeeid = ".$row['employeeid'].";";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				foreach($dataReader1 as $row1)
				{
					$vptkp = $row1['hitung'];
				}
				
				$sql1 = "select ifnull(sum(amount),0)*-1 as hitung
					from employeewagedetail a
					inner join wagetype b on b.wagetypeid = a.wagetypeid
					where a.employeewageid = ".$row['employeewageid']." and b.ispph = 1 and b.isrutin=0 and paidbycompany=0 and
						b.wagetypeid = getparamvalue('penalty');";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				foreach($dataReader1 as $row1)
				{
					$vpenalty = $row1['hitung'];
				}
				
				$vpercenttaxcost=0;
				$sql1 = "select getparamvalue('percenttaxcost') as hitung";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				foreach($dataReader1 as $row1)
				{
					$vpercenttaxcost = $row1['hitung'];
				}
				
				$vtaxcostlimit=0;
				$sql1 = "select getparamvalue('taxcostlimit') as hitung";
				$command1=$connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				foreach($dataReader1 as $row1)
				{
					$vtaxcostlimit = $row1['hitung'];
				}
				
				$vtunjanganpph = 0;
				$vbrutosetahun = 0;
				$vbiayajabatansetahun = 0;
				$vnettosetahun = 0;
				$vpkp = 0;
				$vpph = 0;
				$vpphsebulan = 0;
				$this->grossup($vtotalbebanpajakrutinperusahaan,
					$vtotalbebanpajaknonrutinperusahaan,
					$vtotalbebanpajakrutinpekerja,
					$vpenalty,
					$vtunjanganpph,
					$vpercenttaxcost,
					$vtaxcostlimit);
			}
	*/				
			$transaction->commit();
			$this->GetSMessage('pprinsertsuccess');
        }		
        catch(Exception $e) // an exception is raised if a query fails
        {
            $transaction->rollBack();
            $this->GetMessage($e->getMessage());
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
		$model=Payrollprocess::model()->findByPk((int)$id);
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

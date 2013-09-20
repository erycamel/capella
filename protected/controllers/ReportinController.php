<?php

class ReportinController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'reportin';

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
    $model=new Reportin('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reportin']))
			$model->attributes=$_GET['Reportin'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionDownload()
  {
    parent::actionDownload();
    $pdf = new PDF();
	  $pdf->title='Report Absence List';
	  $pdf->AddPage('L');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select a.employeeid,a.fullname, a.oldnik, b.levelorgname, c.structurename,d.positionname,e.employeetypename,
        f.sexname,joindate,email,phoneno,alternateemail,hpno,a.addressbookid
      from employee a
      left join levelorg b on b.levelorgid = a.levelorgid
      left join orgstructure c on c.orgstructureid = a.orgstructureid
      left join position d on d.positionid = a.positionid
      left join employeetype e on e.employeetypeid = a.employeetypeid
      left join sex f on f.sexid = a.sexid
inner join reportin g on g.employeeid = a.employeeid ";
      if ($_GET['id'] !== '') {
				$sql = $sql . "where g.reportinid = ".$_GET['id'];
		}
		$sql = $sql . " order by employeeid";
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
      $pdf->text(50,35,'Golongan: '.$row['levelorgname']);
      $pdf->text(50,40,'Struktur: '.$row['structurename']);
      $pdf->text(50,45,'Posisi: '.$row['positionname']);
      $pdf->text(50,50,'Jenis Kelamin: '.$row['sexname']);
      $pdf->text(50,55,'Email Utama: '.$row['email']);
      $pdf->text(50,65,'Email ke-2: '.$row['alternateemail']);
      $pdf->text(50,70,'Telp: '.$row['phoneno']);
      $pdf->text(50,75,'No HP: '.$row['hpno']);

      $sql1 = "select a.month,a.year,d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,
         d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31
        from reportin a
        where employeeid = ".$row['employeeid'].
        " and a.year = year(now())";
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $pdf->text(10,90,'Absence List');
      $pdf->SetY(95);
      $pdf->setaligns(array('C','C','C','C','C','C','C','C','C','C','C','C','C','C'
          ,'C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C'));
      $pdf->setwidths(array(10,10,8,8,8,8,8,8,8,8,8,8,8,8
          ,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8));
      $pdf->Row(array('Month','Year','1','2','3','4','5','6','7','8','9','10','11',
          '12','13','14','15','16','17','18','19','20','21','22','23','24','25',
          '26','27','28','29','30','31'));
      $pdf->setaligns(array('L','L','L','L','L','L','L','L','L','L','L','L','L'
          ,'L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $pdf->row(array($row1['month'],$row1['year'],$row1['d1'],$row1['d2'],
            $row1['d3'],$row1['d4'],$row1['d5'],$row1['d6'],$row1['d7'],$row1['d8'],$row1['d9']
            ,$row1['d10'],$row1['d11'],$row1['d12'],$row1['d13'],$row1['d14'],$row1['d15'],$row1['d16']
            ,$row1['d17'],$row1['d18'],$row1['d19'],$row1['d20'],$row1['d21'],$row1['d22'],$row1['d23']
            ,$row1['d24'],$row1['d25'],$row1['d26'],$row1['d27'],$row1['d28'],$row1['d29'],$row1['d30']
            ,$row1['d31']));
      }
      $pdf->AddPage('L');
    }
    $pdf->Output();
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
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Absrule::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Absrule();
			  }
			  $model->absruleid = (int)$data[0];
			  $model->absscheduleid = (int)$data[1];
			  $model->difftimein = $data[2];
			  $model->difftimeout = $data[3];
			  $model->absstatusid = (int)$data[4];
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

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Reportin::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='reportin-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

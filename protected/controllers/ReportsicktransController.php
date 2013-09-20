<?php

class ReportsicktransController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'reportsicktrans';
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

    $model=new Sicktrans('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Sicktrans']))
			$model->attributes=$_GET['Sicktrans'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model
		));
	}

    
  public function actionDownload()
  {
    parent::actionDownload();
    $pdf = new PDF();
	  $pdf->title='Sickness Transaction List';
	  $pdf->AddPage('P');
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
      left join sicktrans g on g.employeeid = a.employeeid
      where a.employeeid in (select distinct employeeid from sicktrans) ";

      if ($_GET['id'] !== '') {
				$sql = $sql . "and g.sicktransid = ".$_GET['id'];
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

      $sql1 = "select a.sickdate, a.nodocument, b.fullname, a.doctorname, 
        a.takedatefrom, a.takedateto, a.diagnosa
        from sicktrans a
        left join addressbook b on b.addressbookid = a.hospitalid
        where employeeid = ".$row['employeeid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $pdf->text(10,90,'Reportsicktrans List');
      $pdf->SetY(95);
      $pdf->setaligns(array('C','C','C','C','C','C','C'));
      $pdf->setwidths(array(25,25,35,30,25,25,25));
      $pdf->Row(array('Date','No Document','Hospital','Doctor Name',
          'Take Date From','Take Date To','Diagnosa'));
      $pdf->setaligns(array('L','L','L','L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $pdf->row(array($row1['sickdate'],$row1['nodocument'],$row1['fullname'],
            $row1['doctorname'],$row1['takedatefrom'],$row1['takedateto'],$row1['diagnosa']));
      }
      $pdf->AddPage('P');
    }
    // me-render ke browser
    $pdf->Output('sicktrans.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Reportsicktrans::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sicktrans-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

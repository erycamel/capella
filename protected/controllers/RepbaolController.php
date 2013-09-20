<?php

class RepbaolController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'repbaol';

	public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpnetwork'; break;
				case 4 : $this->txt = '_helpnetworkmodif'; break;
			}
		}
		parent::actionHelp();
	}

	public $baoldetail;

	public function lookupdata()
	{
		$this->baoldetail=new Baoldetail('search');
	  $this->baoldetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Baoldetail']))
		$this->baoldetail->attributes=$_GET['Baoldetail'];
	}
	
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
		$model=new Baol;
		$model->recordstatus=Wfgroup::model()->findstatusbyuser('insbaol');
		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'baolid'=>$model->baolid,
				  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
					'baoldetail'=>$this->baoldetail), true)
				  ));
			  Yii::app()->end();
			}
        }
	}
	
	public function actionCreatedetail()
	{
		parent::actionCreate();
		$baoldetail=new baoldetail;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formdetail',
				  array('model'=>$baoldetail), true)
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
		parent::actionCreate();
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

	  $this->lookupdata();

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'baolid'=>$model->baolid,
				'baoldate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->baoldate)),
                'soheaderid'=>$model->soheaderid,
                'contractno'=>($model->soheader!==null)?$model->soheader->contractno:"",
                'pic'=>$model->pic,
                'jabatan'=>$model->jabatan,
                'piccust'=>$model->piccust,
                'jabatancust'=>$model->jabatancust,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
					'baoldetail'=>$this->baoldetail), true)
				));
            Yii::app()->end();
        }
	}
	
	public function actionUpdatedetail()
	{
		$id=$_POST['id'];
	  $projectemp=$this->loadModelemp($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'baoldetailid'=>$projectemp->baoldetailid,
				'projectid'=>$model->projectid,
                'projectno'=>($model->project!==null)?$model->project->projectno:"",
                'div'=>$this->renderPartial('_formemployee',
				  array('model'=>$projectemp), true)
				));
            Yii::app()->end();
        }
	}
	
		    public function actionCancelWrite()
    {
      $model = Baol::model()->findbypk($_POST['Baol']['baolid']);
      if ($model != null)
      {
        $model->Delete();
      }
      $this->DeleteLockCloseForm($this->menuname, $_POST['Baol'], $_POST['Baol']['baolid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Baol']))
	  {
         $messages = $this->ValidateData(
                array(
				array($_POST['Baol']['baoldate'],'ppemptybaoldate','emptystring'),
				array($_POST['Baol']['pic'],'ppemptypic','emptystring'),
				array($_POST['Baol']['jabatan'],'ppemptyjabatan','emptystring'),
				array($_POST['Baol']['piccust'],'ppemptypiccust','emptystring'),
				array($_POST['Baol']['jabatancust'],'ppemptyjabatancust','emptystring'),
				array($_POST['Baol']['soheaderid'],'ppemptysoheaderid','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Baol']['baolid'] > 0)
		{
		  $model=$this->loadModel($_POST['Baol']['baolid']);
		  $model->baolid = $_POST['Baol']['baolid'];
		  $model->baoldate = $_POST['Baol']['baoldate'];
		  $model->soheaderid = $_POST['Baol']['soheaderid'];
		  $model->pic = $_POST['Baol']['pic'];
		  $model->jabatan = $_POST['Baol']['jabatan'];
		  $model->piccust = $_POST['Baol']['piccust'];
		  $model->jabatancust = $_POST['Baol']['jabatancust'];
		}
		else
		{
		  $model = new Baol();
		  $model->attributes=$_POST['Baol'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Baol']['baolid']);
              $this->GetSMessage('ppinsertsuccess');
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
	  if(isset($_POST['Baoldetail']))
	  {
	  $messages = $this->ValidateData(
                array(
				array($_POST['Baoldetail']['baolid'],'ppemptybaolid','emptystring'),
				array($_POST['Baoldetail']['projectid'],'ppemptyprojectid','emptystring'),
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Baoldetail']['Baoldetailid'] > 0)
		{
		  $model=Baoldetail::model()->findbyPK($_POST['Baoldetail']['Baoldetailid']);
		  $model->projectid = $_POST['Baoldetail']['projectid'];
		  $model->baolid = $_POST['Baoldetail']['baolid'];
						}
		else
		{
		  $model = new Baoldetail();
		  $model->attributes=$_POST['Baoldetail'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Baoldetail']['Baoldetailid']);
              $this->GetSMessage('ppinsertsuccess');
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
	
	public function actionGeneratedetail()
        {
          if(isset($_POST['id']))
	  {
              $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call GenerateBAOLPRJ(:vid, :vhid)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
				$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
					  'div'=>"Data generated"
					));
				}
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				  $transaction->rollBack();
				  if (Yii::app()->request->isAjaxRequest)
				  {
					  echo CJSON::encode(array(
						'status'=>'failure',
						'div'=>$e->getMessage()
					  ));
				  }
			  }
          }
           Yii::app()->end();
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
	
	public function actionDeletedetail()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Baoldetail::model()->findbyPK($ids);
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
            $sql = 'call Approvebaol(:vid, :vlastupdateby)';
            $command=$connection->createCommand($sql);
            $command->bindParam(':vid',$ids,PDO::PARAM_INT);
            $command->bindParam(':vlastupdateby', $a,PDO::PARAM_STR);
            $command->execute();
            $transaction->commit();
            $this->GetSMessage('pprinsertsuccess');
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
		$model=new Baol('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Baol']))
			$model->attributes=$_GET['Baol'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
					'baoldetail'=>$this->baoldetail
		));
	}

	public function actionIndexdetail()
	{
		$this->lookupdata();
	  $this->renderPartial('indexdetail',
		array('baoldetail'=>$this->baoldetail));
	  Yii::app()->end();
	}
	
	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select a.baolid,a.baolno,a.baoldate,a.pic,a.jabatan,a.piccust,a.jabatancust,c.fullname, b.contractno
      from baol a 
	  inner join soheader b on b.soheaderid = a.soheaderid 
	  inner join addressbook c on c.addressbookid = b.addressbookid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.baolid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
			$this->pdf->title='Berita Acara Online (BAOL)';
			$this->pdf->AddPage('P');
			$this->pdf->setFont('Arial','',10);

			foreach($dataReader as $row)
			{
				$this->pdf->text(10,35,'No BAOL: '.$row['baolno']);
				$this->pdf->text(110,35,'Tanggal BAOL: '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['baoldate'])));
				$this->pdf->text(10,50,'Yang bertanda tangan dibawah ini: ');
				$this->pdf->text(10,60,'1. Nama    : '.$row['pic']);
				$this->pdf->text(10,70,'   Jabatan : '.$row['jabatan']);
				$this->pdf->text(10,80,'   adalah mewakili PT. SATKOMINDO MEDIYASA selaku PENYELENGGARA');				
				$this->pdf->text(10,95,'2. Nama    : '.$row['piccust']);
				$this->pdf->text(10,105,'  Jabatan : '.$row['jabatancust']);
				$this->pdf->text(10,115,'   adalah mewakili '.$row['fullname'].' selaku PELANGGAN');				
				$this->pdf->text(10,130,'Menerangkan bahwa PENYELENGGARA telah memasang dan melakukan persiapan-persiapan untuk pelaksanaan');				
				$this->pdf->text(10,140,'penggunaan perangkat Sistem Komunikasi VSAT di tempat PELANGGAN');				
				$this->pdf->text(10,150,'Sesuai dengan hasil kerja tersebut, maka kedua belah pihak menyatakan :');		
				
				$sql1 = "select count(1) as jumlah from baoldetail a where a.baolid = ".$row['baolid'];
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				foreach($dataReader1 as $row1)
				{				
					$this->pdf->text(10,160,'Lokasi : '.$row['fullname']);				
					$this->pdf->text(10,170,'Alamat : Terlampir '.$row1['jumlah']. ' lokasi');				
				}
				$this->pdf->text(10,190,'Telah SIAP PAKAI (ON-LINE) pada tanggal online masing-masing unit kerja terlampir, dan dengan demikian');		
				$this->pdf->text(10,200,'PELANGGAN telah berkewajiban untuk membayar biaya-biaya sebagaimana diatur dalam :');		
				$this->pdf->text(10,210,'Surat Perjanjian Kerja (SPK) : '.$row['contractno']);		
				
				$this->pdf->AddPage('P');
				$this->pdf->text(10,50,'Demikian Berita Acara ini dibuat untuk dipergunakan sebagaimana mestinya.');		
				$this->pdf->text(10,80,'Pelanggan');$this->pdf->text(130,80,'Penyelenggara');		
				$this->pdf->text(10,90,$row['fullname']);$this->pdf->text(130,90,'PT SATKOMINDO MEDIYASA');
				
				$this->pdf->text(10,120,'Nama    : '.$row['piccust']);    $this->pdf->text(130,120,'Nama    : '.$row['pic']);		
				$this->pdf->text(10,130,'Jabatan : '.$row['jabatancust']);$this->pdf->text(130,130,'Jabatan : '.$row['jabatan']);

				$this->pdf->text(80,150,'Mengetahui : ');
				$this->pdf->text(60,190,'Nama    : ');
				$this->pdf->text(60,200,'Jabatan : ');

				
				$this->pdf->AddPage('P');
				
				$sql1 = "select a.projectid, b.projectno, b.onlinedate,
				(select destaddress from projectlocation a1 where a1.projectid = b.projectid order by projectid desc limit 1) as destaddress,
				(select upstream from projectnetwork a2 where a2.projectid = b.projectid order by projectid desc limit 1) as upstream,
				(select downstream from projectnetwork a3 where a3.projectid = b.projectid order by projectid desc limit 1) as downstream
				from baoldetail a 
				inner join project b on b.projectid = a.projectid 
				where a.baolid = ".$row['baolid'];
				$command1=$this->connection->createCommand($sql1);
				$dataReader1=$command1->queryAll();
				$this->pdf->setFont('Arial','B',8);

    $this->pdf->setaligns(array('C','C','C','C'));
    $this->pdf->setwidths(array(20,50,40,20));
    $this->pdf->Row(array('No','Unit Kerja','Tgl Online','Bandwith (up)/(down)'));
    $this->pdf->setaligns(array('L'));$i=1;
				foreach($dataReader1 as $row1)
				{				
					$this->pdf->row(array($i,$row1['destaddress'],date(Yii::app()->params['dateviewfromdb'], strtotime($row1['onlinedate'])),
					$row1['upstream'].'/'.$row1['downstream']));			
					$i++;
				}
				
				$this->pdf->text(10,80,'Pelanggan');$this->pdf->text(130,80,'Penyelenggara');		
				$this->pdf->text(10,90,$row['fullname']);$this->pdf->text(130,90,'PT SATKOMINDO MEDIYASA');
				
				$this->pdf->text(10,120,'Nama    : '.$row['piccust']);    $this->pdf->text(130,120,'Nama    : '.$row['pic']);		
				$this->pdf->text(10,130,'Jabatan : '.$row['jabatancust']);$this->pdf->text(130,130,'Jabatan : '.$row['jabatan']);
				
				$this->pdf->AddPage('P');
			}
			// me-render ke browser
			$this->pdf->Output();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Baol::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Baoldetail::model()->findByPk((int)$id);
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

<?php

class EmployeefacilityController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeefacility';

public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpdet'; break;
				case 4 : $this->txt = '_helpdetmodif'; break;
			}
		}
		parent::actionHelp();
	}

	public $employeefacilitydet;

		public function lookupdata()
	{
		$this->employeefacilitydet=new Employeefacilitydet('search');
	  $this->employeefacilitydet->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeefacilitydet']))
		$this->employeefacilitydet->attributes=$_GET['Employeefacilitydet'];
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
		$this->lookupdata();
		$model=new Employeefacility;
		$model->recordstatus=1;
		if (Yii::app()->request->isAjaxRequest)
        {
        if ($model->save()) {
            echo CJSON::encode(array(
                'status'=>'success',
                'employeefacilityid'=>$model->employeefacilityid,
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
                'employeefacilitydet'=>$this->employeefacilitydet), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionCreatedet()
	{
		parent::actionCreate();
		$employeefacilitydet=new Employeefacilitydet;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formdet',
				  array('model'=>$employeefacilitydet), true)
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
              'employeefacilityid'=>$model->employeefacilityid,
			  'employeeid'=>$model->employeeid,
              'fullname'=>($model->employee!==null)?$model->employee->fullname:"",
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
                'employeefacilitydet'=>$this->employeefacilitydet), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

	public function actionUpdatedet()
	{
	  $id=$_POST['id'];
	  $employeefacilitydet=$this->loadModeldet($id[0]);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'employeefacilitydetid'=>$employeefacilitydet->employeefacilitydetid,
			'facilitytypeid'=>$employeefacilitydet->facilitytypeid,
			'facilitytypename'=>($employeefacilitydet->facilitytype!==null)?$employeefacilitydet->facilitytype->facilitytypename:"",
              'startdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($employeefacilitydet->startdate)),
              'enddate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($employeefacilitydet->enddate)),
			  'div'=>$this->renderPartial('_formdet', array('model'=>$employeefacilitydet), true)
			  ));
		  Yii::app()->end();
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeefacility'], $_POST['Employeefacility']['employeefacilityid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Employeefacility']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeefacility']['employeeid'],'hrfefemptyemployeeid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Employeefacility']['employeefacilityid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeefacility']['employeefacilityid']);
		  $model->employeeid = $_POST['Employeefacility']['employeeid'];
		  $model->recordstatus = $_POST['Employeefacility']['recordstatus'];
		}
		else
		{
		  $model = new Employeefacility();
		  $model->attributes=$_POST['Employeefacility'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeefacility']['employeefacilityid']);
              $this->GetSMessage('mmsinsertsuccess');
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

	public function actionwriteemployeefacilitydet()
	{
		parent::actionWrite();
	  if(isset($_POST['Employeefacilitydet']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeefacilitydet']['facilitytypeid'],'hrfefemptyfacilitytypeid','emptystring'),
                array($_POST['Employeefacilitydet']['startdate'],'hrfefemptystartdate','emptystring'),
                array($_POST['Employeefacilitydet']['enddate'],'hrfefemptyenddate','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Employeefacilitydet']['employeefacilitydetid'] > 0)
		{
		  $model=Employeefacilitydet::model()->findbyPK($_POST['Employeefacilitydet']['employeefacilitydetid']);
		  $model->facilitytypeid = $_POST['Employeefacilitydet']['facilitytypeid'];
		  $model->startdate = $_POST['Employeefacilitydet']['startdate'];
		  $model->enddate = $_POST['Employeefacilitydet']['enddate'];
		}
		else
		{
		  $model = new Employeefacilitydet();
		  $model->attributes=$_POST['Employeefacilitydet'];
		}
		try
          {
            if($model->save())
            {
              $this->GetSMessage('mmprinsertsuccess');
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
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
            parent::actionDelete();
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

	public function actionDeletedet()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Employeefacilitydet::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		parent::actionIndex();
		$this->lookupdata();
	  $model=new Employeefacility('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeefacility']))
		  $model->attributes=$_GET['Employeefacility'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
                'employeefacilitydet'=>$this->employeefacilitydet
	  ));
	}

	public function actionIndexdet()
	{
		$this->lookupdata();
	  $this->renderPartial('indexdet',
		array('employeefacilitydet'=>$this->employeefacilitydet));
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
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Employeefacility::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Employeefacility();
			  }
			  $model->detbookid = (int)$data[0];
			  $model->fullname = $data[1];
			  $model->isemployeefacility = 1;
			  $model->recordstatus = (int)$data[2];
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

	public function actionDownload()
	{
		parent::actionDownload();
	  $pdf = new PDF();
	  $pdf->title='Employee Facility List';
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
      left join employeefacility g on g.employeeid = a.employeeid ";
if ($_GET['id'] !== '') {
				$sql = $sql . "where g.employeefacilityid = ".$_GET['id'];
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

      $sql1 = "select b.facilitytypename,a.startdate,a.enddate
        from employeefacilitydet a
        inner join employeefacility c on c.employeefacilityid = a.employeefacilityid
        inner join facilitytype b on b.facilitytypeid = a.facilitytypeid 
        where c.employeeid = ".$row['employeeid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $pdf->text(10,90,'Facility List');
      $pdf->SetY(95);
      $pdf->setaligns(array('C','C','C'));
      $pdf->setwidths(array(50,50,50));
      $pdf->Row(array('Facility Type','Start Date','End Date'));
      $pdf->setaligns(array('L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $pdf->row(array($row1['facilitytypename'],$row1['startdate'],$row1['enddate']));
      }
      $pdf->AddPage('P');
    }
	  // me-render ke browser
	  $pdf->Output('employeefacility.pdf','D');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Employeefacility::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldet($id)
	{
		$model=Employeefacilitydet::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='Employeefacility-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

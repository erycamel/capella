<?php

class EmployeefamilyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeefamily';

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

	public $employee,$familyrelation,$sex,$city,$education,$occupation;

	public function lookupdata()
	{
	  $this->employee=new Employee('searchwstatus');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$this->employee->attributes=$_GET['Employee'];

	  $this->familyrelation=new Familyrelation('searchwstatus');
	  $this->familyrelation->unsetAttributes();  // clear any default values
	  if(isset($_GET['Familyrelation']))
		$this->familyrelation->attributes=$_GET['Familyrelation'];

	  $this->sex=new Sex('searchwstatus');
	  $this->sex->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sex']))
		$this->sex->attributes=$_GET['Sex'];

	  $this->city=new City('searchwstatus');
	  $this->city->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$this->city->attributes=$_GET['City'];

	  $this->education=new Education('searchwstatus');
	  $this->education->unsetAttributes();  // clear any default values
	  if(isset($_GET['Education']))
		$this->education->attributes=$_GET['Education'];

	  $this->occupation=new Occupation('searchwstatus');
	  $this->occupation->unsetAttributes();  // clear any default values
	  if(isset($_GET['Occupation']))
		$this->occupation->attributes=$_GET['Occupation'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();

	  $model=new Employeefamily;

	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			'status'=>'success',
			'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
			'employee'=>$this->employee,
			'familyrelation'=>$this->familyrelation,
			'sex'=>$this->sex,
			'city'=>$this->city,
			'education'=>$this->education,
			'occupation'=>$this->occupation), true)
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
			'employeefamilyid'=>$model->employeefamilyid,
			'employeeid'=>$model->employeeid,
			'employeename'=>$model->employee->fullname,
			'familyrelationid'=>$model->familyrelationid,
			'familyrelationname'=>($model->familyrelation!==null)?$model->familyrelation->familyrelationname:"",
			'familyname'=>$model->familyname,
			'sexid'=>$model->sexid,
			'sexname'=>($model->sex!==null)?$model->sex->sexname:"",
			'cityid'=>$model->cityid,
			'cityname'=>($model->city!==null)?$model->city->cityname:"",
			'birthdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->birthdate)),
			'educationid'=>$model->educationid,
			'educationname'=>($model->education!==null)?$model->education->educationname:"",
			'occupationid'=>$model->occupationid,
			'occupationname'=>($model->occupation!==null)?$model->occupation->occupationname:"",
			'recordstatus'=>$model->recordstatus,
			'div'=>$this->renderPartial('_form', array('model'=>$model,
				'employee'=>$this->employee,
				'familyrelation'=>$this->familyrelation,
				'sex'=>$this->sex,
				'city'=>$this->city,
				'education'=>$this->education,
				'occupation'=>$this->occupation), true)
			));
		Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeefamily'],
              $_POST['Employeefamily']['employeefamilyid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeefamily']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeefamily']['employeeid'],'heefemptyemployeeid','emptystring'),
                array($_POST['Employeefamily']['familyrelationid'],'heefemptyfamilyrelationid','emptystring'),
                array($_POST['Employeefamily']['familyname'],'heefemptyfamilyname','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Employeefamily'];
		if ((int)$_POST['Employeefamily']['employeefamilyid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeefamily']['employeefamilyid']);
		  $model->employeeid = $_POST['Employeefamily']['employeeid'];
		  $model->familyrelationid = $_POST['Employeefamily']['familyrelationid'];
		  $model->familyname = $_POST['Employeefamily']['familyname'];
		  $model->sexid = $_POST['Employeefamily']['sexid'];
		  $model->cityid = $_POST['Employeefamily']['cityid'];
		  $model->birthdate = $_POST['Employeefamily']['birthdate'];
		  $model->educationid = $_POST['Employeefamily']['educationid'];
		  $model->occupationid = $_POST['Employeefamily']['occupationid'];
		  $model->recordstatus = $_POST['Employeefamily']['recordstatus'];
		}
		else
		{
		  $model = new Employeefamily();
		  $model->attributes=$_POST['Employeefamily'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeefamily']['employeefamilyid']);
              $this->GetSMessage('heefinsertsuccess');
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();
	  $model=new Employeefamily('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeefamily']))
		  $model->attributes=$_GET['Employeefamily'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
		  'employee'=>$this->employee,
		  'familyrelation'=>$this->familyrelation,
		  'sex'=>$this->sex,
		  'city'=>$this->city,
		  'education'=>$this->education,
		  'occupation'=>$this->occupation
	  ));
	}

	public function actionDownload()
  {
	parent::actionDownload();
    $pdf = new PDF();
	  $pdf->title='Employee Family List';
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
      left join employeefamily g on g.employeeid = a.employeeid ";
      if ($_GET['id'] !== '') {
				$sql = $sql . "where g.employeefamilyid= ".$_GET['id'];
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

      $sql1 = "select b.familyrelationname, a.familyname, c.sexname,d.cityname,
        e.educationname,f.occupationname,a.birthdate
        from employeefamily a
        left join familyrelation b on b.familyrelationid = a.familyrelationid
        left join sex c on c.sexid = a.sexid
        left join city d on d.cityid = a.cityid
        left join education e on e.educationid = a.educationid
        left join occupation f on f.occupationid = a.occupationid
        where employeeid = ".$row['employeeid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $pdf->text(10,90,'Family List');
      $pdf->SetY(95);
      $pdf->setaligns(array('C','C','C','C','C','C','C'));
      $pdf->setwidths(array(40,50,30,40,40,40,30));
      $pdf->Row(array('Family Relation','Family','Sex','City','Education','Occupation','Birth Date'));
      $pdf->setaligns(array('L','L','L','L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $pdf->row(array($row1['familyrelationname'],$row1['familyname'],
            $row1['sexname'],$row1['cityname'],$row1['educationname'],$row1['occupationname'],
date(Yii::app()->params['dateviewfromdb'], strtotime($row1['birthdate']))
));
      }

      $pdf->AddPage('L');
    }
    // me-render ke browser
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
			  $model=Employeefamily::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Employeefamily();
			  }
			  $model->employeefamilyid = (int)$data[0];
			  $model->employeeid = (int)$data[1];
			  $model->familyrelationid = (int)$data[2];
			  $model->familyname = $data[3];
			  $model->sexid = (int)$data[4];
			  $model->cityid = (int)$data[5];
			  $model->birthdate = $data[6];
			  $model->educationid = (int)$data[7];
			  $model->occupationid = (int)$data[8];
			  $model->recordstatus = (int)$data[9];
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
		$model=Employeefamily::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeefamily-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

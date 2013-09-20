<?php

class EmployeeeducationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeeeducation';

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
	
	public $employee,$city,$education;

	public function lookupdata()
	{
	  $this->employee=new Employee('searchwstatus');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$this->employee->attributes=$_GET['Employee'];

	  $this->city=new City('searchwstatus');
	  $this->city->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$this->city->attributes=$_GET['City'];

	  $this->education=new Education('searchwstatus');
	  $this->education->unsetAttributes();  // clear any default values
	  if(isset($_GET['Education']))
		$this->education->attributes=$_GET['Education'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Employeeeducation;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo  CJSON::encode(array(
			'status'=>'success',
			'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
			'employee'=>$this->employee,
			'city'=>$this->city,
			'education'=>$this->education), true)
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
        if (Yii::app()->request->isAjaxRequest)
        {
			echo CJSON::encode(array('status'=>'success',
				'employeeeducationid'=>$model->employeeeducationid,
				'employeeid'=>$model->employeeid,
				'fullname'=>$model->employee->fullname,
				'educationid'=>$model->educationid,
				'educationname'=>$model->education->educationname,
				'schoolname'=>$model->schoolname,
				'schooldegree'=>$model->schooldegree,
				'cityid'=>$model->cityid,
				'cityname'=>$model->city->cityname,
				'yeargraduate'=>$model->yeargraduate,
				'isdiploma'=>$model->isdiploma,
				'recordstatus'=>$model->recordstatus,
				'div'=>$this->renderPartial('_form', array('model'=>$model,
				'employee'=>$this->employee,
				'city'=>$this->city,
				'education'=>$this->education), true)
				));
			Yii::app()->end();
		}
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeeeducation'],
              $_POST['Employeeeducation']['employeeeducationid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeeeducation']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeeeducation']['employeeid'],'heeeemptyemployeeid','emptystring'),
                array($_POST['Employeeeducation']['educationid'],'heeeemptyeducationid','emptystring'),
                array($_POST['Employeeeducation']['schoolname'],'heeeemptyschoolname','emptystring'),
                array($_POST['Employeeeducation']['cityid'],'heeeemptycityid','emptystring'),
                array($_POST['Employeeeducation']['yeargraduate'],'heeeemptyyeargraduate','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Employeeeducation'];
		if ((int)$_POST['Employeeeducation']['employeeeducationid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeeeducation']['employeeeducationid']);
		  $model->employeeid = $_POST['Employeeeducation']['employeeid'];
		  $model->educationid = $_POST['Employeeeducation']['educationid'];
		  $model->schoolname = $_POST['Employeeeducation']['schoolname'];
		  $model->cityid = $_POST['Employeeeducation']['cityid'];
		  $model->yeargraduate = $_POST['Employeeeducation']['yeargraduate'];
		  $model->schooldegree = $_POST['Employeeeducation']['schooldegree'];
		  $model->isdiploma = $_POST['Employeeeducation']['isdiploma'];
		  $model->recordstatus = $_POST['Employeeeducation']['recordstatus'];
		}
		else
		{
		  $model = new Employeeeducation();
		  $model->attributes=$_POST['Employeeeducation'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeeeducation']['employeeeducationid']);
              $this->GetSMessage('heeeinsertsuccess');
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
	  $model=new Employeeeducation('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeeeducation']))
		  $model->attributes=$_GET['Employeeeducation'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
		  'employee'=>$this->employee,
		  'city'=>$this->city,
		  'education'=>$this->education
	  ));
	}

	public function actionUpload()
	{
      parent::actionUpload();
	  $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
	  $allowedExtensions = array("csv");
	  $sizeLimit = (int)Yii::app()->params['sizeLimit'];// maximum file size in bytes
	  $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	  $result = $uploader->handleUpload($folder,true);
	  $row = 0;
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>0) {
			  $model=Employeeeducation::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Employeeeducation();
			  }
			  $model->employeeeducationid = (int)$data[0];
			  $model->employeeid = $data[1];
			  $model->educationid = $data[2];
			  $model->schoolname = $data[3];
			  $model->cityid = (int)$data[4];
			  $model->yeargraduate = (int)$data[5];
				$model->isdiploma=(int)$data[6];
				$model->recordstatus=(int)$data[7];
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
    $sql = "select a.employeeid,a.fullname, a.oldnik, b.levelorgname, c.structurename,d.positionname,e.employeetypename,
        f.sexname,a.joindate,a.email,a.phoneno,a.alternateemail,a.hpno,a.addressbookid,a.accountno,a.taxno,g.maritalstatusname,
        h.religionname,a.birthdate,i.cityname
      from employee a
	  left join levelorg b on b.levelorgid = a.levelorgid
      left join orgstructure c on c.orgstructureid = a.orgstructureid
      left join position d on d.positionid = a.positionid
      left join employeetype e on e.employeetypeid = a.employeetypeid
      left join sex f on f.sexid = a.sexid
	  left join maritalstatus g on g.maritalstatusid = a.maritalstatusid
	  left join religion h on h.religionid = a.religionid
      left join city i on i.cityid = a.birthcityid
      inner join employeeeducation j on j.employeeid = a.employeeid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where j.employeeeducationid = ".$_GET['id'];
		}
		$sql = $sql . " order by employeeid";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->title='Employee Education List';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',12);
	  
	  foreach($dataReader as $row)
    {
      if (file_exists($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'.$row['oldnik'].'.jpg'))
      {
        $this->pdf->Image($_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/images/employee/photo-'. $row['oldnik'] .'.jpg',10,30,30);
      }
      $this->pdf->setFont('Arial','B',10);
      $this->pdf->text(50,30,'Nama: '.$row['fullname']);
      $this->pdf->setFont('Arial','',8);
      $this->pdf->text(50,35,'Golongan: '.$row['levelorgname']);
      $this->pdf->text(50,40,'Struktur: '.$row['structurename']);
      $this->pdf->text(50,45,'Posisi: '.$row['positionname']);
      $this->pdf->text(50,50,'Jenis Kelamin: '.$row['sexname']);
      $this->pdf->text(50,55,'Email Utama: '.$row['email']);
      $this->pdf->text(50,65,'Email ke-2: '.$row['alternateemail']);
      $this->pdf->text(50,70,'Telp: '.$row['phoneno']);
      $this->pdf->text(50,75,'No HP: '.$row['hpno']);

      $sql1 = "select b.educationname,a.schoolname,c.cityname,a.yeargraduate,a.schooldegree
        from employeeeducation a
        left join education b on b.educationid = a.educationid
		left join city c on c.cityid = a.cityid
        where employeeid = ".$row['employeeid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      // definisi font
	  $this->pdf->setFont('Arial','B',8);
$this->pdf->SetY(95);
    $this->pdf->setaligns(array('C','C','C','C','C'));
    $this->pdf->setwidths(array(50,40,40,40,20));
    $this->pdf->Row(array('Education','School','City','Year Graduate','School Degree'));
    $this->pdf->setaligns(array('L','L','L','L','L'));
    foreach($dataReader1 as $row1)
    {
      $this->pdf->row(array($row1['educationname'],$row1['schoolname'],$row1['cityname'],
          $row1['yeargraduate'],$row1['schooldegree']));
    }

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
		$model=Employeeeducation::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeeeducation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

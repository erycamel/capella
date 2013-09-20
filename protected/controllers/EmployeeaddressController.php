<?php

class EmployeeaddressController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'employeeaddress';

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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $model=new Employeeaddress;
	  if (Yii::app()->request->isAjaxRequest)
      {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_form', array('model'=>$model), true)
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

	  $id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
      if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
		  echo CJSON::encode(array(
			'status'=>'success',
            'addressid'=>$model->addressid,
			'addressbookid'=>$model->addressbookid,
			'fullname'=>($model->addressbook!==null)?$model->addressbook->fullname:"",
			'addresstypeid'=>$model->addresstypeid,
			'addresstypename'=>($model->addresstype!==null)?$model->addresstype->addresstypename:"",
			'addressname'=>$model->addressname,
			'rt'=>$model->rt,
			'rw'=>$model->rw,
			'cityid'=>$model->cityid,
			'cityname'=>($model->city!==null)?$model->city->cityname:"",
			'kelurahanid'=>$model->kelurahanid,
			'kelurahanname'=>($model->kelurahan!==null)?$model->kelurahan->kelurahanname:"",
			'subdistrictid'=>$model->subdistrictid,
			'subdistrictname'=>($model->subdistrict!==null)?$model->subdistrict->subdistrictname:"",
			'phoneno'=>$model->phoneno,
			'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Employeeaddress'], $_POST['Employeeaddress']['addressbookid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Employeeaddress']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeeaddress']['addressbookid'],'cobnemptyaddressbook','emptystring'),
                array($_POST['Employeeaddress']['addresstypeid'],'cobnemptyaddresstype','emptystring'),
                array($_POST['Employeeaddress']['addressname'],'cobnemptyaddressname','emptystring'),
                array($_POST['Employeeaddress']['cityid'],'cobnemptycity','emptystring'),
            )
        );
        if ($messages == '') {
		  //$dataku->attributes=$_POST['Employeeaddress'];
		  if ((int)$_POST['Employeeaddress']['addressid'] > 0)
		{
		  $model=Employeeaddress::model()->findbyPK($_POST['Employeeaddress']['addressid']);
		  $model->addressbookid = $_POST['Employeeaddress']['addressbookid'];
		  $model->addresstypeid = $_POST['Employeeaddress']['addresstypeid'];
		  $model->addressname = $_POST['Employeeaddress']['addressname'];
		  $model->rt = $_POST['Employeeaddress']['rt'];
		  $model->rw = $_POST['Employeeaddress']['rw'];
		  $model->cityid = $_POST['Employeeaddress']['cityid'];
		  $model->kelurahanid = $_POST['Employeeaddress']['kelurahanid'];
		  $model->subdistrictid = $_POST['Employeeaddress']['subdistrictid'];
		  $model->recordstatus = $_POST['Employeeaddress']['recordstatus'];
		  $model->phoneno = $_POST['Employeeaddress']['phoneno'];
		}
		else
		{
		  $model = new Employeeaddress();
		  $model->attributes=$_POST['Employeeaddress'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Employeeaddress']['addressid']);
              $this->GetSMessage('cobninsertsuccess');
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

	  $model=new Employeeaddress('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeeaddress']))
		  $model->attributes=$_GET['Employeeaddress'];
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
      inner join addressbook j on j.addressbookid = a.addressbookid
		inner join address k on k.addressbookid = j.addressbookid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where k.addressid = ".$_GET['id'];
		}
		$sql = $sql . " order by employeeid";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
	  $this->pdf->title='Employee Address List';
	  $this->pdf->AddPage('P');
	  $this->pdf->setFont('Arial','B',12);

	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

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

      $sql1 = "select b.addresstypename, a.addressname, c.cityname, a.phoneno
        from address a
        left join addresstype b on b.addresstypeid = a.addresstypeid
        left join city c on c.cityid = a.cityid
        where addressbookid = ".$row['addressbookid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->text(10,90,'Address List');
      $this->pdf->SetY(95);
      $this->pdf->setaligns(array('C','C','C','C'));
      $this->pdf->setwidths(array(50,50,50,30));
      $this->pdf->Row(array('Address Type','Address','City','Phone No'));
      $this->pdf->setaligns(array('L','L','L','L'));
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['addresstypename'],$row1['addressname'],$row1['cityname'],$row1['phoneno']));
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
		$model=Employeeaddress::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employee-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

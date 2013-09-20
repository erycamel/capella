<?php

class SojasaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'soheader';

    public $customer,$projecttype,$employee,$currency,$servicetype;

    public function lookupdata()
    {
      		$this->customer=new Customer('search');
	  $this->customer->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$this->customer->attributes=$_GET['Customer'];
		
		$this->projecttype=new Projecttype('search');
	  $this->projecttype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Projecttype']))
		$this->projecttype->attributes=$_GET['Projecttype'];
		
		$this->employee=new Employee('search');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$this->employee->attributes=$_GET['Employee'];
		
		$this->currency=new Currency('search');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];
		
		$this->servicetype=new Servicetype('search');
	  $this->servicetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Servicetype']))
		$this->servicetype->attributes=$_GET['Servicetype'];
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
	  $this->lookupdata();

      $model=new Soheader;
      if (Yii::app()->request->isAjaxRequest)
      {
            echo CJSON::encode(array(
                'status'=>'success',
                'soheaderid'=>$model->soheaderid,
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
                  'customer'=>$this->customer,
				  'projecttype'=>$this->projecttype,
				  'employee'=>$this->employee,
				  'servicetype'=>$this->servicetype,
                    'currency'=>$this->currency), true)
                ));
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
				'soheaderid'=>$model->soheaderid,
				'sono'=>$model->sono,
				'contractno'=>$model->contractno,
				'startdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->startdate)),
				'enddate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->enddate)),
				'projectvalue'=>$model->projectvalue,
				'addressbookid'=>$model->addressbookid,
				'fullname'=>($model->customer!==null)?$model->customer->fullname:"",
				'projecttypeid'=>$model->projecttypeid,
				'projecttypecode'=>($model->projecttype!==null)?$model->projecttype->projecttypecode:"",
				'personincharge'=>$model->personincharge,
				'employeeid'=>$model->employeeid,
				'employeename'=>($model->employee!==null)?$model->employee->fullname:"",
				'currencyid'=>$model->currencyid,
				'currencyname'=>($model->currency!==null)?$model->currency->currencyname:"",
				'recordstatus'=>$model->recordstatus,
				'projectname'=>$model->projectname,
				'servicetypeid'=>$model->servicetypeid,
				'servicetypename'=>($model->servicetype!==null)?$model->servicetype->servicetypename:"",
                'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'customer'=>$this->customer,
				  'projecttype'=>$this->projecttype,
				  'employee'=>$this->employee,
				  'servicetype'=>$this->servicetype,
                    'currency'=>$this->currency), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Soheader'], $_POST['Soheader']['soheaderid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Soheader']))
	  {
        $messages = $this->ValidateData(
                array(
				array($_POST['Soheader']['addressbookid'],'sdsoemptyaddressbookid','emptystring'),
				array($_POST['Soheader']['projectvalue'],'sdsoemptyprojectvalue','emptystring'),
				array($_POST['Soheader']['currencyid'],'sdsoemptycurrencyid','emptystring'),
				array($_POST['Soheader']['projecttypeid'],'sdsoemptyprojecttypeid','emptystring'),
				array($_POST['Soheader']['projectname'],'sdsoemptyprojectname','emptystring'),
				array($_POST['Soheader']['startdate'],'sdsoemptystartdate','emptystring'),
				array($_POST['Soheader']['enddate'],'sdsoemptyenddate','emptystring'),
				array($_POST['Soheader']['personincharge'],'sdsoemptypersonincharge','emptystring'),
				array($_POST['Soheader']['servicetypeid'],'sdsoemptyservicetypeid','emptystring'),
				array($_POST['Soheader']['employeeid'],'sdsoemptyemployeeid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Soheader']['soheaderid'] > 0)
		{
		  $model=$this->loadModel($_POST['Soheader']['soheaderid']);
		  $model->addressbookid = $_POST['Soheader']['addressbookid'];
		  $model->contractno = $_POST['Soheader']['contractno'];
		  $model->projectvalue = $_POST['Soheader']['projectvalue'];
		  $model->personincharge = $_POST['Soheader']['personincharge'];
		  $model->employeeid = $_POST['Soheader']['employeeid'];
		  $model->currencyid = $_POST['Soheader']['currencyid'];
		  $model->projecttypeid = $_POST['Soheader']['projecttypeid'];
		  $model->servicetypeid = $_POST['Soheader']['servicetypeid'];
		}
		else
		{
		  $model = new Soheader();
		  $model->attributes=$_POST['Soheader'];
		}
		 try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Soheader']['soheaderid']);
              $this->GetSMessage('sdsoinsertsuccess');
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
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
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

	public function actionApprove()
	{
		parent::actionApprove();
		$id=$_POST['id'];
		foreach($id as $ids)
		{
			$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call ApproveSO(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$ids,PDO::PARAM_INT);
				$command->bindvalue(':vlastupdateby', Yii::app()->user->name,PDO::PARAM_STR);
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
      $model=new Soheader('search');
      $model->unsetAttributes();  // clear any default values
      if(isset($_GET['Soheader']))
          $model->attributes=$_GET['Soheader'];
      if (isset($_GET['pageSize']))
      {
        Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
        unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
      }

      $this->render('index',array(
          'model'=>$model,
                  'customer'=>$this->customer,
				  'projecttype'=>$this->projecttype,
				  'employee'=>$this->employee,
				  'servicetype'=>$this->servicetype,
                    'currency'=>$this->currency
      ));
	}

	public function actionIndexdetail()
	{
      $this->lookupdetail();

	  $this->renderPartial('indexdetail',
		array('sodetail'=>$sodetail,
					'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure));
	  Yii::app()->end();
	}
	
	public function actionUpload()
	{
		parent::actionUpload();
		$folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploadfile']['name']); 
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
			echo "success";
			$row=0;			
			if (($handle = fopen($file, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					if ($row>0) {
						$model = new Soheader();
						$cust = Customer::model()->findbyattributes(array('fullname'=>$data[0]));
						if ($cust !== null)
						{
							$model->addressbookid = $cust->addressbookid;
						}
						$model->sodate = $data[1];
						$model->postdate = $data[1];
						$model->contractno = $data[2];
						$model->startdate = $data[3];
						$model->enddate = $data[4];
						$model->projectvalue = $data[5];
						$protype = Projecttype::model()->findbyattributes(array('projecttypecode'=>$data[6]));
						if ($protype !== null)
						{
							$model->projecttypeid = $protype->projecttypeid;
						}
						$model->projectname = $data[7];
						$model->personincharge = $data[8];
						$emp = Employee::model()->findbyattributes(array('fullname'=>$data[9]));
						if ($emp !== null)
						{
							$model->employeeid = $emp->employeeid;
						}
						$curr = Currency::model()->findbyattributes(array('currencyname'=>$data[10]));
						if ($curr !== null)
						{
							$model->currencyid = $curr->currencyid;
						}
						$curr = Servicetype::model()->findbyattributes(array('servicetypename'=>$data[11]));
						if ($curr !== null)
						{
							$model->servicetypeid = $curr->servicetypeid;
						}
						$model->recordstatus = $data[12];
					  try
					  {
						if(!$model->save())
						{
						  echo $model->getErrors();
						}
					  }
					  catch (Exception $e)
					  {
						echo $e->getMessage();;
					  }
					}
					$row++;
				}
				fclose($handle);
			}
		} else {
			echo Yii::t('app','directory permission');
		}	
	}

	public function actionDownload()
  {
  parent::actionDownload();
    $sql = "select a.sono, a.sodate, b.fullname,  a.contractno, a.startdate, a.enddate, a.projectvalue, c.projecttypecode, a.projectname, a.personincharge, 
	d.fullname as employeename, e.currencyname, f.servicetypename
				from soheader a
left join addressbook b on b.addressbookid = a.addressbookid
left join projecttype c on c.projecttypeid = a.projecttypeid
left join employee d on d.employeeid = a.employeeid
left join currency e on e.currencyid = a.currencyid
left join servicetype f on f.servicetypeid = a.servicetypeid 				";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.soheaderid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

    $this->pdf->title='Sales Order List';
		$this->pdf->AddPage('L');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C','C','C','C','C','C','C','C','C','C','C'));
		$this->pdf->setwidths(array(20,20,20,20,20,20,30,20,20,20,20,20,20));
		$this->pdf->Row(array('SO No','SO Date','Customer','Contract No','Start Date','End Date','Project Value','Project Type','Project Name','PIC','Sales','Currency',
		'Service Type'));
		$this->pdf->setaligns(array('L','L','L','L','L','L','L','L','L','L'));
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['sono'],$row1['sodate'],$row1['fullname'],$row1['contractno'],
		  date(Yii::app()->params['dateviewfromdb'], strtotime($row1['startdate'])),
		  date(Yii::app()->params['dateviewfromdb'], strtotime($row1['enddate'])),
		  Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['projectvalue']),
		  $row1['projecttypecode'],$row1['projectname'],$row1['personincharge'],
		  $row1['employeename'],$row1['currencyname'],$row1['servicetypename']));

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
		$model=Soheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Sodetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='soheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='sodetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

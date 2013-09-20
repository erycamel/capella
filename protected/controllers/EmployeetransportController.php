<?php

class EmployeetransportController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'employeetransport';

	public function actionHelp()
	{
	  $txt = '';
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $txt = '_help'; break;
				case 2 : $txt = '_helpmodif'; break;
			}
		}
	  parent::actionHelp($txt);
	}
	public $employee,$transunitprice;

	public function lookupdata()
	{
	  $this->employee=new Employee('searchwstatus');
	  $this->employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$this->employee->attributes=$_GET['Employee'];

	  $this->transunitprice=new Transunitprice('searchwstatus');
	  $this->transunitprice->unsetAttributes();  // clear any default values
	  if(isset($_GET['Transunitprice']))
		$this->transunitprice->attributes=$_GET['Transunitprice'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Employeetransport;

	  if (Yii::app()->request->isAjaxRequest)
	  {
		echo CJSON::encode(array(
			'status'=>'success',
			'div'=>$this->renderPartial('_form', array('model'=>$model,
				'employee'=>$this->employee,
				'transunitprice'=>$this->transunitprice), true)
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
		echo CJSON::encode(array(
			'status'=>'success',
			'employeetransportid'=>$model->employeetransportid,
			'employeeid'=>$model->employeeid,
			'fullname'=>$model->employee->fullname,
			'transunitpriceid'=>$model->transunitpriceid,
			'pricetypename'=>$model->transunitprice->pricetype->pricetypename,
			'recordstatus'=>$model->recordstatus,
			'div'=>$this->renderPartial('_form', array('model'=>$model,
				'employee'=>$this->employee,
				'transunitprice'=>$this->transunitprice), true)
			));
		Yii::app()->end();
	  }
	}

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Employeetransport']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Employeetransport']['employeeid'],'hfetemptyemployeeid','emptystring'),
            array($_POST['Employeetransport']['transunitpriceid'],'hfetemptytransunitpriceid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Employeetransport']['employeetransportid'] > 0)
		{
		  $model=$this->loadModel($_POST['Employeetransport']['employeetransportid']);
		  $model->employeeid = $_POST['Employeetransport']['employeeid'];
		  $model->transunitpriceid = $_POST['Employeetransport']['transunitpriceid'];
		  $model->recordstatus = $_POST['Employeetransport']['recordstatus'];
		}
		else
		{
		  $model = new Employeetransport();
		  $model->attributes=$_POST['Employeetransport'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Company']['companyid']);
              $this->GetSMessage('hfetinsertsuccess');
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
	  $model=new Employeetransport('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employeetransport']))
		  $model->attributes=$_GET['Employeetransport'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
		  'employee'=>$this->employee,
		  'transunitprice'=>$this->transunitprice
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
			  $model=Employeetransport::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Employeetransport();
			  }
			  $model->employeetransportid = (int)$data[0];
			  $model->employeeid = $data[1];
			  $model->transunitpriceid = $data[2];
			  $model->recordstatus = (int)$data[3];
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
    $pdf->title='Employee Transport List';
    $pdf->AddPage('P');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Employee','Unit Price','Currency');
    $model=new Employeetransport('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    $cols = $dataprovider->getKeys();
    $dataku=array(count($data));
    //var_dump($dataku);
    $w= array(20,25,50,30,30);

    $pdf->SetTableHeader();
    //Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $pdf->Ln();
    $pdf->SetTableData();
    //Data
    $fill=false;
    $i=0;
    foreach($data as $datas)
    {
        $i=$i+1;
        $pdf->Cell($w[0],6,$i,'LR',0,'L',$fill);
        $pdf->Cell($w[1],6,$datas['employeetransportid'],'LR',0,'L',$fill);
        $pdf->Cell($w[2],6,Employee::model()->findbypk($datas['employeeid'])->fullname,'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,Transunitprice::model()->findbypk($datas['transunitpriceid'])->price,'LR',0,'L',$fill);
        $pdf->Cell($w[4],6,Currency::model()->findbypk(Transunitprice::model()->findbypk($datas['transunitpriceid'])->currencyid)->currencyname,'LR',0,'L',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');
    // me-render ke browser
    $pdf->Output('employeetransport.pdf','D');
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Employeetransport::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='employeetransport-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

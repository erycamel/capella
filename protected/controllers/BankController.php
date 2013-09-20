<?php

class BankController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'bank';

public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpaddress'; break;
				case 4 : $this->txt = '_helpaddressmodif'; break;
				case 5 : $this->txt = '_helpcontact'; break;
				case 6 : $this->txt = '_helpcontactmodif'; break;
			}
		}
		parent::actionHelp();
	}

	public $bankaddress,$bankcontact,$accpiutang;

		public function lookupdata()
	{
		$this->bankaddress=new Bankaddress('search');
	  $this->bankaddress->unsetAttributes();  // clear any default values
	  if(isset($_GET['Bankaddress']))
		$this->bankaddress->attributes=$_GET['Bankaddress'];

		$this->bankcontact=new Bankcontact('search');
	  $this->bankcontact->unsetAttributes();  // clear any default values
	  if(isset($_GET['Bankcontact']))
		$this->bankcontact->attributes=$_GET['Bankcontact'];

      $this->accpiutang=new Account('search');
	  $this->accpiutang->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->accpiutang->attributes=$_GET['Account'];

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
		$this->lookupdata();
		$model=new Bank;
		$model->fullname='bankname';
		$model->isbank=1;
		$model->recordstatus=0;
		if (Yii::app()->request->isAjaxRequest)
        {
        if ($model->save()) {
            echo CJSON::encode(array(
                'status'=>'success',
                'addressbookid'=>$model->addressbookid,
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
                'bankaddress'=>$this->bankaddress,
                'bankcontact'=>$this->bankcontact,
                    'accpiutang'=>$this->accpiutang), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionCreateaddress()
	{
		parent::actionCreate();
		$this->lookupdata();

		$bankaddress=new Bankaddress;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formaddress',
				  array('model'=>$bankaddress), true)
				));
            Yii::app()->end();
        }
	}

	public function actionCreatecontact()
	{
		parent::actionCreate();
		$this->lookupdata();

		$bankcontact=new Bankcontact;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formcontact',
				  array('model'=>$bankcontact), true)
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
		$this->lookupdata();
	  if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addressbookid'=>$model->addressbookid,
			  'fullname'=>$model->fullname,
			  'taxno'=>$model->taxno,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
			  'bankaddress'=>$this->bankaddress,
			  'bankcontact'=>$this->bankcontact,
                    'accpiutang'=>$this->accpiutang), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

	public function actionUpdateaddress()
	{
	  $id=$_POST['id'];
	  $bankaddress=$this->loadModeladdress($id[0]);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addressid'=>$bankaddress->addressid,
			'addressbookid'=>$bankaddress->addressbookid,
			'fullname'=>($bankaddress->addressbook!==null)?$bankaddress->addressbook->fullname:"",
			'addresstypeid'=>$bankaddress->addresstypeid,
			'addresstypename'=>($bankaddress->addresstype!==null)?$bankaddress->addresstype->addresstypename:"",
			'addressname'=>$bankaddress->addressname,
			'rt'=>$bankaddress->rt,
			'rw'=>$bankaddress->rw,
			'cityid'=>$bankaddress->cityid,
			'cityname'=>$bankaddress->city->cityname,
			'kelurahanid'=>$bankaddress->kelurahanid,
			'kelurahanname'=>($bankaddress->kelurahan!==null)?$bankaddress->kelurahan->kelurahanname:"",
			'subdistrictid'=>$bankaddress->subdistrictid,
			'subdistrictname'=>($bankaddress->subdistrict!==null)?$bankaddress->subdistrict->subdistrictname:"",
              'phoneno'=>$bankaddress->phoneno,
			  'div'=>$this->renderPartial('_formaddress', array('model'=>$bankaddress), true)
			  ));
		  Yii::app()->end();
	  }
	}

	public function actionUpdatecontact()
	{
	  $id=$_POST['id'];
	  $bankcontact=$this->loadModelcontact($id[0]);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addresscontactid'=>$bankcontact->addresscontactid,
			'addressbookid'=>$bankcontact->addressbookid,
			'fullname'=>$bankcontact->addressbook->fullname,
			'contacttypeid'=>$bankcontact->contacttypeid,
			'contacttypename'=>$bankcontact->contacttype->contacttypename,
			'addresscontactname'=>$bankcontact->addresscontactname,
              'phoneno'=>$bankcontact->phoneno,
              'mobilephone'=>$bankcontact->mobilephone,
              'emailaddress'=>$bankcontact->emailaddress,
			  'div'=>$this->renderPartial('_formcontact', array('model'=>$bankcontact), true)
			  ));
		  Yii::app()->end();
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Bank'], $_POST['Bank']['addressbookid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Bank']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Bank']['fullname'],'mmsemptyfullname','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Bank']['addressbookid'] > 0)
		{
		  $model=$this->loadModel($_POST['Bank']['addressbookid']);
		  $model->fullname = $_POST['Bank']['fullname'];
		  $model->taxno = $_POST['Bank']['taxno'];
		  $model->accpiutangid = $_POST['Bank']['accpiutangid'];
		  $model->fullname = $_POST['Bank']['fullname'];
		  $model->recordstatus = $_POST['Bank']['recordstatus'];
		}
		else
		{
		  $model = new Bank();
		  $model->isbank = 1;
		  $model->attributes=$_POST['Bank'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Bank']['addressbookid']);
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

	public function actionWriteaddress()
	{
		parent::actionWrite();
	  if(isset($_POST['Bankaddress']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Bankaddress']['addresstypeid'],'mmpremptyaddresstypeid','emptystring'),
                array($_POST['Bankaddress']['addressname'],'mmpremptyaddressname','emptystring'),
                array($_POST['Bankaddress']['cityid'],'mmpremptycityid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Bankaddress']['addressid'] > 0)
		{
		  $model=Bankaddress::model()->findbyPK($_POST['Bankaddress']['addressid']);
		  $model->addressbookid = $_POST['Bankaddress']['addressbookid'];
		  $model->addresstypeid = $_POST['Bankaddress']['addresstypeid'];
		  $model->addressname = $_POST['Bankaddress']['addressname'];
		  $model->rt = $_POST['Bankaddress']['rt'];
		  $model->rw = $_POST['Bankaddress']['rw'];
		  $model->cityid = $_POST['Bankaddress']['cityid'];
		  $model->kelurahanid = $_POST['Bankaddress']['kelurahanid'];
		  $model->subdistrictid = $_POST['Bankaddress']['subdistrictid'];
		  $model->phoneno = $_POST['Bankaddress']['phoneno'];
		}
		else
		{
		  $model = new Bankaddress();
		  $model->attributes=$_POST['Bankaddress'];
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

	public function actionWritecontact()
	{
		parent::actionWrite();
	  if(isset($_POST['Bankcontact']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Bankcontact']['contacttypeid'],'mmpremptycontacttypeid','emptystring'),
                array($_POST['Bankcontact']['addresscontactname'],'mmpremptyaddresscontactname','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Bankcontact']['addresscontactid'] > 0)
		{
		  $model=Bankcontact::model()->findbyPK($_POST['Bankcontact']['addresscontactid']);
		  $model->addressbookid = $_POST['Bankcontact']['addressbookid'];
		  $model->contacttypeid = $_POST['Bankcontact']['contacttypeid'];
		  $model->addresscontactname = $_POST['Bankcontact']['addresscontactname'];
		  $model->phoneno = $_POST['Bankcontact']['phoneno'];
		  $model->mobilephone = $_POST['Bankcontact']['mobilephone'];
		  $model->emailaddress = $_POST['Bankcontact']['emailaddress'];
		}
		else
		{
		  $model = new Bankcontact();
		  $model->attributes=$_POST['Bankcontact'];
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

	public function actionDeleteaddress()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Bankaddress::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	public function actionDeletecontact()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Bankcontact::model()->findbyPK($ids);
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
	  $model=new Bank('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Bank']))
		  $model->attributes=$_GET['Bank'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
		  'bankaddress'=>$this->bankaddress,
		  'bankcontact'=>$this->bankcontact,
                    'accpiutang'=>$this->accpiutang
	  ));
	}

	public function actionIndexaddress()
	{
		$this->lookupdata();
	  $this->renderPartial('indexaddress',
		array('bankaddress'=>$this->bankaddress));
	  Yii::app()->end();
	}

	public function actionIndexcontact()
	{
		$this->lookupdata();
	  $this->renderPartial('indexcontact',
		array('bankcontact'=>$this->bankcontact));
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
			  $model=Bank::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Bank();
			  }
			  $model->addressbookid = (int)$data[0];
			  $model->fullname = $data[1];
			  $model->isbank = 1;
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
	  Yii::import('application.extensions.fpdf.*');
	  require_once("pdf.php");
	  $pdf = new PDF();
	  $pdf->title='Bank List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $header = array('No','ID','Bank Name');
	  $dataprovider=Bank::model()->searchwstatus();
	  $dataprovider->pagination=false;
	  $data = $dataprovider->getData();
	  //var_dump(count($data));
	  $w= array(10,25,70);

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
		  $pdf->Cell($w[1],6,$datas['addressbookid'],'LR',0,'L',$fill);
		  $pdf->Cell($w[2],6,$datas['fullname'],'LR',0,'L',$fill);
		  $pdf->Ln();
		  $fill=!$fill;
	  }
	  $pdf->Cell(array_sum($w),0,'','T');


	  // me-render ke browser
	  $pdf->Output('bank.pdf','D');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Bank::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeladdress($id)
	{
		$model=Bankaddress::model()->findByPk((int)$id);
		//if($model===null)
		//	throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelcontact($id)
	{
		$model=Bankcontact::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='Bank-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

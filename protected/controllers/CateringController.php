<?php

class CateringController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'catering';

public function actionHelp()
	{
		$txt = '';
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $txt = '_help'; break;
				case 2 : $txt = '_helpmodif'; break;
				case 3 : $txt = '_helpaddress'; break;
				case 4 : $txt = '_helpaddressmodif'; break;
				case 5 : $txt = '_helpcontact'; break;
				case 6 : $txt = '_helpcontactmodif'; break;
			}
		}
		parent::actionHelp($txt);
	}

	public $cateringaddress,$cateringcontact;

		public function lookupdata()
	{
		$this->cateringaddress=new Cateringaddress('search');
	  $this->cateringaddress->unsetAttributes();  // clear any default values
	  if(isset($_GET['Cateringaddress']))
		$this->cateringaddress->attributes=$_GET['Cateringaddress'];

		$this->cateringcontact=new Cateringcontact('search');
	  $this->cateringcontact->unsetAttributes();  // clear any default values
	  if(isset($_GET['Cateringcontact']))
		$this->cateringcontact->attributes=$_GET['Cateringcontact'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
		$this->lookupdata();
		$model=new Catering;
		$model->fullname='cateringname';
		$model->iscatering=1;
		$model->isvendor=1;
		$model->recordstatus=0;
		if (Yii::app()->request->isAjaxRequest)
        {
        if ($model->save()) {
            echo CJSON::encode(array(
                'status'=>'success',
                'addressbookid'=>$model->addressbookid,
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
                'cateringaddress'=>$this->cateringaddress,
                'cateringcontact'=>$this->cateringcontact), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionCreateaddress()
	{
		parent::actionCreate();
		$this->lookupdata();

		$cateringaddress=new Cateringaddress;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formaddress',
				  array('model'=>$cateringaddress), true)
				));
            Yii::app()->end();
        }
	}

	public function actionCreatecontact()
	{
		parent::actionCreate();
		$this->lookupdata();

		$cateringcontact=new Cateringcontact;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formcontact',
				  array('model'=>$cateringcontact), true)
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
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
			  'cateringaddress'=>$this->cateringaddress,
			  'cateringcontact'=>$this->cateringcontact), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

	public function actionUpdateaddress()
	{
	  $id=$_POST['id'];
	  $cateringaddress=$this->loadModeladdress($id[0]);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addressid'=>$cateringaddress->addressid,
			'addressbookid'=>$cateringaddress->addressbookid,
			'fullname'=>$cateringaddress->addressbook->fullname,
			'addresstypeid'=>$cateringaddress->addresstypeid,
			'addresstypename'=>$cateringaddress->addresstype->addresstypename,
			'addressname'=>$cateringaddress->addressname,
			'rt'=>$cateringaddress->rt,
			'rw'=>$cateringaddress->rw,
			'cityid'=>$cateringaddress->cityid,
			'cityname'=>$cateringaddress->city->cityname,
			'kelurahanid'=>$cateringaddress->kelurahanid,
			'kelurahanname'=>$cateringaddress->kelurahan->kelurahanname,
			'subdistrictid'=>$cateringaddress->subdistrictid,
			'subdistrictname'=>$cateringaddress->subdistrict->subdistrictname,
			  'div'=>$this->renderPartial('_formaddress', array('model'=>$cateringaddress), true)
			  ));
		  Yii::app()->end();
	  }
	}

	public function actionUpdatecontact()
	{
	  $id=$_POST['id'];
	  $cateringcontact=$this->loadModelcontact($id[0]);

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'addresscontactid'=>$cateringcontact->addresscontactid,
			'addressbookid'=>$cateringcontact->addressbookid,
			'fullname'=>$cateringcontact->addressbook->fullname,
			'contacttypeid'=>$cateringcontact->contacttypeid,
			'contacttypename'=>$cateringcontact->contacttype->contacttypename,
			'addresscontactname'=>$cateringcontact->addresscontactname,
			  'div'=>$this->renderPartial('_formcontact', array('model'=>$cateringcontact), true)
			  ));
		  Yii::app()->end();
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Catering'], $_POST['Catering']['addressbookid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Catering']))
	  {
		$dataku->attributes=$_POST['Catering'];
		if ((int)$dataku->attributes['addressbookid'] > 0)
		{
		  $model=$this->loadModel($dataku->attributes['addressbookid']);
		  $model->fullname = $dataku->attributes['fullname'];
		  $model->recordstatus = $dataku->attributes['recordstatus'];
		}
		else
		{
		  $model = new Catering();
		  $model->iscatering = 1;
		  $model->attributes=$_POST['Catering'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Catering']['addressbookid']);
              $this->GetSMessage('scoinsertsuccess');
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

	public function actionWriteaddress()
	{
		parent::actionWrite();
	  if(isset($_POST['Cateringaddress']))
	  {
		$dataku->attributes=$_POST['Cateringaddress'];
		if ((int)$dataku->attributes['addressid'] > 0)
		{
		  $model=Cateringaddress::model()->findbyPK($dataku->attributes['addressid']);
		  $model->addressbookid = $dataku->attributes['addressbookid'];
		  $model->addresstypeid = $dataku->attributes['addresstypeid'];
		  $model->addressname = $dataku->attributes['addressname'];
		  $model->rt = $dataku->attributes['rt'];
		  $model->rw = $dataku->attributes['rw'];
		  $model->cityid = $dataku->attributes['cityid'];
		  $model->kelurahanid = $dataku->attributes['kelurahanid'];
		  $model->subdistrictid = $dataku->attributes['subdistrictid'];
		}
		else
		{
		  $model = new Cateringaddress();
		  $model->attributes=$_POST['Cateringaddress'];
		}
		try
          {
            if($model->save())
            {
              $this->GetSMessage('scoinsertsuccess');
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

	public function actionWritecontact()
	{
		parent::actionWrite();
	  if(isset($_POST['Cateringcontact']))
	  {
		$dataku->attributes=$_POST['Cateringcontact'];
		if ((int)$dataku->attributes['addresscontactid'] > 0)
		{
		  $model=Cateringcontact::model()->findbyPK($dataku->attributes['addresscontactid']);
		  $model->addressbookid = $dataku->attributes['addressbookid'];
		  $model->contacttypeid = $dataku->attributes['contacttypeid'];
		  $model->addresscontactname = $dataku->attributes['addresscontactname'];
		}
		else
		{
		  $model = new Cateringcontact();
		  $model->attributes=$_POST['Cateringcontact'];
		}
		try
          {
            if($model->save())
            {
              $this->GetSMessage('scoinsertsuccess');
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

	public function actionDeleteaddress()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Cateringaddress::model()->findbyPK($ids);
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
		  $model=Cateringcontact::model()->findbyPK($ids);
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
	  $model=new Catering('searchwstatus');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Catering']))
		  $model->attributes=$_GET['Catering'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
		  'cateringaddress'=>$this->cateringaddress,
		  'cateringcontact'=>$this->cateringcontact
	  ));
	}

	public function actionIndexaddress()
	{
		$this->lookupdata();
	  $this->renderPartial('indexaddress',
		array('cateringaddress'=>$this->cateringaddress));
	  Yii::app()->end();
	}

	public function actionIndexcontact()
	{
		$this->lookupdata();
	  $this->renderPartial('indexcontact',
		array('cateringcontact'=>$this->cateringcontact));
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
			  $model=Catering::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Catering();
			  }
			  $model->addressbookid = (int)$data[0];
			  $model->fullname = $data[1];
			  $model->iscatering = 1;
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
	  $pdf->title='Catering List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $header = array('No','ID','Catering Name');
	  $dataprovider=Catering::model()->searchwstatus();
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
	  $pdf->Output('catering.pdf','D');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Catering::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeladdress($id)
	{
		$model=Cateringaddress::model()->findByPk((int)$id);
		//if($model===null)
		//	throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelcontact($id)
	{
		$model=Cateringcontact::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='Catering-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

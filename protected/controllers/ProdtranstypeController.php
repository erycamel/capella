<?php

class ProdtranstypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  $snro=new Snro('searchwstatus');
	  $snro->unsetAttributes();  // clear any default values
	  if(isset($_GET['Snro']))
		$snro->attributes=$_GET['Snro'];
		$model=new Prodtranstype;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure',
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'snro'=>$snro), true)
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
	  $snro=new Snro('searchwstatus');
	  $snro->unsetAttributes();  // clear any default values
	  if(isset($_GET['Snro']))
		$snro->attributes=$_GET['Snro'];

		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'prodtranstypeid'=>$model->prodtranstypeid,
				'prodtranscode'=>$model->prodtranscode,
				'description'=>$model->description,
				'modulename'=>$model->modulename,
				'snroid'=>$model->snroid,
				'snrodesc'=>$model->snro->description,
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'snro'=>$snro), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Prodtranstype'], $_POST['Prodtranstype']['prodtranstypeid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Prodtranstype']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Prodtranstype']['prodtransname'],'iptemptyprodtransname','emptystring'),
            array($_POST['Prodtranstype']['description'],'iptemptydescription','emptystring'),
            array($_POST['Prodtranstype']['snroid'],'iptemptysnroid','emptystring'),
            )
        );
        if ($messages == '') {
		if ((int)$_POST['Prodtranstype']['prodtranstypeid'] > 0)
		{
		  $model=$this->loadModel($_POST['Prodtranstype']['prodtranstypeid']);
		  $model->prodtransname = $_POST['Prodtranstype']['prodtransname'];
		  $model->description = $_POST['Prodtranstype']['description'];
		  $model->snroid = $_POST['Prodtranstype']['snroid'];
		  $model->recordstatus = $_POST['Prodtranstype']['recordstatus'];
		}
		else
		{
		  $model = new Prodtranstype();
		  $model->attributes=$_POST['Prodtranstype'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Prodtranstype']['prodtranstypeid']);
              $this->GetSMessage('iptinsertsuccess');
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  $snro=new Snro('searchwstatus');
	  $snro->unsetAttributes();  // clear any default values
	  if(isset($_GET['Snro']))
		$snro->attributes=$_GET['Snro'];

		$model=new Prodtranstype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Prodtranstype']))
			$model->attributes=$_GET['Prodtranstype'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
				  'snro'=>$snro
		));
	}

	public function actionDownload()
  {
	Yii::import('application.extensions.fpdf.*');
    require_once("pdf.php");
    $pdf = new PDF();
    $pdf->title='Absence Rule List';
    $pdf->AddPage('P');
    $pdf->setFont('Arial','B',12);

    // definisi font
    $pdf->setFont('Arial','B',8);

    // menuliskan tabel
    $header = array('No','ID','Schedule Name','Time In','Time Out');
    $model=new Absrule('searchwstatus');
    $dataprovider=$model->searchwstatus();
    $dataprovider->pagination=false;
    $data = $dataprovider->getData();
    //var_dump($dataku);
    $w= array(20,25,30,30,30);

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
        $pdf->Cell($w[1],6,$datas['absruleid'],'LR',0,'C',$fill);
        $pdf->Cell($w[2],6,Absschedule::model()->findByPk($datas['absscheduleid'])->absschedulename,'LR',0,'L',$fill);
        $pdf->Cell($w[3],6,$datas['difftimein'],'LR',0,'C',$fill);
        $pdf->Cell($w[4],6,$datas['difftimeout'],'LR',0,'C',$fill);
        $pdf->Ln();
        $fill=!$fill;
    }
    $pdf->Cell(array_sum($w),0,'','T');


    // me-render ke browser
    $pdf->Output('absencerule.pdf','D');
  }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Prodtranstype::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='prodtranstype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

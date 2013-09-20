<?php

class AbstransController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	protected $menuname = 'abstrans';

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
	  $model=new Abstrans;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>$this->renderPartial('_form', array('model'=>$model), true)
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

	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'abstransid'=>$model->abstransid,
			  'shortstat'=>$model->shortstat,
			  'longstat'=>$model->longstat,
			  'isin'=>$model->isin,
			  'priority'=>$model->priority,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model), true)
			  ));
		  Yii::app()->end();
	  }
	}

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Abstrans']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Abstrans']['shortstat'],'hrtasemptyshortstat','emptystring'),
                array($_POST['Abstrans']['longstat'],'hrtasemptylongstat','emptystring'),
                array($_POST['Abstrans']['priority'],'hrtasemptypriority','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Abstrans'];
		if ((int)$_POST['Abstrans']['abstransid'] > 0)
		{
		  $model=$this->loadModel($_POST['Abstrans']['abstransid']);
		  $model->shortstat = $_POST['Abstrans']['shortstat'];
		  $model->longstat = $_POST['Abstrans']['longstat'];
		  $model->isin = $_POST['Abstrans']['isin'];
		  $model->priority = $_POST['Abstrans']['priority'];
		  $model->recordstatus = $_POST['Abstrans']['recordstatus'];
		}
		else
		{
		  $model = new Abstrans();
		  $model->attributes=$_POST['Abstrans'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname,$_POST['Abstrans']['abstransid']);
              $this->GetSMessage('hrtasinsertsuccess');
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
	  $model=new Abstrans('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Abstrans']))
	  	$model->attributes=$_GET['Abstrans'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
			'model'=>$model,
	  ));
	}

	public function actionUpload()
	{
      parent::actionUpload();
	   $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploadfile']['name']); 
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
			echo "success";
			$row=1;			
			if (($handle = fopen($file, "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if ($row>1) {
			  $model = new Abstrans();
              $empid = Employee::model()->findbyattributes(array('oldnik'=>$data[0]));
			  if ($empid !== null)
			  {
				$model->employeeid = $empid->employeeid;
			  }
			  $model->datetimeclock = date("Y-m-d H:i:s",strtotime($data[2]));
			  try
					  {
						if(!$model->save())
						{
						  echo $model->getErrors();
						}
						else {
						 $a = Yii::app()->user->name;
						$connection=Yii::app()->db;
				
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
			$sql = 'call ApproveAbstrans()';
            $command=$connection->createCommand($sql);
            $command->execute();
		} else {
			echo Yii::t('app','directory permission');
		}	
  }

  public function actionDownload()
  {
    parent::actionDownload();
    $pdf = new PDF();
	  $pdf->title='Absence Transaction List';
	  $pdf->AddPage('P');
	  $pdf->setFont('Arial','B',12);

	  // definisi font
	  $pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select b.fullname, a.date_in, a.date_out, a.time_in, a.time_out
      from abstrans a
      inner join employee b on b.employeeid = a.employeeid ";
if ($_GET['id'] !== '') {
				$sql = $sql . "where a.abstransid = ".$_GET['id'];
		}
      $sql = $sql. " order by a.employeeid";

    $command=$connection->createCommand($sql);
    $dataReader=$command->queryAll();

    $pdf->setaligns(array('C','C','C','C','C'));
    $pdf->setwidths(array(50,30,30,30,30));
    $pdf->Row(array('Employee','Date In','Date Out','Time In','Time Out'));
    $pdf->setaligns(array('L','L','L','L','L'));
    foreach($dataReader as $row1)
    {
      $pdf->row(array($row1['fullname'],
          date(Yii::app()->params["dateviewfromdb"], strtotime($row1['date_in'])),
          date(Yii::app()->params["dateviewfromdb"], strtotime($row1['date_out'])),
          $row1['time_in'],
          $row1['time_out']));
    }
    // me-render ke browser
    $pdf->Output();
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Abstrans::model()->findByPk((int)$id);
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
	  if(isset($_POST['ajax']) && $_POST['ajax']==='abstrans-form')
	  {
		  echo CActiveForm::validate($model);
		  Yii::app()->end();
	  }
	}
}

<?php

class JobsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'jobs';
public $orgstructure,$position;

public function lookupdata()
	{
	  $this->orgstructure=new Orgstructure('searchwstatus');
	  $this->orgstructure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Orgstructure']))
		$this->orgstructure->attributes=$_GET['Orgstructure'];
	  $this->position=new Position('searchwstatus');
	  $this->position->unsetAttributes();  // clear any default values
	  if(isset($_GET['Position']))
		$this->position->attributes=$_GET['Position'];
	}

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
      $this->lookupdata();
	  $model=new Jobs;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'orgstructure'=>$this->orgstructure,
                  'position'=>$this->position), true)
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
			  'jobsid'=>$model->jobsid,
			  'orgstructureid'=>$model->orgstructureid,
              'structurename'=>($model->orgstructure!==null)?$model->orgstructure->structurename:"",
			  'positionid'=>$model->positionid,
              'positionname'=>($model->position!==null)?$model->position->positionname:"",
			  'jobdesc'=>$model->jobdesc,
			  'qualification'=>$model->qualification,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'orgstructure'=>$this->orgstructure,
                  'position'=>$this->position), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Jobs'], $_POST['Jobs']['jobsid']);
    }

	public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Jobs']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Jobs']['orgstructureid'],'homjoemptyorgstructure','emptystring'),
                array($_POST['Jobs']['jobdesc'],'homjoemptyjobdesc','emptystring'),
                array($_POST['Jobs']['qualification'],'homjoemptyqualification','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Absstatus'];
		if ((int)$_POST['Jobs']['jobsid'] > 0)
		{
		  $model=$this->loadModel($_POST['Jobs']['jobsid']);
		  $model->orgstructureid = $_POST['Jobs']['orgstructureid'];
		  $model->positionid = $_POST['Jobs']['positionid'];
		  $model->jobdesc = $_POST['Jobs']['jobdesc'];
		  $model->qualification = $_POST['Jobs']['qualification'];
		  $model->recordstatus = $_POST['Jobs']['recordstatus'];
		}
		else
		{
		  $model = new Jobs();
		  $model->attributes=$_POST['Jobs'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Jobs']['jobsid']);
              $this->GetSMessage('homjoinsertsuccess');
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
	  $model=new Jobs('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Jobs']))
	  	$model->attributes=$_GET['Jobs'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
			'model'=>$model,
                  'orgstructure'=>$this->orgstructure,
                  'position'=>$this->position
	  ));
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
						$model=Jobs::model()->findByPk((int)$data[0]);
						if ($model=== null) {
							$model = new Jobs();
						}
						$model->jobsid = (int)$data[0];
						$org = Orgstructure::model()->findbyattributes(array('structurename'=>$data[1]));
						if ($org !== null)
						{
							$model->orgstructureid = $org->orgstructureid;
						}
						$position = Position::model()->findbyattributes(array('positionname'=>$data[2]));
						if ($position !== null)
						{
							$model->positionid = $org->positionid;
						}
						$model->jobdesc = $data[3];
						$model->qualification = $data[4];
						$model->recordstatus = $data[5];
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
		$sql = "select b.structurename, c.positionname, a.jobdesc,a.qualification
				from jobs a 
				left join orgstructure b on b.orgstructureid = a.orgstructureid
				left join position c on c.positionid = a.positionid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.jobsid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		
		$this->pdf->title='Job Description List';
		$this->pdf->AddPage('P');
		$this->pdf->setFont('Arial','B',12);

		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->setaligns(array('C','C','C','C'));
		$this->pdf->setwidths(array(40,40,40,40));
		$this->pdf->Row(array('Structure','Position','Job Description','Qualification'));
		$this->pdf->setaligns(array('L','L','L','L'));
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['structurename'],$row1['positionname'],$row1['jobdesc'],$row1['qualification']));
		}
		$this->pdf->Output();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Jobs::model()->findByPk((int)$id);
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
	  if(isset($_POST['ajax']) && $_POST['ajax']==='absstatus-form')
	  {
		  echo CActiveForm::validate($model);
		  Yii::app()->end();
	  }
	}
}

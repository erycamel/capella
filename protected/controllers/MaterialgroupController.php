<?php

class MaterialgroupController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'materialgroup';

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
	  $parentmatgroup=new Materialgroup('searchwstatus');
	  $parentmatgroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Parentmatgroup']))
		$parentmatgroup->attributes=$_GET['Parentmatgroup'];

      	  $materialtype=new Materialtype('searchwstatus');
	  $materialtype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialtype']))
		$materialtype->attributes=$_GET['Materialtype'];

		$model=new Materialgroup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'parentmatgroup'=>$parentmatgroup,
                    'materialtype'=>$materialtype), true)
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
	   $parentmatgroup=new Materialgroup('searchwstatus');
	  $parentmatgroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Parentmatgroup']))
		$parentmatgroup->attributes=$_GET['Parentmatgroup'];

      $materialtype=new Materialtype('searchwstatus');
	  $materialtype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialtype']))
		$materialtype->attributes=$_GET['Materialtype'];
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'materialgroupid'=>$model->materialgroupid,
				'materialgroupcode'=>$model->materialgroupcode,
				'description'=>$model->description,
				'parentmatgroupid'=>$model->parentmatgroupid,
				'parentmatgroupcode'=>($model->parentmatgroup!==null)?$model->parentmatgroup->materialgroupcode:"",
				'materialtypeid'=>$model->materialtypeid,
				'materialtypename'=>($model->materialtype!==null)?$model->materialtype->description:"",
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'parentmatgroup'=>$parentmatgroup,
                    'materialtype'=>$materialtype), true)
				));
            Yii::app()->end();
        }
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Materialgroup'], $_POST['Materialgroup']['materialgroupid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Materialgroup']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Materialgroup']['materialgroupcode'],'pmmgemptymaterialgroupcode','emptystring'),
                array($_POST['Materialgroup']['description'],'pmmgemptydescription','emptystring'),
                array($_POST['Materialgroup']['materialtypeid'],'pmmgemptymaterialtype','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Materialgroup'];
		if ((int)$_POST['Materialgroup']['materialgroupid'] > 0)
		{
		  $model=$this->loadModel($_POST['Materialgroup']['materialgroupid']);
		  $model->materialgroupcode = $_POST['Materialgroup']['materialgroupcode'];
		  $model->description = $_POST['Materialgroup']['description'];
		  $model->materialtypeid=$_POST['Materialgroup']['materialtypeid'];
		  $model->parentmatgroupid=$_POST['Materialgroup']['parentmatgroupid'];
		  $model->recordstatus = $_POST['Materialgroup']['recordstatus'];
		}
		else
		{
		  $model = new Materialgroup();
		  $model->attributes=$_POST['Materialgroup'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Materialgroup']['materialgroupid']);
              $this->GetSMessage('pmmginsertsuccess');
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
	   $parentmatgroup=new Materialgroup('searchwstatus');
	  $parentmatgroup->unsetAttributes();  // clear any default values
	  if(isset($_GET['Parentmatgroup']))
		$parentmatgroup->attributes=$_GET['Parentmatgroup'];
      $materialtype=new Materialtype('searchwstatus');
	  $materialtype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Materialtype']))
		$materialtype->attributes=$_GET['Materialtype'];
		$model=new Materialgroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Materialgroup']))
			$model->attributes=$_GET['Materialgroup'];
if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
		$this->render('index',array(
			'model'=>$model,
				  'parentmatgroup'=>$parentmatgroup,
            'materialtype'=>$materialtype
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
			  $model=Materialgroup::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Materialgroup();
			  }
			  $model->materialgroupid = (int)$data[0];
			  $model->materialgroupcode = $data[1];
			  $model->description = $data[2];
			  $model->parentmatgroupid = (int)$data[3];
			  $model->recordstatus = (int)$data[4];
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
  
  public function coa($connection,$pdf,$accountid)
	{
		$sql = "select distinct a.materialgroupcode,a.description, c.materialtypecode,a.materialgroupid
				from materialgroup a
left join materialtype c on c.materialtypeid = a.materialtypeid
				where a.parentmatgroupid = ".$accountid;
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		foreach($dataReader as $row)
		{
			$this->pdf->row(array($row['materialgroupcode'],$row['materialtypecode'],
				'    '.$row['description']));
			
			$sql1 = "select count(1)
						from materialgroup a
						where a.parentmatgroupid = ".$row['materialgroupid'];
				$command1=$this->connection->createCommand($sql1);
				$value=$command1->queryscalar();
				if ($value > 0) 
				{
					$this->coa($this->connection,$this->pdf,$row['materialgroupid']);
				}
		}
  }

	public function actionDownload()
  {
	parent::actionDownload();
    $sql = "select distinct a.materialgroupcode,a.description, c.materialtypecode,a.materialgroupid
				from materialgroup a
inner join materialgroup b on b.parentmatgroupid = a.materialgroupid
left join materialtype c on c.materialtypeid = a.materialtypeid	";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.materialgroupid = ".$_GET['id'];
		}
		$sql = $sql . "  order by a.materialgroupcode ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
    $this->pdf->title='Material Group List';
    $this->pdf->AddPage('P');
    // definisi font
    $this->pdf->setFont('Arial','B',8);

    $this->pdf->colalign = array('C','C','C','C');
    $this->pdf->setwidths(array(30,30,100));
	$this->pdf->colheader = array('Code','Material Type','Description');
    $this->pdf->RowHeader();
    $this->pdf->coldetailalign = array('L','L','L','L');
    foreach($dataReader as $row1)
    {
      $this->pdf->row(array($row1['materialgroupcode'],$row1['materialtypecode'],
          $row1['description']));
$this->coa($this->connection,$this->pdf,$row1['materialgroupid']);
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
		$model=Materialgroup::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='materialgroup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

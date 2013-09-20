<?php

class CatalogsysController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'catalogsys';

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

    public $language;

	public function lookupdata()
	{
	  $this->language=new Language('searchwstatus');
	  $this->language->unsetAttributes();  // clear any default values
	  if(isset($_GET['Language']))
		$this->language->attributes=$_GET['Language'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
      $this->lookupdata();
      $model=new Catalogsys;

      if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'language'=>$this->language), true)
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
              'languageid'=>$model->languageid,
              'languagename'=>($model->language!==null)?$model->language->languagename:"",
			  'catalogsysid'=>$model->catalogsysid,
			  'catalogname'=>$model->catalogname,
			  'catalogval'=>$model->catalogval,
          'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
                  'language'=>$this->language), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Catalogsys'], $_POST['Catalogsys']['catalogsysid']);
    }


    public function actionWrite()
	{
		parent::actionWrite();
	  if(isset($_POST['Catalogsys']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Catalogsys']['languageid'],'emptylanguage','emptystring'),
                array($_POST['Catalogsys']['catalogname'],'emptycatalogname','emptystring'),
                array($_POST['Catalogsys']['catalogval'],'emptycatalogval','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Absstatus'];
		if ((int)$_POST['Catalogsys']['catalogsysid'] > 0)
		{
		  $model=$this->loadModel($_POST['Catalogsys']['catalogsysid']);
		  $model->languageid = $_POST['Catalogsys']['languageid'];
		  $model->catalogname = $_POST['Catalogsys']['catalogname'];
		  $model->catalogval = $_POST['Catalogsys']['catalogval'];
		  $model->recordstatus = $_POST['Catalogsys']['recordstatus'];
		}
		else
		{
		  $model = new Catalogsys();
		  $model->attributes=$_POST['Catalogsys'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Catalogsys']['catalogsysid']);
              $this->GetSMessage('sctinsertsuccess');
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
	
	public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select languagename,catalogname,catalogval
				from catalogsys a
left join language b on b.languageid = a.languageid				";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.catalogsysid = ".$_GET['id'];
		}
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Catalog Translation List';
		$this->pdf->AddPage('P');
		// definisi font
		$this->pdf->setFont('Arial','B',8);

		$this->pdf->colalign = array('C','C','C');
		$this->pdf->setwidths(array(50,60,60));
		$this->pdf->colheader = array('Language Name','Catalog Name','Catalog Val');
		$this->pdf->RowHeader();
		$this->pdf->coldetailalign = array('L','L','L');
		$this->pdf->setFont('Arial','',8);
		foreach($dataReader as $row1)
		{
		  $this->pdf->row(array($row1['languagename'],$row1['catalogname'],$row1['catalogval']));
		}
		// me-render ke browser
		$this->pdf->Output();
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
		$model=new Catalogsys('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Catalogsys']))
			$model->attributes=$_GET['Catalogsys'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
            'language'=>$this->language
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Catalogsys::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalogsys-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

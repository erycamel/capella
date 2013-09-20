<?php

class GenjournalController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'genjournal';

	public function actionHelp()
	{
		$txt = '';
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $txt = '_help'; break;
				case 2 : $txt = '_helpmodif'; break;
				case 3 : $txt = '_helpdetail'; break;
				case 4 : $txt = '_helpdetailmodif'; break;
			}
		}
		parent::actionHelp($txt);
	}
	
	public $journaldetail;
	

	public function lookupdata()
	{
	  $this->journaldetail=new Journaldetail('search');
	  $this->journaldetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Journaldetail']))
		$this->journaldetail->attributes=$_GET['Journaldetail'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	  parent::actionCreate();
	  $this->lookupdata();
	  $model=new Genjournal;
	  $model->journaldate=new CDbExpression('NOW()');
	  $model->postdate=new CDbExpression('NOW()');
	  $model->recordstatus=Wfgroup::model()->findstatusbyuser('insgenjournal');
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  if ($model->save()) {
			echo CJSON::encode(array(
				'status'=>'success',
				'genjournalid'=>$model->genjournalid,
				'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'journaldetail'=>$this->journaldetail), true)
				));
			Yii::app()->end();
		  }
	  }
	}

	public function actionCreatedetail()
	{
	  $journaldetail=new Journaldetail;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'currencyid'=>Company::model()->getcurrencyid(),
			  'currencyname'=>Company::model()->getcurrencyname(),
			  'divcreate'=>$this->renderPartial('_formdetail',
				array('model'=>$journaldetail), true)
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
				'genjournalid'=>$model->genjournalid,
				'referenceno'=>$model->referenceno,
				'journaldate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->journaldate)),
				'journalnote'=>$model->journalnote,
				'postdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->postdate)),
				'recordstatus'=>$model->recordstatus,
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'journaldetail'=>$this->journaldetail), true)
				));
            Yii::app()->end();
        }
        }
	}

	public function actionUpdatedetail()
	{
		$id=$_POST['id'];
	  $journaldetail=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'journaldetailid'=>$journaldetail->journaldetailid,
				'accountid'=>$journaldetail->accountid,
				'accountcode'=>($journaldetail->account!==null)?$journaldetail->account->accountcode:"",
				'accountname'=>($journaldetail->account!==null)?$journaldetail->account->accountname:"",
				'debit'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$journaldetail->debit),
				'credit'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$journaldetail->credit),
				'currencyid'=>$journaldetail->currencyid,
				'currencyname'=>($journaldetail->currency!==null)?$journaldetail->currency->currencyname:"",
				'detailnote'=>$journaldetail->detailnote,
				'ratevalue'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$journaldetail->ratevalue),
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$journaldetail), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Genjournal'], $_POST['Genjournal']['genjournalid']);
    }

	public function actionWrite()
	{
	  parent::actionWrite();
	  if(isset($_POST['Genjournal']))
	  {
        $messages = $this->ValidateData(
                array(
                array($_POST['Genjournal']['journaldate'],'emptydate','emptystring'),
                array($_POST['Genjournal']['postdate'],'emptypostdate','emptystring'),
                array($_POST['Genjournal']['journalnote'],'emptyjournalnote','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Genjournal'];
		if ((int)$_POST['Genjournal']['genjournalid'] > 0)
		{
		  $model=$this->loadModel($_POST['Genjournal']['genjournalid']);
		  $model->journaldate = $_POST['Genjournal']['journaldate'];
		  $model->journalnote = $_POST['Genjournal']['journalnote'];
		  $model->postdate = $_POST['Genjournal']['postdate'];
		}
		else
		{
		  $model = new Genjournal();
		  $model->attributes=$_POST['Genjournal'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Genjournal']['genjournalid']);
              $this->GetSMessage('agjinsertsuccess');
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

	public function actionWritedetail()
	{
	  if(isset($_POST['Journaldetail']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Journaldetail']['accountid'],'emptyaccount','emptystring'),
                array($_POST['Journaldetail']['debit'],'emptydebit','emptystring'),
                array($_POST['Journaldetail']['credit'],'emptycredit','emptystring'),
                array($_POST['Journaldetail']['currencyid'],'emptycurrency','emptystring'),
                array($_POST['Journaldetail']['ratevalue'],'emptyrate','emptystring'),
            )
        );
        if ($messages == '') {
          //$dataku->attributes=$_POST['Journaldetail'];
          if ((int)$_POST['Journaldetail']['journaldetailid'] > 0)
          {
            $model=Journaldetail::model()->findbyPK($_POST['Journaldetail']['journaldetailid']);
            $model->genjournalid = $_POST['Journaldetail']['genjournalid'];
            $model->accountid = $_POST['Journaldetail']['accountid'];
            $model->debit = $_POST['Journaldetail']['debit'];
            $model->credit = $_POST['Journaldetail']['credit'];
            $model->currencyid = $_POST['Journaldetail']['currencyid'];
            $model->detailnote = $_POST['Journaldetail']['detailnote'];
            $model->ratevalue = $_POST['Journaldetail']['ratevalue'];
		$model->debit = str_replace(",","",$model->debit);
		$model->credit = str_replace(",","",$model->credit);
		$model->ratevalue = str_replace(",","",$model->ratevalue);
          }
          else
          {
            $model = new Journaldetail();
            $model->attributes=$_POST['Journaldetail'];
		$model->debit = str_replace(",","",$model->debit);
		$model->credit = str_replace(",","",$model->credit);
		$model->ratevalue = str_replace(",","",$model->ratevalue);
          }
          try
          {
            if($model->save())
            {
              $this->GetSMessage('agjinsertsuccess');
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
        //$model=$this->loadModel($ids);
        $a = Yii::app()->user->name;
        $connection=Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try
        {
          $sql = 'call RejectJournal(:vid, :vlastupdateby)';
          $command=$connection->createCommand($sql);
          $command->bindValue(':vid',$ids,PDO::PARAM_INT);
          $command->bindValue(':vlastupdateby', $a,PDO::PARAM_STR);
          $command->execute();
          $transaction->commit();
          $this->GetSMessage('agjinsertsuccess');
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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletedetail()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Journaldetail::model()->findbyPK($ids);
		  $model->delete();
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
        //$model=$this->loadModel($ids);
        $a = Yii::app()->user->name;
        $connection=Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try
        {
          $sql = 'call ApproveJournal(:vid, :vlastupdateby)';
          $command=$connection->createCommand($sql);
          $command->bindValue(':vid',$ids,PDO::PARAM_INT);
          $command->bindValue(':vlastupdateby', $a,PDO::PARAM_STR);
          $command->execute();
          $transaction->commit();
          $this->GetSMessage('agjinsertsuccess');
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
		$model=new Genjournal('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Genjournal']))
			$model->attributes=$_GET['Genjournal'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
			'journaldetail'=>$this->journaldetail
		));
	}

	public function actionIndexdetail()
	{
	  $this->lookupdata();
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->renderPartial('indexdetail',
		array('journaldetail'=>$this->journaldetail));
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
    $oldid = 0;
    $row = 0;
	  if (($handle = fopen($folder.$uploader->file->getName(), "r")) !== FALSE) {
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row>0) {
        if ($data[0] != '')
        {
          $model = new Genjournal();
          $model->journaldate = $data[0];
          $model->postdate = $data[0];
          $model->referenceno = $data[1];
          $model->recordstatus = Wfgroup::model()->findstatusbyuser('insgenjournal');
          $model->save();
          $oldid = $model->genjournalid;
        }
        if ($oldid != 0)
        {
        $detail = new Journaldetail();
        $detail->genjournalid = $oldid;
        $account = Account::model()->findbysql("select accountid from account where upper(accountcode) = '".$data[2]."'");
        if ($account != null)
        {
          $detail->accountid = $account->accountid;
        }
        if ($data[3] != '') 
        {
          $detail->debit = $data[3];
          $detail->credit = 0;
        }
        if ($data[4] != '')
        {
          $detail->debit = 0;
          $detail->credit = $data[4];
        }
        $currency = Currency::model()->findbysql("select currencyid from currency where upper(currencyname) = '".$data[5]."'");
        if ($currency != null)
        {
          $detail->currencyid = $currency->currencyid;
        }
        $detail->detailnote = $data[1];
        if(!$detail->save())
        {
          $errormessage=$data[0].' - '.$data[1].' - '.$detail->getErrors();
          if (Yii::app()->request->isAjaxRequest)
          {
            echo CJSON::encode(array(
              'status'=>'failure',
              'div'=>$errormessage
            ));
          }
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
	  $this->pdf->title='General Journal';
	  $this->pdf->AddPage('P');
	  $this->pdf->iscustomborder = false;
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

	  // menuliskan tabel
	  $connection=Yii::app()->db;
    $sql = "select a.referenceno,a.journalnote,a.journaldate,a.genjournalid,a.journalno,a.recordstatus
      from genjournal a ";
	  if ($_GET['id'] !== '') {
				$sql = $sql . "where a.genjournalid = ".$_GET['id'];
		}
    $command=$connection->createCommand($sql);
    $dataReader=$command->queryAll();

    foreach($dataReader as $row)
    {
		if ($this->checkprint($this->menuname,'prigenjournal',$row['recordstatus']))
		{
      $this->pdf->setFont('Arial','B',10);
	  $this->pdf->Rect(10,60,190,25);
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['journalno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Ref No ');$this->pdf->text(50,$this->pdf->gety()+10,': '.$row['referenceno']);
      $this->pdf->text(15,$this->pdf->gety()+15,'Date ');$this->pdf->text(50,$this->pdf->gety()+15,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['journaldate'])));
      $this->pdf->text(15,$this->pdf->gety()+20,'Note ');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['journalnote']);

      $sql1 = "select b.accountcode,b.accountname, a.debit,a.credit,c.symbol,a.detailnote,a.ratevalue
        from journaldetail a
        left join account b on b.accountid = a.accountid
        left join currency c on c.currencyid = a.currencyid
        where genjournalid = ".$row['genjournalid'];
      $command1=$connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

	  $this->pdf->SetY($this->pdf->gety()+25);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(10,60,25,25,20,50));
	  $this->pdf->colheader = array('No','Account','Debit','Credit','Rate','Detail Note');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',7);
      $this->pdf->coldetailalign = array('L','L','R','R','R','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['accountcode'].' '.$row1['accountname'],
            Yii::app()->numberFormatter->formatCurrency($row1['debit'],$row1['symbol']),
            Yii::app()->numberFormatter->formatCurrency($row1['credit'],$row1['symbol']),
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row1['ratevalue']),
            $row1['detailnote']));
      }
      
      $this->pdf->setFont('Arial','',8);
      $this->pdf->text(170,$this->pdf->gety()+15,'Jakarta, '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['journaldate'])));
      $this->pdf->text(10,$this->pdf->gety()+20,'Approved By');$this->pdf->text(170,$this->pdf->gety()+20,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+40,'------------ ');$this->pdf->text(170,$this->pdf->gety()+40,'------------');

      $this->pdf->CheckNewPage(10);
      }
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
		$model=Genjournal::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Journaldetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='genjournal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='journaldetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

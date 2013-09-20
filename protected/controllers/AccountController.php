<?php

class AccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
 protected $menuname = 'account';
	public $parentaccount,$currency,$accounttype;
	
	public function lookupdata()
	{
	  $this->parentaccount=new Account('searchwstatus');
	  $this->parentaccount->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$this->parentaccount->attributes=$_GET['Account'];

	  $this->currency=new Currency('searchwstatus');
	  $this->currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$this->currency->attributes=$_GET['Currency'];

      $this->accounttype=new Accounttype('searchwstatus');
	  $this->accounttype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Accounttype']))
		$this->accounttype->attributes=$_GET['Accounttype'];
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
	  $model=new Account;
	  if (Yii::app()->request->isAjaxRequest)
	  {
		  echo CJSON::encode(array(
			  'status'=>'success',
			  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				'parentaccount'=>$this->parentaccount,
				'currency'=>$this->currency,
                  'accounttype'=>$this->accounttype), true)
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
			  'accountid'=>$model->accountid,
			  'accountname'=>$model->accountname,
			  'accountcode'=>$model->accountcode,
			  'parentaccountid'=>$model->parentaccountid,
			  'parentaccountname'=>($model->parentaccount!==null)?$model->parentaccount->accountcode:"",
			  'accounttypeid'=>$model->accounttypeid,
			  'accounttypename'=>($model->accounttype!==null)?$model->accounttype->accounttypename:"",
			  'currencyid'=>$model->currencyid,
			  'currencyname'=>$model->currency->currencyname,
			  'recordstatus'=>$model->recordstatus,
			  'div'=>$this->renderPartial('_form', array('model'=>$model,
				'parentaccount'=>$this->parentaccount,
				'currency'=>$this->currency,
                  'accounttype'=>$this->accounttype), true)
			  ));
		  Yii::app()->end();
        }
	  }
	}

    public function actionCancelWrite()
    {
	  $this->DeleteLockCloseForm($this->menuname, $_POST['Account'], $_POST['Account']['accountid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Account']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Account']['accountname'],'emptyaccountname','emptystring'),
                array($_POST['Account']['accountcode'],'emptyaccountcode','emptystring'),
                array($_POST['Account']['currencyid'],'emptycurrency','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Account'];
		if ((int)$_POST['Account']['accountid'] > 0)
		{
		  $model=$this->loadModel($_POST['Account']['accountid']);
		  $model->accountname = $_POST['Account']['accountname'];
		  $model->accountcode = $_POST['Account']['accountcode'];
		  $model->parentaccountid = $_POST['Account']['parentaccountid'];
		  $model->currencyid = $_POST['Account']['currencyid'];
		  $model->accounttypeid = $_POST['Account']['accounttypeid'];
		  $model->recordstatus = $_POST['Account']['recordstatus'];
		}
		else
		{
		  $model = new Account();
		  $model->attributes=$_POST['Account'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname,$_POST['Account']['accountid']);
              $this->GetSMessage('aaccinsertsuccess');
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
	  $model=new Account('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
			$model->attributes=$_GET['Account'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		'model'=>$model,
				  'parentaccount'=>$this->parentaccount,
				  'currency'=>$this->currency,
                  'accounttype'=>$this->accounttype
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
			  $model=Account::model()->findByPk((int)$data[0]);
			  if ($model=== null) {
				$model = new Account();
			  }
			  $model->accountid = (int)$data[0];
			  $model->accountcode = $data[1];
			  $model->accountname = $data[2];
			  $parent = Account::model()->findbyattributes(array('accountcode'=>$data[3]));
			  if ($parent !== null) {
				$model->parentaccountid = $parent->accountid;
			  }
			  if ($data[4] != '') {
                $accounttype = Accounttype::model()->findbysql("select * from accounttype where upper(accounttypename) = upper('".$data[4]."')");
                if ($accounttype != null) {
                  $model->accounttypeid = $accounttype->accounttypeid;
                } else {
                  $model->accounttypeid = null;
                }
			  } else {
				$model->accounttypeid = null;
			  }
			  if ($data[5] != '') {
                $currency = Currency::model()->findbysql("select * from currency where upper(currencyname) = upper('".$data[5]."')");
                if ($currency != null) {
                  $model->currencyid = $currency->currencyid;
                } else {
                  $model->currencyid = null;
                }
			  } else {
				$model->currencyid = null;
			  }
			  $model->recordstatus = $data[6];
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
		$sql = "select distinct a.accountid, a.accountcode, a.accountname,d.symbol,c.accounttypename
				from account a
				left join accounttype c on c.accounttypeid = a.accounttypeid
				left join currency d on d.currencyid = a.currencyid
				where a.parentaccountid = ".$accountid." and accounttypename = 'Detail'
				order by cast(replace(a.accountcode,'.','') as decimal) ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();
		foreach($dataReader as $row)
		{
			$this->pdf->row(array($row['accountcode'],'       '.$row['accountname'],$row['accounttypename'],$row['symbol']));
		}
  }
  
  public function actionDownload()
	{
		parent::actionDownload();
		$sql = "select distinct a.accountid, a.accountcode, a.accountname,d.symbol,c.accounttypename
from account a
inner join account b on b.parentaccountid = a.accountid
left join accounttype c on c.accounttypeid = a.accounttypeid
left join currency d on d.currencyid = a.currencyid
where accounttypename = 'Header' ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "and a.accountid = ".$_GET['id'];
		}
		$sql = $sql . " order by a.accountcode ";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

		$this->pdf->title='Chart of Account List';
		$this->pdf->AddPage('P');
		//$this->pdf->sety($this->pdf->gety()+30);
		$this->pdf->setFont('Arial','B',8);
		$this->pdf->colalign = array('C','C','C','C','C'); 
		$this->pdf->colheader = array('Account Code','Account Name','Account Type','Currency');
		$this->pdf->setwidths(array(30,100,40,20));
		$this->pdf->rowheader();
		$this->pdf->coldetailalign=array('L','L','L','L','L');
		$this->pdf->setFont('Arial','',8);
		foreach($dataReader as $row)
		{
			$this->pdf->row(array($row['accountcode'],$row['accountname'],$row['accounttypename'],$row['symbol']));
			$this->coa($this->connection,$this->pdf,$row['accountid']);
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
		$model=Account::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

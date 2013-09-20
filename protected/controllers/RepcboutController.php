<?php

class RepcboutController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'repcbout';

	public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpservice'; break;
				case 4 : $this->txt = '_helpservicemodif'; break;
				case 5 : $this->txt = '_helppic'; break;
				case 6 : $this->txt = '_helppicmodif'; break;
				case 7 : $this->txt = '_helplocation'; break;
				case 8 : $this->txt = '_helplocationmodif'; break;
				case 9 : $this->txt = '_helpdocument'; break;
				case 10 : $this->txt = '_helpdocumentmodif'; break;
				case 11 : $this->txt = '_helpnetwork'; break;
				case 12 : $this->txt = '_helpnetworkmodif'; break;
			}
		}
		parent::actionHelp();
	}

	public $cashbankacc;

	public function lookupdata()
	{
		$this->cashbankacc=new Cashbankacc('search');
		$this->cashbankacc->unsetAttributes();  
		if(isset($_GET['Cashbankacc']))
		$this->cashbankacc->attributes=$_GET['Cashbankacc'];
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		parent::actionCreate();
	  $this->lookupdata();
		$model=new Cashbank;
		$model->cashbanktypeid = 2;
		$model->recordstatus=Wfgroup::model()->findstatusbyuser('inscbout');
		if (Yii::app()->request->isAjaxRequest)
        {
			if ($model->save()) {
			  echo CJSON::encode(array(
				  'status'=>'success',
				  'cashbankid'=>$model->cashbankid,
				  'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
				  'cashbankacc'=>$this->cashbankacc), true)
				  ));
			  Yii::app()->end();
			}
        }
	}
	
	public function actionCreatecashbankacc()
	{
		parent::actionCreate();
		$cashbankacc=new Cashbankacc;

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
                'divcreate'=>$this->renderPartial('_formcashbankacc',
				  array('model'=>$cashbankacc), true)
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
		parent::actionCreate();
		$id=$_POST['id'];
	  $model=$this->loadModel($id[0]);

	  $this->lookupdata();

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'cashbankid'=>$model->cashbankid,
				  'invoiceid'=>$model->invoiceid,
					'transdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->transdate)),
				  'invoiceno'=>($model->invoice!==null)?$model->invoice->invoiceno:"",
				  'amount'=>$model->amount,
				  'description'=>$model->description,
				  'currencyid'=>$model->currencyid,
				  'currencyname'=>($model->currency!==null)?$model->currency->currencyname:"",
				  'currencyrate'=>$model->currencyrate,
				  'accountid'=>$model->accountid,
                'accountname'=>($model->account!==null)?$model->account->accountname:"",
                'div'=>$this->renderPartial('_form', array('model'=>$model,
				  'cashbankacc'=>$this->cashbankacc), true)
				));
            Yii::app()->end();
        }
	}

	public function actionUpdatecashbankacc()
	{
		$id=$_POST['id'];
	  $cashbankacc=$this->loadModeldetailcashbankacc($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'cashbankaccid'=>$cashbankacc->cashbankaccid,
				'accountid'=>$cashbankacc->accountid,
                'accountname'=>($cashbankacc->account!==null)?$cashbankacc->account->accountname:"",
                'currencyid'=>$cashbankacc->currencyid,
                'currencyname'=>($cashbankacc->currency!==null)?$cashbankacc->currency->currencyname:"",
                'debit'=>$cashbankacc->debit,
                'credit'=>$cashbankacc->credit,
                'currencyrate'=>$cashbankacc->currencyrate,
                'description'=>$cashbankacc->description,
                'div'=>$this->renderPartial('_formcashbankacc',array('model'=>$cashbankacc), true)
				));
            Yii::app()->end();
        }
	}
		
    public function actionCancelWrite()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Cashbank'], $_POST['Cashbank']['cashbankid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Cashbank']))
	  {
         $messages = $this->ValidateData(
                array(
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Cashbank']['cashbankid'] > 0)
		{
		  $model=$this->loadModel($_POST['Cashbank']['cashbankid']);
		  $model->invoiceid = $_POST['Cashbank']['invoiceid'];
		  $model->accountid = $_POST['Cashbank']['accountid'];
		  $model->amount = $_POST['Cashbank']['amount'];
		  $model->currencyid = $_POST['Cashbank']['currencyid'];
		  $model->currencyrate = $_POST['Cashbank']['currencyrate'];
		  $model->transdate = $_POST['Cashbank']['transdate'];
		  $model->description = $_POST['Cashbank']['description'];
		}
		else
		{
		  $model = new Cashbank();
		  $model->attributes=$_POST['Cashbank'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Cashbank']['cashbankid']);
              $this->GetSMessage('insertsuccess');
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
	
	public function actionCancelWritecashbankacc()
    {
      $this->DeleteLockCloseForm($this->menuname, $_POST['Cashbankacc'], $_POST['Cashbankacc']['cashbankaccid']);
    }
	
	public function actionWritecashbankacc()
	{
	  if(isset($_POST['Cashbankacc']))
	  {
	  $messages = $this->ValidateData(
                array(
            )
        );
         if ($messages == '') {
		if ((int)$_POST['Cashbankacc']['cashbankaccid'] > 0)
		{
		  $model=Cashbankacc::model()->findbyPK($_POST['Cashbankacc']['cashbankaccid']);
		  $model->cashbankid = $_POST['Cashbankacc']['cashbankid'];
		  $model->accountid = $_POST['Cashbankacc']['accountid'];
		  $model->debit = $_POST['Cashbankacc']['debit'];
		  $model->credit = $_POST['Cashbankacc']['credit'];
		  $model->currencyid = $_POST['Cashbankacc']['currencyid'];
		  $model->currencyrate = $_POST['Cashbankacc']['currencyrate'];
		  $model->description = $_POST['Cashbankacc']['description'];
		}
		else
		{
		  $model = new Cashbankacc();
		  $model->attributes=$_POST['Cashbankacc'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Cashbankacc']['cashbankaccid']);
              $this->GetSMessage('ppinsertsuccess');
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
	
	public function actionApprove()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
			//$model=$this->loadModel($ids);
                    $a = Yii::app()->user->name;
			$connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call ApproveCashbankOut(:vid, :vlastupdateby)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$ids,PDO::PARAM_INT);
				$command->bindvalue(':vlastupdateby', $a,PDO::PARAM_STR);
				$command->execute();
				$transaction->commit();
				$this->GetSMessage('pprinsertsuccess');
			  }
			  catch(CDbexception $e) // an exception is raised if a query fails
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
	
	public function actionDeletecashbankacc()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Cashbankacc::model()->findbyPK($ids);
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
		$model=new Cashbank('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashbank']))
			$model->attributes=$_GET['Cashbank'];
		if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}

		$this->render('index',array(
			'model'=>$model,
				  'cashbankacc'=>$this->cashbankacc
		));
	}
	
	public function actionIndexcashbankacc()
	{
		$this->lookupdata();
	  $this->renderPartial('indexcashbankacc',
		array('cashbankacc'=>$this->cashbankacc));
	  Yii::app()->end();
	}
		
	public function actionUpload()
	{
      parent::actionUpload();
	   $folder=$_SERVER['DOCUMENT_ROOT'].Yii::app()->request->baseUrl.'/upload/';// folder for uploaded files
		$file = $folder . basename($_FILES['uploadfile']['name']); 
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
		{ 
			$row = 0;
			if (($handle = fopen($file, "r")) !== FALSE) 
			{
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
				{
					if ($row>0) {
						$model=Company::model()->findByPk((int)$data[0]);
						if ($model=== null) {
							$model = new Company();
						}
						$model->companyid = (int)$data[0];
						$model->companyname = $data[1];
						$model->address = $data[2];
						$city = City::model()->findbyattributes(array('cityname'=>$data[3]));
						if ($city !== null)
						{
							$model->cityid = $city->cityid;
						}
						$model->zipcode = $data[4];
						$model->taxno = $data[5];
						$currency = Currency::model()->findbyattributes(array('currencyname'=>$data[6]));
						if ($currency !== null)
						{
							$model->currencyid = $currency->currencyid;
						}
						$model->recordstatus = (int)$data[7];
						try
						{
							if(!$model->save())
							{
								$this->messages = $this->messages . Catalogsys::model()->getcatalog(' upload error at '.$data[0]);
							}
						}
						catch (Exception $e)
						{
							$this->messages = $this->messages .  $e->getMessage();
						}
					}
					$row++;
				}
			}
			else
			{
				$this->messages = $this->messages . ' memory or harddisk full';
			}
			fclose($handle);
		}
		else
		{
			$this->messages = $this->messages . ' check your directory permission';
		}
		if ($this->messages == '') {
			$this->messages = 'success';
		}		
		echo $this->messages;
}

	public function actionDownload()
	{
	  parent::actionDownload();
	   $sql = "select a.cashbankid, a.cashbankno, a.amount, a.accountid, b.accountname, a.currencyrate, c.symbol,a.transdate,
		a.description,d.invoiceno,b.accountcode,e.pono,f.fullname
		from cashbank a
		left join account b on b.accountid = a.accountid
		left join currency c on c.currencyid = a.currencyid
		left join invoice d on d.invoiceid = a.invoiceid
		left join poheader e on e.poheaderid = d.poheaderid 
		left join addressbook f on f.addressbookid = e.addressbookid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.cashbankid = ".$_GET['id'];
		}
		$sql = $sql . " order by cashbankid";
		$command=$this->connection->createCommand($sql);
		$dataReader=$command->queryAll();

    foreach($dataReader as $row)
    {
	if ((substr($row['accountcode'],0,6) == '1.1.01') or (substr($row['accountcode'],0,6) == '1.1.02'))
		{
	  $this->pdf->title= 'Cash Payment';
		}
		else 
		if ((substr($row['accountcode'],0,6) == '1.1.03') or (substr($row['accountcode'],0,6) == '1.1.04'))
		{
		$this->pdf->title='Bank Payment';
		}
			  $this->pdf->AddPage('P');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);
		$this->pdf->rect(10,60,195,25);
		$this->pdf->setFont('Arial','B',10);
		$this->pdf->text(15,$this->pdf->gety()+5,'CP No: '.$row['cashbankno']);
		$this->pdf->text(15,$this->pdf->gety()+10,'Invoice No: '.$row['invoiceno']);
		$this->pdf->text(15,$this->pdf->gety()+15,'PO No: '.$row['pono']);
		$this->pdf->text(15,$this->pdf->gety()+20,'Supplier: '.$row['fullname']);
		$this->pdf->text(150,$this->pdf->gety()+5,'Date: '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['transdate'])));
	  
      $sql1 = "select b.accountcode, d.accountcode as parentaccountcode, b.accountname, a.debit, a.credit, c.symbol,a.description,a.currencyrate
from cashbankacc a
left join account b on b.accountid = a.accountid
left join account d on d.accountid = b.parentaccountid
left join currency c on c.currencyid = a.currencyid
where cashbankid = ".$row['cashbankid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

      $this->pdf->SetY($this->pdf->gety()+25);
		$this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C','C','C','C');
      $this->pdf->setwidths(array(20,50,22,23,25,15,40));
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
	  $this->pdf->colheader = array('Account No','Account Name','Debit','Credit','Amount Curr','Rate','Description');
      $this->pdf->RowHeader();
		$this->pdf->setFont('Arial','',7);
      $this->pdf->setbordercell(array('LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
      $this->pdf->coldetailalign = array('L','L','R','R','R','R','L');
	  $totaldebet = 0;
	  $totalcredit = 0;
      foreach($dataReader1 as $row1)
      {
        $this->pdf->row(array($row1['accountcode'],
			$row1['accountname'],
			Yii::app()->numberFormatter->formatCurrency($row1['debit']*$row1['currencyrate'],$row1['symbol']),
			Yii::app()->numberFormatter->formatCurrency($row1['credit']*$row1['currencyrate'],$row1['symbol']),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row1['symbol']!=='Rp.'?($row1['debit']==0?$row1['debit']:$row1['credit']):""),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row1['currencyrate']),
			$row1['description'],
));
		$totaldebet = $totaldebet + ($row1['debit'] * $row1['currencyrate']);
		$totalcredit = $totalcredit + ($row1['credit'] * $row1['currencyrate']);
      }
      $this->pdf->row(array($row['accountcode'],
			$row['accountname'],
			Yii::app()->numberFormatter->formatCurrency(0,$row['symbol']),
			Yii::app()->numberFormatter->formatCurrency($row['amount']*$row['currencyrate'],$row['symbol']),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['symbol']!=='Rp.'?$row['amount']:""),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['currencyrate']),
			$row['description'],
));
	  $totalcredit = $totalcredit + $row['amount'];
      $this->pdf->setbordercell(array('LTRB','TB','LTRB','LTRB','LTRB','LTRB','LTRB','LTRB'));
      $this->pdf->setaligns(array('L','L','R','R','L','L','R','L'));
        $this->pdf->row(array('Total','',
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$totaldebet),
			Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$totalcredit),
			'',
			'',
			''
			));
		$this->pdf->text(10,$this->pdf->gety()+5,'INWORD : '.strtoupper($this->eja($row['amount'])));
		$this->pdf->text(10,$this->pdf->gety()+10,'NARRATION : ');
		$this->pdf->text(10,$this->pdf->gety()+15,$row['description']);
		
		$this->pdf->setFont('Arial','',10);
	$this->pdf->text(10,$this->pdf->gety()+35,'Prepared By');$this->pdf->text(50,$this->pdf->gety()+35,'Checked By');
      $this->pdf->text(10,$this->pdf->gety()+55,'(------------------)');$this->pdf->text(50,$this->pdf->gety()+55,'(------------------)');
	$this->pdf->text(90,$this->pdf->gety()+35,'Approved By');$this->pdf->text(130,$this->pdf->gety()+35,'Acknowladge By');
      $this->pdf->text(90,$this->pdf->gety()+55,'(------------------)');$this->pdf->text(130,$this->pdf->gety()+55,'(------------------)');
	$this->pdf->text(175,$this->pdf->gety()+35,'Received By');
      $this->pdf->text(175,$this->pdf->gety()+55,'(------------------)');

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
		$model=Cashbank::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetailcashbankacc($id)
	{
		$model=Cashbankacc::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='cashbankap-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='cashbankapservice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

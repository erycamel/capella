<?php

class PrheaderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        protected $menuname = 'prheader';

       public function actionHelp()
	{
		if (isset($_POST['id'])) {
			$id= (int)$_POST['id'];
			switch ($id) {
				case 1 : $this->txt = '_help'; break;
				case 2 : $this->txt = '_helpmodif'; break;
				case 3 : $this->txt = '_helpdetail'; break;
				case 4 : $this->txt = '_helpdetailmodif'; break;
			}
		}
		parent::actionHelp();
	}

    public $prmaterial, $product, $unitofmeasure, $sloc, $requestedby,
            $deliveryadvice;

    public function lookupdata()
    {
      $this->deliveryadvice=new Deliveryadvice('search');
	  $this->deliveryadvice->unsetAttributes();  // clear any default values
	  if(isset($_GET['Deliveryadvice']))
		$this->deliveryadvice->attributes=$_GET['Deliveryadvice'];
      $this->lookupdetail();
    }

    public function lookupdetail()
    {
      $this->prmaterial=new Prmaterial('search');
	  $this->prmaterial->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$this->prmaterial->attributes=$_GET['Prmaterial'];

		$this->product=new Product('search');
	  $this->product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$this->product->attributes=$_GET['Product'];

		$this->unitofmeasure=new Unitofmeasure('search');
	  $this->unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$this->unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$this->sloc=new Sloc('search');
	  $this->sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$this->sloc->attributes=$_GET['Sloc'];

		$this->requestedby=new Requestedby('search');
	  $this->requestedby->unsetAttributes();  // clear any default values
	  if(isset($_GET['Requestedby']))
		$this->requestedby->attributes=$_GET['Requestedby'];
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
      parent::actionCreate();
	  $this->lookupdata();

      $model=new Prheader;
      $model->recordstatus=Wfgroup::model()->findstatusbyuser('inspr');

      if (Yii::app()->request->isAjaxRequest)
      {
          if ($model->save()) {
            echo CJSON::encode(array(
                'status'=>'success',
                'prheaderid'=>$model->prheaderid,
                'divcreate'=>$this->renderPartial('_form', array('model'=>$model,
                  'prmaterial'=>$this->prmaterial,
                  'product'=>$this->product,
                  'unitofmeasure'=>$this->unitofmeasure,
                  'sloc'=>$this->sloc,
                  'requestedby'=>$this->requestedby,
                    'deliveryadvice'=>$this->deliveryadvice), true)
                ));
            Yii::app()->end();
          }
      }
	}

	public function actionCreatedetail()
	{
	  $this->lookupdetail();
      $prmaterial=new Prmaterial;

      if (Yii::app()->request->isAjaxRequest)
      {
          echo CJSON::encode(array(
              'status'=>'success',
              'divcreate'=>$this->renderPartial('_formdetail',
                array('model'=>$prmaterial,'product'=>$this->product,
                  'unitofmeasure'=>$this->unitofmeasure,
                  'requestedby'=>$this->requestedby), true)
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

		// Uncomment the following line if AJAX validation is needed
if ($model != null)
      {
        if ($this->CheckDataLock($this->menuname, $id[0]) == false)
        {
          $this->InsertLock($this->menuname, $id[0]);
            echo CJSON::encode(array(
                'status'=>'success',
				'prheaderid'=>$model->prheaderid,
				'prdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($model->prdate)),
				'headernote'=>$model->headernote,
                'deliveryadviceid'=>$model->deliveryadviceid,
                'dano'=>($model->deliveryadvice!==null)?$model->deliveryadvice->dano:"",
				'slocid'=>$model->slocid,
				'sloccode'=>($model->sloc!==null)?$model->sloc->description:"",
                'div'=>$this->renderPartial('_form', array('model'=>$model,
					'prmaterial'=>$this->prmaterial,
					'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
					'sloc'=>$this->sloc,
					'requestedby'=>$this->requestedby,
                    'deliveryadvice'=>$this->deliveryadvice), true)
				));
            Yii::app()->end();
        }
        }
	}
	
	public function actionDownload()
	{
	  parent::actionDownload();
	  $sql = "select a.prno,a.prdate,a.headernote,a.prheaderid,b.description,c.dano
      from prheader a 
	  left join sloc b on b.slocid = a.slocid 
	  left join deliveryadvice c on c.deliveryadviceid = a.deliveryadviceid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.prheaderid = ".$_GET['id'];
		}
		    $command=$this->connection->createCommand($sql);
    $dataReader=$command->queryAll();
	  $this->pdf->title='Purchase Requisition';
	  $this->pdf->AddPage('P');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    foreach($dataReader as $row)
    {
      $this->pdf->setFont('Arial','B',8);
        $this->pdf->Rect(10,60,190,30);
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['prno']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['prdate'])));
      $this->pdf->text(15,$this->pdf->gety()+15,'Storage Location ');$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['description']);
      $this->pdf->text(15,$this->pdf->gety()+20,'Request ');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['dano']);
      $this->pdf->text(15,$this->pdf->gety()+25,'Note ');$this->pdf->text(50,$this->pdf->gety()+25,': '.$row['headernote']);

      $sql1 = "select b.productname, a.qty, c.uomcode, a.itemtext
        from prmaterial a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        where prheaderid = ".$row['prheaderid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

	  $this->pdf->sety($this->pdf->gety()+30);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C');
      $this->pdf->setwidths(array(10,80,20,15,65));
	  $this->pdf->colheader = array('No','Items','Qty','Unit','Remark');
      $this->pdf->RowHeader();
      $this->pdf->coldetailalign = array('L','L','R','C','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['qty']),
            $row1['uomcode'],
            $row1['itemtext']));
      }
      
      $this->pdf->setFont('Arial','',10);
      $this->pdf->text(10,$this->pdf->gety()+20,'Approved By');$this->pdf->text(150,$this->pdf->gety()+20,'Proposed By');
      $this->pdf->text(10,$this->pdf->gety()+40,'---------------- ');$this->pdf->text(150,$this->pdf->gety()+40,'----------------');
      }
	  $this->pdf->Output();
	}

	public function actionUpdatedetail()
	{
	  	 $this->lookupdetail();

		$id=$_POST['id'];
	  $prmaterial=$this->loadModeldetail($id[0]);

		// Uncomment the following line if AJAX validation is needed

		if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'success',
				'prmaterialid'=>$prmaterial->prmaterialid,
				'productid'=>$prmaterial->productid,
				'productname'=>($prmaterial->product!==null)?$prmaterial->product->productname:"",
				'qty'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$prmaterial->qty),
				'unitofmeasureid'=>$prmaterial->unitofmeasureid,
				'uomcode'=>($prmaterial->unitofmeasure!==null)?$prmaterial->unitofmeasure->uomcode:"",
				'requestedbyid'=>$prmaterial->requestedbyid,
				'requestedbycode'=>($prmaterial->requestedby!==null)?$prmaterial->requestedby->description:"",
                'itemtext'=>$prmaterial->itemtext,
                'reqdate'=>date(Yii::app()->params['dateviewfromdb'], strtotime($prmaterial->reqdate)),
                'div'=>$this->renderPartial('_formdetail',
				  array('model'=>$prmaterial,'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
					'requestedby'=>$this->requestedby), true)
				));
            Yii::app()->end();
        }
	}

    public function actionCancelWrite()
    {
      $model = Prheader::model()->findbypk($_POST['Prheader']['prheaderid']);
      if ($model != null)
      {
        $model->Delete();
      }
      $this->DeleteLockCloseForm($this->menuname, $_POST['Prheader'], $_POST['Prheader']['prheaderid']);
    }

	public function actionWrite()
	{
	  if(isset($_POST['Prheader']))
	  {
        $messages = $this->ValidateData(
                array(array(
				$_POST['Prheader']['slocid'],'emptysloc','emptystring'),
				array($_POST['Prheader']['prdate'],'emptytransdate','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Prheader'];
		if ((int)$_POST['Prheader']['prheaderid'] > 0)
		{
		  $model=$this->loadModel($_POST['Prheader']['prheaderid']);
		  $model->headernote = $_POST['Prheader']['headernote'];
		  $model->deliveryadviceid = $_POST['Prheader']['deliveryadviceid'];
		  $model->slocid = $_POST['Prheader']['slocid'];
$model->prdate = $_POST['Prheader']['prdate'];	
}
		else
		{
		  $model = new Prheader();
		  $model->attributes=$_POST['Prheader'];
		}
		try
          {
            if($model->save())
            {
              $this->DeleteLock($this->menuname, $_POST['Prheader']['prheaderid']);
              $this->GetSMessage('iprinsertsuccess');
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
	  if(isset($_POST['Prmaterial']))
	  {
        $messages = $this->ValidateData(
                array(array($_POST['Prmaterial']['reqdate'],'emptyreqdate','emptystring'),
                    array($_POST['Prmaterial']['productid'],'emptyproduct','emptystring'),
                    array($_POST['Prmaterial']['qty'],'emptyqty','emptystring'),
                    array($_POST['Prmaterial']['unitofmeasureid'],'emptyunitofmeasure','emptystring'),
            )
        );
        if ($messages == '') {
		//$dataku->attributes=$_POST['Prmaterial'];
		if ((int)$_POST['Prmaterial']['prmaterialid'] > 0)
		{
		  $model=Prmaterial::model()->findbyPK($_POST['Prmaterial']['prmaterialid']);
		  $model->prheaderid = $_POST['Prmaterial']['prheaderid'];
		  $model->productid = $_POST['Prmaterial']['productid'];
		  $model->qty = $_POST['Prmaterial']['qty'];
		  $model->requestedbyid = $_POST['Prmaterial']['requestedbyid'];
		  $model->reqdate = $_POST['Prmaterial']['reqdate'];
		  $model->itemtext = $_POST['Prmaterial']['itemtext'];
		  $model->unitofmeasureid = $_POST['Prmaterial']['unitofmeasureid'];
		$model->qty = str_replace(",","",$model->qty);
		}
		else
		{
		  $model = new Prmaterial();
		  $model->attributes=$_POST['Prmaterial'];
		$model->qty = str_replace(",","",$model->qty);
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
	}

    public function actionGeneratedetail1()
        {
          if(isset($_POST['id']))
	  {
              $delv = Deliveryadvice::model()->findbypk($_POST['id']);
              $header;
              if ($delv != null)
              {
                  $header = $delv->headernote;
              }
              $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call GeneratePRDA(:vid, :vhid)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
				$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
              'headernote'=>$header,
					  'div'=>"Data generated"
					));
				}
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				  $transaction->rollBack();
				  if (Yii::app()->request->isAjaxRequest)
				  {
					  echo CJSON::encode(array(
						'status'=>'failure',
						'div'=>$e->getMessage()
					  ));
				  }
			  }
          }
           Yii::app()->end();
        }

        public function actionGeneratedetail()
        {
          if(isset($_POST['id']))
	  {
              $connection=Yii::app()->db;
			  $transaction=$connection->beginTransaction();
			  try
			  {
				$sql = 'call GeneratePRSO(:vid, :vhid)';
				$command=$connection->createCommand($sql);
				$command->bindvalue(':vid',$_POST['id'],PDO::PARAM_INT);
				$command->bindvalue(':vhid', $_POST['hid'],PDO::PARAM_INT);
				$command->execute();
				$transaction->commit();
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
					  'status'=>'success',
					  'div'=>"Data generated"
					));
				}
			  }
			  catch(Exception $e) // an exception is raised if a query fails
			  {
				  $transaction->rollBack();
				  if (Yii::app()->request->isAjaxRequest)
				  {
					  echo CJSON::encode(array(
						'status'=>'failure',
						'div'=>$e->getMessage()
					  ));
				  }
			  }
          }
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
            $sql = 'call ApprovePR(:vid, :vlastupdateby)';
            $command=$connection->createCommand($sql);
            $command->bindValue(':vid',$ids,PDO::PARAM_INT);
            $command->bindValue(':vlastupdateby', $a,PDO::PARAM_STR);
            $command->execute();
            $transaction->commit();
            $this->GetSMessage('pprinsertsuccess');
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

		$model=new Prheader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Prheader']))
			$model->attributes=$_GET['Prheader'];
if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('index',array(
			'model'=>$model,
					'prmaterial'=>$this->prmaterial,
					'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
					'sloc'=>$this->sloc,
					'requestedby'=>$this->requestedby,
            'deliveryadvice'=>$this->deliveryadvice
		));
	}

	public function actionIndexdetail()
	{
	  $this->lookupdetail();

		$prmaterial=new Prmaterial('search');
	  $prmaterial->unsetAttributes();  // clear any default values
	  if(isset($_GET['Prmaterial']))
		$prmaterial->attributes=$_GET['Prmaterial'];

	  $this->renderPartial('indexdetail',
		array('prmaterial'=>$prmaterial,'product'=>$this->product,
					'unitofmeasure'=>$this->unitofmeasure,
					'requestedby'=>$this->requestedby));
	  Yii::app()->end();
	}

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

	public function actionDeletedetail()
	{
		$id=$_POST['id'];
		foreach($id as $ids)
		{
		  $model=Prmaterial::model()->findbyPK($ids);
		  $model->delete();
		}
		echo CJSON::encode(array(
                'status'=>'success',
                'div'=>'Data deleted'
				));
        Yii::app()->end();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Prheader::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Prmaterial::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='prheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

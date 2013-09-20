<?php

class ReportdaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        protected $menuname = 'reportda';

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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            parent::actionIndex();
	  $deliveryadvicedetail=new Deliveryadvicedetail('search');
	  $deliveryadvicedetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Deliveryadvicedetail']))
		$deliveryadvicedetail->attributes=$_GET['Deliveryadvicedetail'];

		$product=new Product('search');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];

		$unitofmeasure=new Unitofmeasure('search');
	  $unitofmeasure->unsetAttributes();  // clear any default values
	  if(isset($_GET['Unitofmeasure']))
		$unitofmeasure->attributes=$_GET['Unitofmeasure'];

		$sloc=new Sloc('search');
	  $sloc->unsetAttributes();  // clear any default values
	  if(isset($_GET['Sloc']))
		$sloc->attributes=$_GET['Sloc'];

		$requestedby=new Requestedby('search');
	  $requestedby->unsetAttributes();  // clear any default values
	  if(isset($_GET['Requestedby']))
		$requestedby->attributes=$_GET['Requestedby'];

      $project=new Project('search');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];

		$model=new Deliveryadvice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Deliveryadvice']))
			$model->attributes=$_GET['Deliveryadvice'];
if (isset($_GET['pageSize']))
		{
		  Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		  unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
		}
		$this->render('index',array(
			'model'=>$model,
					'deliveryadvicedetail'=>$deliveryadvicedetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'sloc'=>$sloc,
					'requestedby'=>$requestedby,
            'project'=>$project
		));
	}
    
    public function actionDownload()
	{
	  parent::actionDownload();
	  $sql = "select a.dano,a.dadate,a.headernote,a.deliveryadviceid
      from deliveryadvice a ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.deliveryadviceid = ".$_GET['id'];
		}
		    $command=$this->connection->createCommand($sql);
    $dataReader=$command->queryAll();
	  $this->pdf->title='Form Request (Goods/Service/Delivery)';
	  $this->pdf->AddPage('P');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    foreach($dataReader as $row)
    {
	      //$this->pdf->SetY($this->pdf->gety()+20);
        $this->pdf->Rect(10,60,190,25);
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['dano']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['dadate'])));
      $this->pdf->text(15,$this->pdf->gety()+15,'Note ');$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['headernote']);

      $sql1 = "select b.productname, a.qty, c.uomcode, a.itemtext
        from deliveryadvicedetail a
        left join product b on b.productid = a.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        where deliveryadviceid = ".$row['deliveryadviceid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

	  $this->pdf->sety($this->pdf->gety()+25);
      $this->pdf->setFont('Arial','B',8);
      $this->pdf->colalign = array('C','C','C','C','C');
      $this->pdf->setwidths(array(10,80,20,15,65));
	  $this->pdf->colheader = array('No','Items','Qty','Unit','Remark');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',7);
      $this->pdf->coldetailalign = array('L','L','R','L','L');
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

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Reportda::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Deliveryadvicedetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='deliveryadvice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

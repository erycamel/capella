<?php

class ReportgiController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
protected $menuname = 'giheader';

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

	public $gidetail,$customer,$doheader,$stockout,$productstock,$deliveryadvice;

	public function lookupdata()
	{
	  $this->gidetail=new Gidetail('searchbygiheaderid');
	  $this->gidetail->unsetAttributes();  // clear any default values
	  if(isset($_GET['Gidetail']))
		$this->gidetail->attributes=$_GET['Gidetail'];

          $this->stockout=new Gidetail('search');
	  $this->stockout->unsetAttributes();  // clear any default values
	  if(isset($_GET['Stockout']))
		$this->stockout->attributes=$_GET['Stockout'];

          $this->productstock=new Gidetail('search');
	  $this->productstock->unsetAttributes();  // clear any default values
	  if(isset($_GET['Productstock']))
		$this->productstock->attributes=$_GET['Productstock'];

	  $this->customer=new Customer('search');
	  $this->customer->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$this->customer->attributes=$_GET['Customer'];

          $this->doheader=new Doheader('search');
	  $this->doheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Doheader']))
		$this->doheader->attributes=$_GET['Doheader'];

      $this->deliveryadvice=new Deliveryadvice('search');
	  $this->deliveryadvice->unsetAttributes();  // clear any default values
	  if(isset($_GET['Deliveryadvice']))
		$this->deliveryadvice->attributes=$_GET['Deliveryadvice'];
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	  parent::actionIndex();
	  $this->lookupdata();
	  $model=new Giheader('search');
	  $model->unsetAttributes();  // clear any default values
	  if(isset($_GET['Giheader']))
		  $model->attributes=$_GET['Giheader'];
	  if (isset($_GET['pageSize']))
	  {
		Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
	  }
	  $this->render('index',array(
		  'model'=>$model,
				  'gidetail'=>$this->gidetail,
				  'customer'=>$this->customer,
				'doheader'=>$this->doheader,
          'deliveryadvice'=>$this->deliveryadvice
	  ));
	}


	public function actionDownload()
  {
	parent::actionDownload();
    $sql = "select a.gino,a.gidate,b.dano,a.location,a.giheaderid,a.headernote
      from giheader a
      left join deliveryadvice b on b.deliveryadviceid = a.deliveryadviceid ";
		if ($_GET['id'] !== '') {
				$sql = $sql . "where a.giheaderid = ".$_GET['id'];
		}
		    $command=$this->connection->createCommand($sql);
    $dataReader=$command->queryAll();
	  $this->pdf->title='Goods Issue';
	  $this->pdf->AddPage('P');
	  // definisi font
	  $this->pdf->setFont('Arial','B',8);

    foreach($dataReader as $row)
    {
        $this->pdf->Rect(10,60,190,25);
      $this->pdf->text(15,$this->pdf->gety()+5,'No ');$this->pdf->text(50,$this->pdf->gety()+5,': '.$row['gino']);
      $this->pdf->text(15,$this->pdf->gety()+10,'Date ');$this->pdf->text(50,$this->pdf->gety()+10,': '.date(Yii::app()->params['dateviewfromdb'], strtotime($row['gidate'])));
      $this->pdf->text(15,$this->pdf->gety()+15,'Form No ');$this->pdf->text(50,$this->pdf->gety()+15,': '.$row['dano']);
      $this->pdf->text(15,$this->pdf->gety()+20,'Location ');$this->pdf->text(50,$this->pdf->gety()+20,': '.$row['location']);

      $sql1 = "select b.productname, a.qty, c.uomcode,d.description,a.serialno
        from gidetail a
        left join productdetail e on e.productdetailid = a.productdetailid
        left join product b on b.productid = e.productid
        left join unitofmeasure c on c.unitofmeasureid = a.unitofmeasureid
        left join sloc d on d.slocid = a.slocid
        where giheaderid = ".$row['giheaderid'];
      $command1=$this->connection->createCommand($sql1);
      $dataReader1=$command1->queryAll();

	  $this->pdf->sety($this->pdf->gety()+25);
      $this->pdf->colalign = array('C','C','C','C','C','C','C');
      $this->pdf->setFont('Arial','B',6);
      $this->pdf->setwidths(array(10,80,30,20,20,30));
	  $this->pdf->colheader = array('No','Nama Barang','Serial No','Qty','Unit','Gudang');
      $this->pdf->RowHeader();
      $this->pdf->setFont('Arial','',6);
      $this->pdf->coldetailalign = array('L','L','L','L','L','L','L');
      $i=0;
      foreach($dataReader1 as $row1)
      {
        $i=$i+1;
        $this->pdf->row(array($i,$row1['productname'],
            $row1['serialno'],
            Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$row1['qty']),
            $row1['uomcode'],
            $row1['description']));
      }
	  $this->pdf->text(10,$this->pdf->gety()+10,'Catatan: ');
	  $this->pdf->text(10,$this->pdf->gety()+15,$row['headernote']);
      $this->pdf->setFont('Arial','',8);
      $this->pdf->text(10,$this->pdf->gety()+25,'Inventory Staff');$this->pdf->text(100,$this->pdf->gety()+25,'Accepted');
      $this->pdf->text(10,$this->pdf->gety()+40,'----------------------');$this->pdf->text(95,$this->pdf->gety()+40,'----------------------');
      
      $this->pdf->AddPage('P');
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
		$model=Reportgi::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModeldetail($id)
	{
		$model=Gidetail::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='giheader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='gidetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

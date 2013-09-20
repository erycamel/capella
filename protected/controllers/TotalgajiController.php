<?php

class TotalgajiController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    protected $menuname = 'totalgaji';

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

    public function actionDownload()
    {
           
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
      parent::actionIndex();
      if (isset($_POST['payrollperiodid']))
      {
        $pdf = new PDF();
        $pdf->title='Total Gaji';
        $pdf->AddPage('L', 'A4');
        $pdf->setFont('Arial','B',12);
		$connection=Yii::app()->db;
        $sql = "";
          $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
          $pdf->setFont('Arial','B',6);
          $pdf->setwidths(array(30,20,20,20,20,20,20,20,20,20,20,20,20,20));
          $pdf->row(array('Position','Januari','Februari','Maret','April','Mei',
              'Juni','Juli','Agustus','September',
              'Oktober','November',
              'Desember'));
          $pdf->SetTableData();
          foreach($dataReader as $row)
          {
            $pdf->row(array($row['positionname'],                
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['januari']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['februari']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['maret']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['april']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['mei']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['juni']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['juli']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['agustus']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['september']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['oktober']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['november']),
                Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$row['desember'])));
          }

          $pdf->Output('Totalgaji.pdf','D');
      }
      else {
        $this->render('index');
      }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Totalgaji::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='payrollprocess-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

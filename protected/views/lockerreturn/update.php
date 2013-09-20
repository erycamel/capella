<?php
$this->breadcrumbs=array(
	'Lockerreturns'=>array('index'),
	$model->lockerreturnid=>array('view','id'=>$model->lockerreturnid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lockerreturn', 'url'=>array('index')),
	array('label'=>'Create Lockerreturn', 'url'=>array('create')),
	array('label'=>'View Lockerreturn', 'url'=>array('view', 'id'=>$model->lockerreturnid)),
	array('label'=>'Manage Lockerreturn', 'url'=>array('admin')),
);
?>

<h1>Update Lockerreturn <?php echo $model->lockerreturnid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
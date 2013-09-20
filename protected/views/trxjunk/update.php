<?php
$this->breadcrumbs=array(
	'Trxjunks'=>array('index'),
	$model->trxjunkid=>array('view','id'=>$model->trxjunkid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Trxjunk', 'url'=>array('index')),
	array('label'=>'Create Trxjunk', 'url'=>array('create')),
	array('label'=>'View Trxjunk', 'url'=>array('view', 'id'=>$model->trxjunkid)),
	array('label'=>'Manage Trxjunk', 'url'=>array('admin')),
);
?>

<h1>Update Trxjunk <?php echo $model->trxjunkid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
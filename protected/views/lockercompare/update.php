<?php
$this->breadcrumbs=array(
	'Lockercompares'=>array('index'),
	$model->lockercompareid=>array('view','id'=>$model->lockercompareid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lockercompare', 'url'=>array('index')),
	array('label'=>'Create Lockercompare', 'url'=>array('create')),
	array('label'=>'View Lockercompare', 'url'=>array('view', 'id'=>$model->lockercompareid)),
	array('label'=>'Manage Lockercompare', 'url'=>array('admin')),
);
?>

<h1>Update Lockercompare <?php echo $model->lockercompareid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
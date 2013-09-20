<?php
$this->breadcrumbs=array(
	'Userinboxes'=>array('index'),
	$model->userinboxid,
);

$this->menu=array(
	array('label'=>'List Userinbox', 'url'=>array('index')),
	array('label'=>'Create Userinbox', 'url'=>array('create')),
	array('label'=>'Update Userinbox', 'url'=>array('update', 'id'=>$model->userinboxid)),
	array('label'=>'Delete Userinbox', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->userinboxid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Userinbox', 'url'=>array('admin')),
);
?>

<h1>View Userinbox #<?php echo $model->userinboxid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'userinboxid',
		'useraccessid',
		'messages',
		'recordstatus',
	),
)); ?>

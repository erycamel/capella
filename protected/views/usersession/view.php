<?php
$this->breadcrumbs=array(
	'Usersessions'=>array('index'),
	$model->usersessionid,
);

$this->menu=array(
	array('label'=>'List Usersession', 'url'=>array('index')),
	array('label'=>'Create Usersession', 'url'=>array('create')),
	array('label'=>'Update Usersession', 'url'=>array('update', 'id'=>$model->usersessionid)),
	array('label'=>'Delete Usersession', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->usersessionid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Usersession', 'url'=>array('admin')),
);
?>

<h1>View Usersession #<?php echo $model->usersessionid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'usersessionid',
		'useraccessid',
		'menuaccessid',
		'usertime',
		'sessioncode',
		'recordstatus',
		'ipaddress',
	),
)); ?>

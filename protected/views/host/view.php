<?php
$this->breadcrumbs=array(
	'Hosts'=>array('index'),
	$model->hostid,
);

$this->menu=array(
	array('label'=>'List Host', 'url'=>array('index')),
	array('label'=>'Create Host', 'url'=>array('create')),
	array('label'=>'Update Host', 'url'=>array('update', 'id'=>$model->hostid)),
	array('label'=>'Delete Host', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->hostid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Host', 'url'=>array('admin')),
);
?>

<h1>View Host #<?php echo $model->hostid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'hostid',
		'hostname',
		'ipclient',
		'recordstatus',
	),
)); ?>

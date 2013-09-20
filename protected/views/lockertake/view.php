<?php
$this->breadcrumbs=array(
	'Lockertakes'=>array('index'),
	$model->lockertakeid,
);

$this->menu=array(
	array('label'=>'List Lockertake', 'url'=>array('index')),
	array('label'=>'Create Lockertake', 'url'=>array('create')),
	array('label'=>'Update Lockertake', 'url'=>array('update', 'id'=>$model->lockertakeid)),
	array('label'=>'Delete Lockertake', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lockertakeid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lockertake', 'url'=>array('admin')),
);
?>

<h1>View Lockertake #<?php echo $model->lockertakeid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lockertakeid',
		'employeeid',
		'lockerkeyid',
		'fullname',
		'oldnik',
		'newnik',
		'fulldivision',
		'takedate',
		'recordstatus',
	),
)); ?>

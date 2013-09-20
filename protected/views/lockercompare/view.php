<?php
$this->breadcrumbs=array(
	'Lockercompares'=>array('index'),
	$model->lockercompareid,
);

$this->menu=array(
	array('label'=>'List Lockercompare', 'url'=>array('index')),
	array('label'=>'Create Lockercompare', 'url'=>array('create')),
	array('label'=>'Update Lockercompare', 'url'=>array('update', 'id'=>$model->lockercompareid)),
	array('label'=>'Delete Lockercompare', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lockercompareid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lockercompare', 'url'=>array('admin')),
);
?>

<h1>View Lockercompare #<?php echo $model->lockercompareid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lockercompareid',
		'lockerkeyid',
		'keynum',
		'employeeid',
		'fullname',
		'oldnik',
		'newnik',
		'fulldivision',
		'absscheduleid',
		'schedulename',
		'transdate',
		'takedate',
		'checkdate',
		'returndate',
	),
)); ?>

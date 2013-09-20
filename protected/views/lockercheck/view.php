<?php
$this->breadcrumbs=array(
	'Lockerchecks'=>array('index'),
	$model->lockercheckid,
);

$this->menu=array(
	array('label'=>'List Lockercheck', 'url'=>array('index')),
	array('label'=>'Create Lockercheck', 'url'=>array('create')),
	array('label'=>'Update Lockercheck', 'url'=>array('update', 'id'=>$model->lockercheckid)),
	array('label'=>'Delete Lockercheck', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lockercheckid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lockercheck', 'url'=>array('admin')),
);
?>

<h1>View Lockercheck #<?php echo $model->lockercheckid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lockercheckid',
		'lockerboxid',
		'lockerkeyid',
		'lockerstaffid',
		'checkdate',
		'employeeid',
		'fullname',
		'oldnik',
		'newnik',
		'recordstatus',
	),
)); ?>

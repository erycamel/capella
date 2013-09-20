<?php
$this->breadcrumbs=array(
	'Lockerreturns'=>array('index'),
	$model->lockerreturnid,
);

$this->menu=array(
	array('label'=>'List Lockerreturn', 'url'=>array('index')),
	array('label'=>'Create Lockerreturn', 'url'=>array('create')),
	array('label'=>'Update Lockerreturn', 'url'=>array('update', 'id'=>$model->lockerreturnid)),
	array('label'=>'Delete Lockerreturn', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lockerreturnid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Lockerreturn', 'url'=>array('admin')),
);
?>

<h1>View Lockerreturn #<?php echo $model->lockerreturnid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lockerreturnid',
		'lockerkeyid',
		'lockerboxid',
		'returndate',
		'lockerstaffid',
		'employeeid',
		'fullname',
		'oldnik',
		'newnik',
		'fulldivision',
		'recordstatus',
	),
)); ?>

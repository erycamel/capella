<?php
$this->breadcrumbs=array(
	'Memberyms'=>array('index'),
	$model->memberymid,
);

$this->menu=array(
	array('label'=>'List Memberym', 'url'=>array('index')),
	array('label'=>'Create Memberym', 'url'=>array('create')),
	array('label'=>'Update Memberym', 'url'=>array('update', 'id'=>$model->memberymid)),
	array('label'=>'Delete Memberym', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->memberymid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Memberym', 'url'=>array('admin')),
);
?>

<h1>View Memberym #<?php echo $model->memberymid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'memberymid',
		'voucheragentid',
		'idym',
		'recordstatus',
	),
)); ?>

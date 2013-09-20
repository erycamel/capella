<?php
$this->breadcrumbs=array(
	'Tikitransdets'=>array('index'),
	$model->tikitransdetid,
);

$this->menu=array(
	array('label'=>'List Tikitransdet', 'url'=>array('index')),
	array('label'=>'Create Tikitransdet', 'url'=>array('create')),
	array('label'=>'Update Tikitransdet', 'url'=>array('update', 'id'=>$model->tikitransdetid)),
	array('label'=>'Delete Tikitransdet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->tikitransdetid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tikitransdet', 'url'=>array('admin')),
);
?>

<h1>View Tikitransdet #<?php echo $model->tikitransdetid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'tikitransdetid',
		'airwaybillno',
		'description',
		'pieces',
		'weight',
		'length',
		'width',
		'height',
		'weightvol',
		'recordstatus',
	),
)); ?>

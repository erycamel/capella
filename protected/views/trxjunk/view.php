<?php
$this->breadcrumbs=array(
	'Trxjunks'=>array('index'),
	$model->trxjunkid,
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index')),
);
?>

<h1>View Trxjunk #<?php echo $model->trxjunkid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'trxjunkid',
		'trxdate',
		'senderx',
		'textdecoded',
	),
)); ?>

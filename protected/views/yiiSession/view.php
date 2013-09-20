<?php
$this->breadcrumbs=array(
	'Yii Sessions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List YiiSession', 'url'=>array('index')),
	array('label'=>'Create YiiSession', 'url'=>array('create')),
	array('label'=>'Update YiiSession', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete YiiSession', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage YiiSession', 'url'=>array('admin')),
);
?>

<h1>View YiiSession #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'expire',
		'data',
	),
)); ?>

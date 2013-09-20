<?php
$this->breadcrumbs=array(
	'Moduletypes'=>array('index'),
	$model->moduletypeid,
);

$this->menu=array(
	array('label'=>'List Moduletype', 'url'=>array('index')),
	array('label'=>'Create Moduletype', 'url'=>array('create')),
	array('label'=>'Update Moduletype', 'url'=>array('update', 'id'=>$model->moduletypeid)),
	array('label'=>'Delete Moduletype', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->moduletypeid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Moduletype', 'url'=>array('admin')),
);
?>

<h1>View Moduletype #<?php echo $model->moduletypeid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'moduletypeid',
		'moduletypename',
		'recordstatus',
	),
)); ?>

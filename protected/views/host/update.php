<?php
$this->breadcrumbs=array(
	'Hosts'=>array('index'),
	$model->hostid=>array('view','id'=>$model->hostid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Host', 'url'=>array('index')),
	array('label'=>'Create Host', 'url'=>array('create')),
	array('label'=>'View Host', 'url'=>array('view', 'id'=>$model->hostid)),
	array('label'=>'Manage Host', 'url'=>array('admin')),
);
?>

<h1>Update Host <?php echo $model->hostid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Moduletypes'=>array('index'),
	$model->moduletypeid=>array('view','id'=>$model->moduletypeid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Moduletype', 'url'=>array('index')),
	array('label'=>'Create Moduletype', 'url'=>array('create')),
	array('label'=>'View Moduletype', 'url'=>array('view', 'id'=>$model->moduletypeid)),
	array('label'=>'Manage Moduletype', 'url'=>array('admin')),
);
?>

<h1>Update Moduletype <?php echo $model->moduletypeid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
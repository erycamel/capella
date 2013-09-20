<?php
$this->breadcrumbs=array(
	'Userinboxes'=>array('index'),
	$model->userinboxid=>array('view','id'=>$model->userinboxid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Userinbox', 'url'=>array('index')),
	array('label'=>'Create Userinbox', 'url'=>array('create')),
	array('label'=>'View Userinbox', 'url'=>array('view', 'id'=>$model->userinboxid)),
	array('label'=>'Manage Userinbox', 'url'=>array('admin')),
);
?>

<h1>Update Userinbox <?php echo $model->userinboxid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
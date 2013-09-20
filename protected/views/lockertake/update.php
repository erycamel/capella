<?php
$this->breadcrumbs=array(
	'Lockertakes'=>array('index'),
	$model->lockertakeid=>array('view','id'=>$model->lockertakeid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lockertake', 'url'=>array('index')),
	array('label'=>'Create Lockertake', 'url'=>array('create')),
	array('label'=>'View Lockertake', 'url'=>array('view', 'id'=>$model->lockertakeid)),
	array('label'=>'Manage Lockertake', 'url'=>array('admin')),
);
?>

<h1>Update Lockertake <?php echo $model->lockertakeid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
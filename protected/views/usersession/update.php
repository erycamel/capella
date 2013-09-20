<?php
$this->breadcrumbs=array(
	'Usersessions'=>array('index'),
	$model->usersessionid=>array('view','id'=>$model->usersessionid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Usersession', 'url'=>array('index')),
	array('label'=>'Create Usersession', 'url'=>array('create')),
	array('label'=>'View Usersession', 'url'=>array('view', 'id'=>$model->usersessionid)),
	array('label'=>'Manage Usersession', 'url'=>array('admin')),
);
?>

<h1>Update Usersession <?php echo $model->usersessionid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
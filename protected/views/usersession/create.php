<?php
$this->breadcrumbs=array(
	'Usersessions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Usersession', 'url'=>array('index')),
	array('label'=>'Manage Usersession', 'url'=>array('admin')),
);
?>

<h1>Create Usersession</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
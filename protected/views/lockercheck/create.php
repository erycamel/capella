<?php
$this->breadcrumbs=array(
	'Lockerchecks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lockercheck', 'url'=>array('index')),
	array('label'=>'Manage Lockercheck', 'url'=>array('admin')),
);
?>

<h1>Create Lockercheck</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
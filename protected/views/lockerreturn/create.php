<?php
$this->breadcrumbs=array(
	'Lockerreturns'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lockerreturn', 'url'=>array('index')),
	array('label'=>'Manage Lockerreturn', 'url'=>array('admin')),
);
?>

<h1>Create Lockerreturn</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
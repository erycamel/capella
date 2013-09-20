<?php
$this->breadcrumbs=array(
	'Lockercompares'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lockercompare', 'url'=>array('index')),
	array('label'=>'Manage Lockercompare', 'url'=>array('admin')),
);
?>

<h1>Create Lockercompare</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
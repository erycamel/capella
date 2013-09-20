<?php
$this->breadcrumbs=array(
	'Trxjunks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Trxjunk', 'url'=>array('index')),
	array('label'=>'Manage Trxjunk', 'url'=>array('admin')),
);
?>

<h1>Create Trxjunk</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
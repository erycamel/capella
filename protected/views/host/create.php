<?php
$this->breadcrumbs=array(
	'Hosts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Host', 'url'=>array('index')),
	array('label'=>'Manage Host', 'url'=>array('admin')),
);
?>

<h1>Create Host</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
$this->breadcrumbs=array(
	'Moduletypes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Moduletype', 'url'=>array('index')),
	array('label'=>'Manage Moduletype', 'url'=>array('admin')),
);
?>

<h1>Create Moduletype</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
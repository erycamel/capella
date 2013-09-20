<?php
$this->breadcrumbs=array(
	'Tikitransdets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tikitransdet', 'url'=>array('index')),
	array('label'=>'Manage Tikitransdet', 'url'=>array('admin')),
);
?>

<h1>Create Tikitransdet</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
  'tikitrans'=>$tikitrans)); ?>
<?php
$this->breadcrumbs=array(
	'Userinboxes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Userinbox', 'url'=>array('index')),
	array('label'=>'Manage Userinbox', 'url'=>array('admin')),
);
?>

<h1>Create Userinbox</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
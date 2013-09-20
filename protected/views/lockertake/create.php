<?php
$this->breadcrumbs=array(
	'Lockertakes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lockertake', 'url'=>array('index')),
	array('label'=>'Manage Lockertake', 'url'=>array('admin')),
);
?>

<h1>Create Lockertake</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
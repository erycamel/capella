<?php
$this->breadcrumbs=array(
	'Memberyms'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Memberym', 'url'=>array('index')),
	array('label'=>'Manage Memberym', 'url'=>array('admin')),
);
?>

<h1>Create Memberym</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
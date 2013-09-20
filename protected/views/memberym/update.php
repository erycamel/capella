<?php
$this->breadcrumbs=array(
	'Memberyms'=>array('index'),
	$model->memberymid=>array('view','id'=>$model->memberymid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Memberym', 'url'=>array('index')),
	array('label'=>'Create Memberym', 'url'=>array('create')),
	array('label'=>'View Memberym', 'url'=>array('view', 'id'=>$model->memberymid)),
	array('label'=>'Manage Memberym', 'url'=>array('admin')),
);
?>

<h1>Update Memberym <?php echo $model->memberymid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
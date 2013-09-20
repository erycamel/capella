<?php
$this->breadcrumbs=array(
	'Tikitransdets'=>array('index'),
	$model->tikitransdetid=>array('view','id'=>$model->tikitransdetid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tikitransdet', 'url'=>array('index')),
	array('label'=>'Create Tikitransdet', 'url'=>array('create')),
	array('label'=>'View Tikitransdet', 'url'=>array('view', 'id'=>$model->tikitransdetid)),
	array('label'=>'Manage Tikitransdet', 'url'=>array('admin')),
);
?>

<h1>Update Tikitransdet <?php echo $model->tikitransdetid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
  'tikitrans'=>$tikitrans)); ?>
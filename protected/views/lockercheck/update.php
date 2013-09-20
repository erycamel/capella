<?php
$this->breadcrumbs=array(
	'Lockerchecks'=>array('index'),
	$model->lockercheckid=>array('view','id'=>$model->lockercheckid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lockercheck', 'url'=>array('index')),
	array('label'=>'Create Lockercheck', 'url'=>array('create')),
	array('label'=>'View Lockercheck', 'url'=>array('view', 'id'=>$model->lockercheckid)),
	array('label'=>'Manage Lockercheck', 'url'=>array('admin')),
);
?>

<h1>Update Lockercheck <?php echo $model->lockercheckid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
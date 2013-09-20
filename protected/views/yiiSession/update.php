<?php
$this->breadcrumbs=array(
	'Yii Sessions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List YiiSession', 'url'=>array('index')),
	array('label'=>'Create YiiSession', 'url'=>array('create')),
	array('label'=>'View YiiSession', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage YiiSession', 'url'=>array('admin')),
);
?>

<h1>Update YiiSession <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
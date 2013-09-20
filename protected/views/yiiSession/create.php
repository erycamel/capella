<?php
$this->breadcrumbs=array(
	'Yii Sessions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List YiiSession', 'url'=>array('index')),
	array('label'=>'Manage YiiSession', 'url'=>array('admin')),
);
?>

<h1>Create YiiSession</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
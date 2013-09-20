<?php
$this->breadcrumbs=array(
	'Yii Sessions',
);

$this->menu=array(
	array('label'=>'Create YiiSession', 'url'=>array('create')),
	array('label'=>'Manage YiiSession', 'url'=>array('admin')),
);
?>

<h1>Yii Sessions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

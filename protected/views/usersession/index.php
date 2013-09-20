<?php
$this->breadcrumbs=array(
	'Usersessions',
);

$this->menu=array(
	array('label'=>'Manage', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('usersession-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Usersessions</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usersession-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'usersessionid',
		'useraccessid',
		'menuaccessid',
		'usertime',
		'sessioncode',
		'recordstatus',
		/*
		'ipaddress',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php
$this->breadcrumbs=array(
	'Lockercompares',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('lockercompare-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Locker Compares</h1>
<?php
$this->widget('zii.widgets.jui.CJuiAccordion', array(
    'panels'=>array(
        'Advanced Search'=>$this->renderPartial('_search',array(
	'model'=>$model,
),true),
    ),
    'options'=>array(
        'collapsible'=>true,
        'active'=>1,
    ),
    'htmlOptions'=>array(
        'style'=>'width:100%;'
    ),
));?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lockercompare-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
  'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'itemSelected',
      'selectableRows'=>'2',
    ),
		'lockercompareid',
		'lockerkeyid',
		'keynum',
		'employeeid',
		'fullname',
		'oldnik',
		/*
		'newnik',
		'fulldivision',
		'absscheduleid',
		'schedulename',
		'transdate',
		'takedate',
		'checkdate',
		'returndate',
		*/
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->recordstatus'
    ),
		array(
			'class'=>'CButtonColumn',
      'header'=>'Actions',
		),
	),
)); ?>

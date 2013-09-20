<?php
$this->breadcrumbs=array(
	'Tikitransdets',
);
?>

<h1>Transaction details</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tikitransdet-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'itemSelected',
      'selectableRows'=>'2',
    ),
		'tikitransdetid',
		'airwaybillno',
		'description',
		'pieces',
		'weight',
		'length',
		'width',
		'height',
		'weightvol',
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

<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'innetworkdatagrid',
	'dataProvider'=>$projectnetwork->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		'application',
		array('name'=>'technology', 'header'=>'Technology', 'value'=>'$data->technology'),
		'upstream',
		'downstream',
		array('name'=>'accessmethodid', 'value'=>'($data->accessmethod!==null)?$data->accessmethod->accessmethodname:""'),
		'originipaddress',
		'destipaddress',
		'originnetmask',
		'destnetmask'
  ),
));
?>

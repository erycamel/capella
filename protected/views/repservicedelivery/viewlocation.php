<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inlocationdatagrid',
	'dataProvider'=>$projectlocation->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array('name'=>'originid', 'value'=>'($data->origin!==null)?$data->origin->fullname:""'),
		array('name'=>'destid', 'value'=>'($data->dest!==null)?$data->dest->fullname:""'),
	'originaddress',
	'destaddress',
		array('name'=>'origincityid', 'value'=>'($data->origincity!==null)?$data->origincity->cityname:""'),
		array('name'=>'destcityid', 'value'=>'($data->destcity!==null)?$data->destcity->cityname:""'),
		'originbuilding',
		'destbuilding'
  ),
));
?>

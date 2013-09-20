<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inservicedatagrid',
	'dataProvider'=>$projectservice->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array('name'=>'requestforid', 'value'=>'($data->requestfor!==null)?$data->requestfor->requestforname:""'),
		array('name'=>'contracttermid', 'value'=>'($data->contractterm!==null)?$data->contractterm->contracttermname:""'),
		array(
      'name'=>'estimatedelivery',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->estimatedelivery))'
     ),
	        array(
      'name'=>'dateofdelivery',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->dateofdelivery))'
     ),
array(
      'name'=>'dateofdeliverydevice',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->dateofdeliverydevice))'
     ),
	 array(
      'name'=>'installdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->installdate))'
     ),
	 array(
      'name'=>'onlinedate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->onlinedate))'
     ),
  ),
));
?>

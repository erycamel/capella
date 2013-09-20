<?php
$this->breadcrumbs=array(
	'Projectemps',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inemployeedatagrid',
	'dataProvider'=>$projectemp->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'spkno', 'type'=>'raw',
        'value'=>'($data->filename!==null)?CHtml::link($data->spkno,"document/".$data->filename):$data->spkno'),  
	array('name'=>'requestforid', 'value'=>'($data->requestfor!==null)?$data->requestfor->requestforname:""'),
	array('name'=>'employeeid', 'value'=>'($data->employee!==null)?$data->employee->fullname:""'),
        array(
      'name'=>'workdate',
      'type'=>'raw',
         'value'=>'($data->workdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->workdate)):""'
     ),
        array(
      'name'=>'workdateend',
      'type'=>'raw',
         'value'=>'($data->workdateend!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->workdateend)):""'
     ),	 
	array(
      'name'=>'uploaddate',
      'type'=>'raw',
         'value'=>'($data->uploaddate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->uploaddate)):""'
     ),
  ),
));
?>

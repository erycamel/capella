<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indocumentdatagrid',
	'dataProvider'=>$projectdocument->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'documentname', 'type'=>'raw',
        'value'=>'($data->filename!==null)?CHtml::link($data->documentname,"document/".$data->filename):$data->documentname'),  		
array(
      'name'=>'uploaddate',
      'type'=>'raw',
         'value'=>'($data->uploaddate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->uploaddate)):""'
     ),
  ),
));
?>

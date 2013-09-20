<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'insrftimedatagrid',
	'dataProvider'=>$srftime->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array('name'=>'wfstatus', 'value'=>'Wfstatus::model()->findbyattributes(array("workflowid"=>Workflow::model()->findbyattributes(array("wfname"=>"appproject"))->workflowid,"wfstat"=>$data->wfstatus))->wfstatusname'),
		array(
      'name'=>'srfdatetime',
      'type'=>'raw',
         'value'=>'($data->srfdatetime!==null)?date(Yii::app()->params["datetimeviewfromdb"], strtotime($data->srfdatetime)):""'
     ),
  ),
));
?>

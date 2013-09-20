<?php
$this->breadcrumbs=array(
	'Employees',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function refreshdata()
{
    $.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpdialog',
    'options'=>array(
        'title'=>'Help',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<?php echo $this->renderPartial('_help'); ?>
<?php $this->endWidget();?>
<h1>Employee Broadcasts</h1>
<div id="toolbar">
<?php
$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>Yii::t('app','refresh data')
));
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"$('#helpdialog').dialog('open');",
   'title'=>Yii::t('app','help')
));
?>Record/page <?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div>
<form name="input" action="employeebroadcast/sendmessage" method="post">
Messages: <input type="text" name="messages" />
<?php echo CHtml::ajaxSubmitButton('Submit',
		array('employeebroadcast/sendmessage'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("message").innerHTML = data;
			if (x.status == "success")
			{
			}
        }')); ?>
</form>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'employeeid', 'header'=>'ID','value'=>'$data->employeeid','htmlOptions'=>array('width'=>'1%')),
		array('name'=>'addressbookid', 'header'=>'Full Name','value'=>'$data->addressbook->fullname'),
		'oldnik',
		'newnik',
		array('name'=>'orgstructureid', 'header'=>'Structure','value'=>'$data->orgstructure->structurename'),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'addressbook.recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->addressbook->recordstatus'
    ),
	),
)); 
?>

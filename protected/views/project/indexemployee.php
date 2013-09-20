<?php
$this->breadcrumbs=array(
	'Projectemps',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata4()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('project/createemployee'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog4 div.divcreate1').html(data.div);
					$('#Projectemp_projectempid').val('');
					$('#Projectemp_employeeid').val('');
					$('#employee_name').val('');
					$('#Projectemp_workdate').val('');
					$('#Projectemp_workdateend').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog4').dialog('open');
                }
                else
                {
                    document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function editdata4()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/updateemployee'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("employeedatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog4 div.divcreate1').html(data.div);
					$('#Projectemp_projectempid').val(data.projectempid);
					$('#Projectemp_employeeid').val(data.employeeid);
					$('#employee_name').val(data.fullname);
					$('#Projectemp_workdate').val(data.workdate);
					$('#Projectemp_workdateend').val(data.workdateend);
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog4').dialog('open');
                }
                else
                {
                   document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function deletedata4()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/deletedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata4()
{
    $.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog4',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate1"></div>
<?php echo $this->renderPartial('_formemployee', array('model'=>$projectemp,'employee'=>$employee)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata4()}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata4()}",
));
$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($img1delete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata4()}",
));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(3)}",
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employeedatagrid',
	'dataProvider'=>$projectemp->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'projectempid', 'header'=>'ID','value'=>'$data->projectempid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'employeeid', 'value'=>'($data->employee!==null)?$data->employee->fullname:""','htmlOptions'=>array('width'=>'1%')),
        'workdate',
        'workdateend'
  ),
));
?>

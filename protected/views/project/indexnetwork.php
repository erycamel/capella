<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata6()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('project/createnetwork'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog6 div.divcreate7').html(data.div);
					$('#Projectnetwork_projectnetworkid').val('');
					$('#Projectnetwork_application').val('');
					$('#Projectnetwork_technology').val('');
					$('#Projectnetwork_upstream').val('');
					$('#Projectnetwork_downstream').val('');
					$('#Projectnetwork_accessmethodid').val('');
					$('#accessmethodname').val('');
					$('#Projectnetwork_originipaddress').val('');
					$('#Projectnetwork_destipaddress').val('');
					$('#Projectnetwork_originnetmask').val('');
					$('#Projectnetwork_destnetmask').val('');
                    $('#createdialog6').dialog('open');
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
function editdata6()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/updatenetwork'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("networkdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog6 div.divcreate7').html(data.div);
					$('#Projectnetwork_projectnetworkid').val(data.projectnetworkid);
					$('#Projectnetwork_application').val(data.application);
					$('#Projectnetwork_technology').val(data.technology);
					$('#Projectnetwork_upstream').val(data.upstream);
					$('#Projectnetwork_downstream').val(data.downstream);
					$('#Projectnetwork_accessmethodid').val(data.accessmethodid);
					$('#accessmethodname').val(data.accessmethodname);
					$('#Projectnetwork_originipaddress').val(data.originipaddress);
					$('#Projectnetwork_destipaddress').val(data.destipaddress);
					$('#Projectnetwork_originnetmask').val(data.originnetmask);
					$('#Projectnetwork_destnetmask').val(data.destnetmask);                    
					$('#createdialog6').dialog('open');
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
function deletedata6()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/deletedocument'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("networkdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	refreshdata6();
    return false;
}
</script>
<script type="text/javascript">
function refreshdata6()
{
    $.fn.yiiGridView.update('networkdatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog6',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate4"></div>
<?php echo $this->renderPartial('_formnetwork', array('model'=>$projectnetwork)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata6()}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata6()}",
));
$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($img1delete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata6()}",
));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(11)}",
));
?> <?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'networkdatagrid',
	'dataProvider'=>$projectnetwork->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
		'application',
		array('name'=>'technology', 'header'=>'Technology', 'value'=>'($data->accessmethod!==null)?$data->accessmethod->accessmethodname:""'),
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

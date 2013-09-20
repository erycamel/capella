<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata4()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('project/createlocation'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog4 div.divcreate5').html(data.div);
					$('#Projectlocation_projectlocationid').val('');
					$('#Projectlocation_originid').val('');
					$('#originname').val('');
					$('#Projectlocation_destid').val('');
					$('#destname').val('');
					$('#Projectlocation_originaddress').val('');
					$('#Projectlocation_destaddress').val('');
					$('#Projectlocation_origincityid').val('');
					$('#origincityname').val('');
					$('#Projectlocation_destcityid').val('');                          
					$('#destcityname').val('');                          
					$('#Projectlocation_originbuilding').val('');                          
					$('#Projectlocation_destbuilding').val('');                          
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
			'url'=>array('project/updatelocation'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("locationdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog4 div.divcreate5').html(data.div);
					$('#Projectlocation_projectlocationid').val(data.projectlocationid);
					$('#Projectlocation_originid').val(data.originid);
					$('#originname').val(data.originname);
					$('#Projectlocation_destid').val(data.destid);
					$('#destname').val(data.destname);
					$('#Projectlocation_originaddress').val(data.originaddress);
					$('#Projectlocation_destaddress').val(data.destaddress);
					$('#Projectlocation_origincityid').val(data.origincityid);
					$('#origincityname').val(data.origincityname);
					$('#Projectlocation_destcityid').val(data.destcityid);                          
					$('#destcityname').val(data.destcityname);                          
					$('#Projectlocation_originbuilding').val(data.originbuilding);                          
					$('#Projectlocation_destbuilding').val(data.destbuilding);                          
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
			'url'=>array('project/deletelocation'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("locationdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	refreshdata2();
    return false;
}
</script>
<script type="text/javascript">
function refreshdata4()
{
    $.fn.yiiGridView.update('locationdatagrid');
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
<div id="divcreate5"></div>
<?php echo $this->renderPartial('_formlocation', array('model'=>$projectlocation)); ?>
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
   'onclick'=>"{helpdata(7)}",
));
?> <?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'locationdatagrid',
	'dataProvider'=>$projectlocation->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
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

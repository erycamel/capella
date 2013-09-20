<?php
$this->breadcrumbs=array(
	'Projectrecs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata6()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('project/createprojectrec'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog6 div.divcreate1').html(data.div);
					$('#Projectrec_projectrecid').val('');
					$('#Projectrec_recdatestart').val('');
					$('#Projectrec_recdateend').val('');
					$('#Projectrec_disturb').val('');
					$('#Projectrec_location').val('');
					$('#Projectrec_note').val('');
                          // Here is the trick: on submit-> once again this function!
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
			'url'=>array('project/updateprojectrec'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("projectrecdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog6 div.divcreate1').html(data.div);
					$('#Projectrec_projectrecid').val(data.projectrecid);
					$('#Projectrec_recdatestart').val(data.recdatestart);
					$('#Projectrec_recdateend').val(data.recdateend);
					$('#Projectrec_disturb').val(data.disturb);
					$('#Projectrec_location').val(data.location);
					$('#Projectrec_note').val(data.note);
                          // Here is the trick: on submit-> once again this function!
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
function refreshdata6()
{
    $.fn.yiiGridView.update('detaildatagrid');
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
<div id="divcreate1"></div>
<?php echo $this->renderPartial('_formprojectrec', array('model'=>$projectrec,
                      'prorecdetail'=>$this->prorecdetail,
                      'prosubcategory'=>$this->prosubcategory,
                      'proreccategory'=>$this->proreccategory)); ?>
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
   'onclick'=>"{helpdata(3)}",
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'projectrecdatagrid',
	'dataProvider'=>$projectrec->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'projectrecid', 'value'=>'$data->projectrecid','htmlOptions'=>array('width'=>'1%')),
        'recdatestart',
        'recdateend',
	array('header'=>'Duration','value'=>'new DateTime($data->recdatestart)->diff($data->recdateend)'),
        'durasi',
        'disturb',
        'location',
        'note'
  ),
));
?>

<?php
$this->breadcrumbs=array(
	'Smsformats',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('smsformat/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messagediv').innerHTML = '';
                if (data.status == 'failure')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#yt0').val('Create');
					$('#Smsformat_smsformatid').val('');
					$('#Smsformat_smsname').val('');
					$('#Smsformat_description').val('');
					$('#Smsformat_formatin').val('');
					$('#Smsformat_formatout').val('');
					$('#Smsformat_execproc').val('');
					$('#Smsformat_formaterror').val('');
					$('#Smsformat_formatout').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog div.divcreate form').submit(adddata);
                }
                else
                {
                    $('#createdialog div.divcreate').html(data.div);
                    setTimeout(\"$('#createdialog').dialog('close') \",3000);
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function editdata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('smsformat/update'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messagediv').innerHTML = '';
                if (data.status == 'failure')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#yt0').val('Save');
					$('#Smsformat_smsformatid').val(data.smsformatid);
					$('#Smsformat_smsname').val(data.smsname);
					$('#Smsformat_description').val(data.description);
					$('#Smsformat_formatin').val(data.formatin);
					$('#Smsformat_formatout').val(data.formatout);
					$('#Smsformat_execproc').val(data.execproc);
					$('#Smsformat_formaterror').val(data.formaterror);
					$('#Smsformat_formatout').val(data.formatout);
					if (data.recordstatus == '1')
					{
					  document.forms[1].elements[8].checked=true;
					}
					else
					{
					  document.forms[1].elements[8].checked=false;
					}
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog div.divcreate form').submit(editdata);
                }
                else
                {
                    $('#createdialog div.divcreate').html(data.div);
                    setTimeout(\"$('#createdialog').dialog('close') \",3000);
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function deletedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('smsformat/delete'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata()
{
    $.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate"></div>
<?php echo $this->renderPartial('_form', array('model'=>$model,
	'absschedule'=>$absschedule,'absstatus'=>$absstatus)); ?>
<?php $this->endWidget();?>

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
<h1>Sms Formats</h1>
<div id="toolbar">
<?php
$imgcreate=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($imgcreate,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata(); $('#createdialog').dialog('open');
}",
	'title'=>'create new data'
));
$imgedit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($imgedit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata(); $('#createdialog').dialog('open');
}",
	'title'=>'edit selected data'
));
$imgup=CHtml::image(Yii::app()->request->baseUrl.'/images/up.png');
echo CHtml::link($imgup,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata(); $('#createdialog').dialog('open');}",
   'title'=>'upload data'
));
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata(); $('#createdialog').dialog('open');}",
   'title'=>'download selected data'
));
$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>'refresh data'
));
$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>'change status / purge selected data'
));
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"$('#helpdialog').dialog('open');",
   'title'=>'find any help of this module'
));
?>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'pagerCssClass'=>Yii::app()->request->baseUrl.'/css/pager.css',
	'pager'=>array(
	  'class'=>'CLinkPager',
	  'header'=>' Record/page '.CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ))
	),
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
		array('name'=>'smsformatid', 'value'=>'$data->smsformatid','htmlOptions'=>array('width'=>'1%')),
		'smsname',
		'description',
		'formatin',
		'formatout',
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->recordstatus'
    ),
	),
)); ?>

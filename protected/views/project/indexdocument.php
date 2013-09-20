<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata5()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('project/createdocument'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog5 div.divcreate6').html(data.div);
					$('#Projectdocument_projectdocumentid').val('');
					$('#Projectdocument_documentname').val('');
					$('#Projectdocument_filename').val('');
                    $('#createdialog5').dialog('open');
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
function editdata5()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/updatedocument'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("documentdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog5 div.divcreate6').html(data.div);
					$('#Projectdocument_projectdocumentid').val(data.projectdocumentid);
					$('#Projectdocument_documentname').val(data.documentname);
					$('#Projectdocument_filename').val(data.filename);
                    $('#createdialog5').dialog('open');
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
function deletedata5()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/deletedocument'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("documentdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	refreshdata5();
    return false;
}
</script>
<script type="text/javascript">
function refreshdata5()
{
    $.fn.yiiGridView.update('documentdatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog5',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate4"></div>
<?php echo $this->renderPartial('_formdocument', array('model'=>$projectdocument)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata5()}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata5()}",
));
$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($img1delete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata5()}",
));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(9)}",
));
?> <?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'documentdatagrid',
	'dataProvider'=>$projectdocument->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),	
	array('name'=>'documentname', 'type'=>'raw',
        'value'=>'($data->filename!==null)?CHtml::link($data->documentname,"document/".$data->filename):$data->documentname'),  		
  ),
));
?>

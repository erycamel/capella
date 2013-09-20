<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata3()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('project/createpic'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog3 div.divcreate4').html(data.div);
					$('#Projectpic_projectpicid').val('');
					$('#Projectpic_picname').val('');
					$('#Projectpic_picdept').val('');
					$('#Projectpic_picemail').val('');
					$('#Projectpic_pictelp').val('');
					$('#Projectpic_picfunction').val('');
                    $('#createdialog3').dialog('open');
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
function editdata3()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/updatepic'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("picdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog3 div.divcreate4').html(data.div);
					$('#Projectpic_projectpicid').val(data.projectpicid);
					$('#Projectpic_picname').val(data.picname);
					$('#Projectpic_picdept').val(data.picdept);
					$('#Projectpic_picemail').val(data.picemail);
					$('#Projectpic_pictelp').val(data.pictelp);
					$('#Projectpic_picfunction').val(data.picfunction);
                    $('#createdialog3').dialog('open');
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
function deletedata3()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/deletepic'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("picdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	refreshdata3();
    return false;
}
</script>
<script type="text/javascript">
function refreshdata3()
{
    $.fn.yiiGridView.update('picdatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog3',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate4"></div>
<?php echo $this->renderPartial('_formpic', array('model'=>$projectpic)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata3()}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata3()}",
));
$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($img1delete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata3()}",
));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(5)}",
));
?> <?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'picdatagrid',
	'dataProvider'=>$projectpic->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
		'picname',
		'picdept',
		'pictelp',
		'picemail',
		'picfunction'
  ),
));
?>

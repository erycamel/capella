<?php
$this->breadcrumbs=array(
	'Projectdocs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata2()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('project/createdocsurvey'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog2 div.divcreate1').html(data.div);
					$('#Prodocsurvey_prodocsurveyid').val('');
					$('#Prodocsurvey_documentname').val('');
					$('#Prodocsurvey_filename').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog2').dialog('open');
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
function editdata2()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/updatedocsurvey'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("docdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog2 div.divcreate1').html(data.div);
					$('#Prodocsurvey_projectdocid').val(data.projectdocid);
					$('#Prodocsurvey_documentname').val(data.documentname);
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog2').dialog('open');
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
function deletedata2()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/deletedocsurvey'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("docdatagrid")'),
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
function refreshdata2()
{
    $.fn.yiiGridView.update('docdatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog2',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate3"></div>
<?php echo $this->renderPartial('_formdoc', array('model'=>$prodocsurvey)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata2()}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata2()}",
));
$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($img1delete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata2()}",
));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(3)}",
));
?> <?php
$this->widget('ext.EAjaxUpload.EAjaxUpload',
                 array(
                       'id'=>'uploaddocsurvey',
                       'postParams'=>array('id'=>'js:$.fn.yiiGridView.getSelection("docdatagrid")'),
                       'config'=>array(
                                       'action'=>'index.php?r=project/uploaddocsurvey',
                                       'allowedExtensions'=>Yii::app()->params['allowedext'],
                                       'sizeLimit'=>(int)Yii::app()->params['sizeLimit'],
									   'onComplete'=>"js:function(id, fileName, responseJSON){ $.fn.yiiGridView.update('docdatagrid');  }",
                                       'messages'=>array(
                                                         'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                                         'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                                         'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                                         'emptyError'=>"{file} is empty, please select files again without it.",
                                                         'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                                        ),
                                       'showMessage'=>"js:function(message){ alert(message); }"
                                      )
                      ));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'docdatagrid',
	'dataProvider'=>$prodocsurvey->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'prodocsurveyid', 'header'=>'ID','value'=>'$data->prodocsurveyid','htmlOptions'=>array('width'=>'1%')),
array('name'=>'documentname', 'type'=>'raw',
        'value'=>'($data->filename!==null)?CHtml::link($data->documentname,"document/".$data->filename):$data->documentname',
        'header'=>'Document Name'),
	'uploaddate',
        'statusdate',
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->recordstatus'
    ),
  ),
));
?>

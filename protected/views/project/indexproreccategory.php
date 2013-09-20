<?php
$this->breadcrumbs=array(
	'Proreccategorys',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata7()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('project/createproreccategory'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog7 div.divcreate1').html(data.div);
					$('#Proreccategory_proreccategoryid').val('');
					$('#Proreccategory_proreccategoryid').val('');
					$('#proreccategory_name').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog7').dialog('open');
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
function editdata7()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('project/updateproreccategory'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("proreccategorydatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog7 div.divcreate1').html(data.div);
					$('#Proreccategory_proreccategoryid').val(data.proreccategoryid);
					$('#Proreccategory_proreccategoryid').val(data.proreccategoryid);
					$('#proreccategory_name').val(data.fullname);
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog7').dialog('open');
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
function deletedata7()
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
function refreshdata7()
{
    $.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog7',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate1"></div>
<?php echo $this->renderPartial('_formproreccategory', array('model'=>$proreccategory,'prosubcategory'=>$prosubcategory)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata7()}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata7()}",
));
$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($img1delete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata7()}",
));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(3)}",
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'proreccategorydatagrid',
	'dataProvider'=>$proreccategory->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'proreccategoryid', 'value'=>'$data->proreccategoryid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'prosubcategoryid', 'value'=>'($data->prosubcategory!==null)?$data->prosubcategory->procategory->procategoryname:""'),
	array('name'=>'prosubcategoryid', 'value'=>'($data->prosubcategory!==null)?$data->prosubcategory->prosubcategoryname:""'),
  ),
));
?>

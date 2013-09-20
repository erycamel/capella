<?php
$this->breadcrumbs=array(
	'Suppliercontacts',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata2()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('supplier/createcontact'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog2 div.divcreate2').html(data.div);
					$('#Suppliercontact_addresscontactid').val('');$('#Suppliercontact_contacttypeid').val('');$('#contacttype_name').val('');$('#Suppliercontact_addresscontactname').val('');
                    $('#Suppliercontact_phoneno').val('');
                    $('#Suppliercontact_mobilephone').val('');
                    $('#Suppliercontact_emailaddress').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog2').dialog('open');
                }
                else
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
                    setTimeout(\"$('#createdialog1').dialog('close') \",3000);
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
			'url'=>array('supplier/updatecontact'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("contactdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Suppliercontact_addresscontactid').val(data.addresscontactid);$('#Suppliercontact_contacttypeid').val(data.contacttypeid);$('#contacttype_name').val(data.contacttypename);$('#Suppliercontact_addresscontactname').val(data.addresscontactname);
                    $('#Suppliercontact_phoneno').val(data.phoneno);
                    $('#Suppliercontact_mobilephone').val(data.mobilephone);
                    $('#Suppliercontact_emailaddress').val(data.emailaddress);
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog2').dialog('open');
                }
                else
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
                    setTimeout(\"$('#createdialog1').dialog('close') \",3000);
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
			'url'=>array('supplier/deletecontact'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("contactdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('contactdatagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata1()
{
    $.fn.yiiGridView.update('contactdatagrid');
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
<div id="divcreate2"></div>
<?php echo $this->renderPartial('_formcontact', array('model'=>$suppliercontact)); ?>
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
   'onclick'=>"{helpdata(5)}",
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contactdatagrid',
	'dataProvider'=>$suppliercontact->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'addresscontactid', 'visible'=>false,'header'=>'ID','value'=>'$data->addresscontactid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'addressbookid', 'visible'=>false,'value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
array('name'=>'contacttypeid', 'value'=>'($data->contacttype!==null)?$data->contacttype->contacttypename:""'),
		'addresscontactname',
		'phoneno',
		'mobilephone',
		'emailaddress',
  ),
));
?>

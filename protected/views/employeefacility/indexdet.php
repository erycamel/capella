<?php
$this->breadcrumbs=array(
	'Employeefacilityaddresss',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('employeefacility/createdet'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Employeefacilitydet_facilitytypeid').val('');$('#facilitytypename').val('');
                    $('#Employeefacilitydet_startdate').val('');
                    $('#Employeefacilitydet_enddate').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1 div.divcreate1 form').submit(adddata1);
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
function editdata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('employeefacility/updatedet'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("employeefacilitydetdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Employeefacilitydet_employeefacilitydetid').val(data.employeefacilitydetid);
					$('#Employeefacilitydet_facilitytypeid').val(data.facilitytypeid);
                    $('#facilitytypename').val(data.facilitytypename);
                    $('#Employeefacilitydet_startdate').val(data.startdate);
                    $('#Employeefacilitydet_enddate').val(data.enddate);
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1 div.divcreate1 form').submit(editdata1);
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
function deletedata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('employeefacility/deletedet'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("employeefacilitydetdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('employeefacilitydetdatagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata1()
{
    $.fn.yiiGridView.update('employeefacilitydetdatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog1',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate1"></div>
<?php echo $this->renderPartial('_formdet', array('model'=>$employeefacilitydet)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata1(); $('#createdialog1').dialog('open');}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata1(); $('#createdialog1').dialog('open');}",
));
$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($img1delete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata1()}",
));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(3)}",
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'employeefacilitydetdatagrid',
	'dataProvider'=>$employeefacilitydet->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'addressid', 'visible'=>false,'header'=>'ID','value'=>'$data->addressid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'addressbookid', 'visible'=>false,'value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
array('name'=>'facilitytypeid', 'value'=>'($data->facilitytype!==null)?$data->facilitytype->facilitytypename:""'),
      array(
      'name'=>'startdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->startdate))'
     ),
       array(
      'name'=>'enddate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->enddate))'
     ),
  ),
));
?>

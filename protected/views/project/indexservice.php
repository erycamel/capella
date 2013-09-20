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
			'url'=>array('project/createservice'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog2 div.divcreate1').html(data.div);
					$('#Projectservice_projectserviceid').val('');
					$('#Projectservice_requestforid').val('');
					$('#requestforname').val('');
					$('#Projectservice_dateofdelivery').val('');
					$('#Projectservice_dateofdeliverydevice').val('');
					$('#Projectservice_estimatedelivery').val('');
					$('#Projectservice_onlinedate').val('');
					$('#Projectservice_installdate').val('');
					$('#Projectservice_contracttermid').val('');
					$('#contracttermname').val('');                          // Here is the trick: on submit-> once again this function!
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
			'url'=>array('project/updateservice'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("servicedatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog2 div.divcreate1').html(data.div);
					$('#Projectservice_projectserviceid').val(data.projectserviceid);
					$('#Projectservice_requestforid').val(data.requestforid);
					$('#requestforname').val(data.requestforname);
					$('#Projectservice_dateofdelivery').val(data.dateofdelivery);
					$('#Projectservice_dateofdeliverydevice').val(data.dateofdeliverydevice);
					$('#Projectservice_estimatedelivery').val(data.estimatedelivery);
					$('#Projectservice_onlinedate').val(data.onlinedate);
					$('#Projectservice_installdate').val(data.installdate);
					$('#Projectservice_contracttermid').val(data.contracttermid);
					$('#contracttermname').val(data.contracttermname);
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
			'url'=>array('project/deleteservice'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("servicedatagrid")'),
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
    $.fn.yiiGridView.update('servicedatagrid');
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
<?php echo $this->renderPartial('_formservice', array('model'=>$projectservice)); ?>
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
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'servicedatagrid',
	'dataProvider'=>$projectservice->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
		array('name'=>'requestforid', 'value'=>'($data->requestfor!==null)?$data->requestfor->requestforname:""'),
		array('name'=>'contracttermid', 'value'=>'($data->contractterm!==null)?$data->contractterm->contracttermname:""'),
		array(
      'name'=>'estimatedelivery',
      'type'=>'raw',
         'value'=>'($data->estimatedelivery!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->estimatedelivery)):""'
     ),
	        array(
      'name'=>'dateofdelivery',
      'type'=>'raw',
         'value'=>'($data->dateofdelivery!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->dateofdelivery)):""'
     ),
array(
      'name'=>'dateofdeliverydevice',
      'type'=>'raw',
         'value'=>'($data->dateofdeliverydevice!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->dateofdeliverydevice)):""'
     ),
	 array(
      'name'=>'installdate',
      'type'=>'raw',
         'value'=>'($data->installdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->installdate)):""'
     ),
	 array(
      'name'=>'onlinedate',
      'type'=>'raw',
         'value'=>'($data->onlinedate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->onlinedate)):""'
     ),
  ),
));
?>

<?php
$this->breadcrumbs=array(
	'Employeebenefits',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('employeebenefit/createdetail'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Employeebenefitdetail_employeebenefitdetailid').val('');
					$('#Employeebenefitdetail_wagetypeid').val('');
					$('#wagename').val('');
					$('#Employeebenefitdetail_startdate').val('');
					$('#Employeebenefitdetail_enddate').val('');
					$('#Employeebenefitdetail_reason').val('');
					$('#Employeebenefitdetail_amount').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
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
function editdata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('employeebenefit/updatedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Employeebenefitdetail_employeebenefitdetailid').val(data.employeebenefitdetailid);
					$('#Employeebenefitdetail_wagetypeid').val(data.wagetypeid);
					$('#wagename').val(data.wagename);
					$('#Employeebenefitdetail_startdate').val(data.startdate);
					$('#Employeebenefitdetail_enddate').val(data.enddate);
					$('#Employeebenefitdetail_reason').val(data.reason);
					$('#Employeebenefitdetail_amount').val(data.amount);
					if (data.isfinal == '1')
					{
					  document.forms[2].elements[10].checked=true;
					}
					else
					{
					  document.forms[2].elements[10].checked=false;
					}
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
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
function deletedata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('employeebenefit/deletedetail'),
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
function refreshdata1()
{
    $.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<script type="text/javascript">
function generatedata()
{
  jQuery.ajax({
        'url': '/smlive/index.php?r=employeebenefit/generatedetail',
        'data': {
            'id':$("#Employeebenefit_employeebenefitid").val(),
            'wagetypeid':$("#Employeebenefitdetail_wagetypeid").val()
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if(data.status=='failure') {
            document.getElementById('messages').innerHTML = data.div;
            } else {
              $("#Employeebenefitdetail_amount").val(data.amount);
              $("#Employeebenefitdetail_startdate").val(data.startdate);
              $("#Employeebenefitdetail_enddate").val(data.enddate);
            }
        },
        'cache': false
    });;
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
<?php echo $this->renderPartial('_formdetail', array('model'=>$employeebenefitdetail)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata1()}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata1()}",
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
	'id'=>'detaildatagrid',
	'dataProvider'=>$employeebenefitdetail->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'employeebenefitdetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->employeebenefitdetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'wagetypeid', 'value'=>'$data->wagetype->wagename'),
                array(
      'name'=>'startdate',
      'type'=>'raw',
         'value'=>'($data->startdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->startdate)):""'
     ),
                array(
      'name'=>'enddate',
      'type'=>'raw',
         'value'=>'($data->enddate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->enddate)):""'
     ),
        'reason',
                array(
      'name'=>'amount',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->amount)',
     ),
        array(
      'class'=>'CCheckBoxColumn',
      'name'=>'isfinal',
      'selectableRows'=>'0',
      'header'=>'Is Final',
      'checked'=>'$data->isfinal'
    ),
  ),
));
?>

<?php
$this->breadcrumbs=array(
	'Sodetails',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('soheader/createdetail'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Sodetail_sodetailid').val('');
					$('#Sodetail_productid').val('');
					$('#productname').val('');
					$('#Sodetail_unitofmeasureid').val('');
					$('#uomcode').val('');
					$('#Sodetail_qty').val('');
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
			'url'=>array('soheader/updatedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Sodetail_sodetailid').val(data.sodetailid);
					$('#Sodetail_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Sodetail_unitofmeasureid').val(data.unitofmeasureid);
					$('#uomcode').val(data.uomcode);
					$('#Sodetail_qty').val(data.quantity);
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
			'url'=>array('soheader/deletedetail'),
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
<?php echo $this->renderPartial('_formdetail', array('model'=>$sodetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
    'currency'=>$currency)); ?>
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
	'id'=>'detaildatagrid',
	'dataProvider'=>$sodetail->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'sodetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->sodetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid','value'=>'($data->product!==null)?$data->product->productname:""'),
	array(
      'name'=>'qty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
	array('name'=>'unitofmeasureid','value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
	array(
      'name'=>'price',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->price)',
     ),
	array('name'=>'currencyid','value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
	array(
      'name'=>'serviceqty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->serviceqty)',
     ),
	array('name'=>'serviceuomid','value'=>'($data->serviceuom!==null)?$data->serviceuom->uomcode:""'),
	array(
      'name'=>'serviceprice',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->serviceprice)',
     ),
	array('name'=>'servicecurrencyid','value'=>'($data->servicecurrency!==null)?$data->servicecurrency->currencyname:""'),
        'description'
  ),
));
?>

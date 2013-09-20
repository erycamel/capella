<?php
$this->breadcrumbs=array(
	'Pocdetails',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('pocheader/createdetail'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Pocdetail_pocdetailid').val('');
					$('#Pocdetail_productid').val('');
					$('#productname').val('');
					$('#Pocdetail_unitofmeasureid').val('');
					$('#uomcode').val('');
					$('#Pocdetail_qty').val('');
					$('#Pocdetail_price').val('');
					$('#Pocdetail_currencyid').val('');
					$('#currencyname').val('');
					$('#Pocdetail_serviceqty').val('');
					$('#Pocdetail_serviceuomid').val('');
					$('#serviceuomcode').val('');
					$('#Pocdetail_serviceprice').val('');
					$('#Pocdetail_servicecurrencyid').val('');
					$('#servicecurrencyname').val('');
					$('#Pocdetail_description').val('');
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
			'url'=>array('pocheader/updatedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Pocdetail_pocdetailid').val(data.pocdetailid);
					$('#Pocdetail_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Pocdetail_qty').val(data.qty);
					$('#Pocdetail_unitofmeasureid').val(data.unitofmeasureid);
					$('#uomcode').val(data.uomcode);
					$('#Pocdetail_price').val(data.price);
					$('#Pocdetail_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Pocdetail_serviceqty').val(data.serviceqty);
					$('#Pocdetail_serviceuomid').val(data.serviceuomid);
					$('#serviceuomcode').val(data.serviceuomcode);
					$('#Pocdetail_serviceprice').val(data.serviceprice);
					$('#Pocdetail_servicecurrencyid').val(data.servicecurrencyid);
					$('#servicecurrencyname').val(data.servicecurrencyname);
					$('#Pocdetail_description').val(data.description);
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
			'url'=>array('pocheader/deletedetail'),
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
<?php echo $this->renderPartial('_formdetail', array('model'=>$pocdetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
    'currency'=>$currency)); ?>
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
	'dataProvider'=>$pocdetail->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'pocdetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->pocdetailid','htmlOptions'=>array('width'=>'1%')),
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
	array('name'=>'currencyid','value'=>'($data->servicecurrency!==null)?$data->servicecurrency->currencyname:""'),
        'description'
  ),
));?>
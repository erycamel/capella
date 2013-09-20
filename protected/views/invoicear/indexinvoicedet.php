<?php
$this->breadcrumbs=array(
	'invoiceap',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$headerid=Yii::app()->user->getState('headerid',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('invoicear/createinvoicedet'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Invoicedet_invoicedetid').val('');
					$('#Invoicedet_productid').val('');
					$('#productname').val('');
					$('#Invoicedet_qty').val('');
					$('#Invoicedet_unitofmeasureid').val('');
					$('#pouomcode').val('');
					$('#Invoicedet_price').val('');
					$('#Invoicedet_currencyid').val(data.currencyid);
					$('#invdetcurrencyname').val(data.currencyname);
					$('#Invoicedet_rate').val('1');
					$('#Invoicedet_description').val('');
                          // Here is the trick: on submit-> once again this function!
                $('#createdialog1').dialog('open');
                }
            else {
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
			'url'=>array('invoicear/updateinvoicedet'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detail1datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Invoicedet_invoicedetid').val(data.invoicedetid);
					$('#Invoicedet_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Invoicedet_qty').val(data.qty);
					$('#Invoicedet_unitofmeasureid').val(data.unitofmeasureid);
					$('#uomcode').val(data.uomcode);
					$('#Invoicedet_price').val(data.price);
					$('#Invoicedet_currencyid').val(data.currencyid);
					$('#invdetcurrencyname').val(data.currencyname);
					$('#Invoicedet_rate').val(data.rate);
					$('#Invoicedet_description').val(data.description);
                          // Here is the trick: on submit-> once again this function!
                $('#createdialog1').dialog('open');
                }
            else {
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
			'url'=>array('invoicear/deleteinvoicedet'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detail1datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('detail1datagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata1()
{
    $.fn.yiiGridView.update('detail1datagrid');
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
<?php echo $this->renderPartial('_forminvoicedet', array('model'=>$invoicedet)); ?>
<?php $this->endWidget();?>
<?php
$this->widget('ToolbarButton',
	array('isCreate'=>true,'UrlCreate'=>'adddata1()',
	'isRefresh'=>true,'UrlRefresh'=>'refreshdata1()',
	'UrlDownload'=>'downloaddata1()',
	'isEdit'=>true,'UrlEdit'=>'editdata1()',
	'isDelete'=>true,'UrlDelete'=>'deletedata1()',
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('detail1datagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detail1datagrid',
	'dataProvider'=>$invoicedet->search(),
  'selectableRows'=>1,
  'filter'=>$invoicedet,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'invoicedetid', 'visible'=>false, 'header'=>'ID','value'=>'$data->invoicedetid','htmlOptions'=>array('width'=>'1%')),
array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
        array(
      'name'=>'qty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
        array(
      'name'=>'price',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->price,($data->currency!==null)?$data->currency->symbol:"")',
     ),
        array(
      'name'=>'taxid',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->qty*$data->price*$data->tax->taxvalue/100,($data->currency!==null)?$data->currency->symbol:"")',
     ),
        array(
      'name'=>'rate',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->rate)',
     ),
		array(
	  'header'=>'Total',
      'value'=>'Yii::app()->numberFormatter->formatCurrency(($data->qty*$data->price)+($data->qty*$data->price*$data->tax->taxvalue/100),($data->currency!==null)?$data->currency->symbol:"")',
      'type'=>'raw',	 
      ),
    'description',
  ),
));
?>

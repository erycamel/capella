<?php
$this->breadcrumbs=array(
	'Invoicepays',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('invoice/createdetail'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Invoicepay_invoicepayid').val('');
					$('#Invoicepay_accountid').val('');
					$('#account_name').val('');
					$('#Invoicepay_debet').val('');
					$('#Invoicepay_credit').val('');
					$('#Invoicepay_currencyid').val('');
					$('#currencyname').val('');
					$('#Invoicepay_projectid').val('');
					$('#projectno').val('');
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
			'url'=>array('invoice/updatedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Invoicepay_invoicepayid').val(data.invoicepayid);
					$('#Invoicepay_accountid').val(data.accountid);
					$('#account_name').val(data.accountname);
					$('#Invoicepay_debet').val(data.debet);
					$('#Invoicepay_credit').val(data.credit);
					$('#Invoicepay_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Invoicepay_projectid').val(data.projectid);
					$('#projectno').val(data.projectno);
					if (data.recordstatus == '1')
					{
					  $('#recordstatus').checked='checked';
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
function generatedata() {
	jQuery.ajax({
        'url': '/smlive/index.php?r=invoice/generatedetail',
        'data': {
            'productid': $('#Podetail_productid').val(),
            'supplierid': $('#Poheader_addressbookid').val(),
            'prmaterialid': $('#Podetail_prdetailid').val()
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if(data.status=='failure') {
            document.getElementById('messages').innerHTML = data.div;
            } else {
                $('#Podetail_productid').val(data.productid);
                $('#productname').val(data.productname);
                $('#Podetail_poqty').val(data.poqty);
                $('#Podetail_unitofmeasureid').val(data.unitofmeasureid);
                $('#uomcode').val(data.uomcode);
                $('#Podetail_slocid').val(data.slocid);
                $('#sloccode').val(data.description);
                $('#Podetail_underdelvtol').val(data.underdelvtol);
                $('#Podetail_overdelvtol').val(data.overdelvtol);
                $('#Podetail_prdetailid').val(data.prdetailid);
                $('#prno').val(data.prno);
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function deletedata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('invoice/deletedetail'),
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
<?php echo $this->renderPartial('_formdetail', array('model'=>$invoicemat)); ?>
<?php $this->endWidget();?>
<?php
//$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
//echo CHtml::link($img1create,'#',array(
//   'style'=>'cursor: pointer; text-decoration: underline;',
//   'onclick'=>"{adddata1()}",
//));
//$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
//echo CHtml::link($img1edit,'#',array(
//   'style'=>'cursor: pointer; text-decoration: underline;',
//   'onclick'=>"{editdata1()}",
//));
//$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
//echo CHtml::link($img1delete,'#',array(
//   'style'=>'cursor: pointer; text-decoration: underline;',
//   'onclick'=>"{deletedata1()}",
//));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(3)}",
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detaildatagrid',
	'dataProvider'=>$invoicemat->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'invoicepayid','visible'=>false, 'header'=>'ID','value'=>'$data->invoicepayid','htmlOptions'=>array('width'=>'1%')),
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
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->price)',
     ),
	array('name'=>'currencyid', 'value'=>'$data->currency->currencyname'),
  ),
));
?>

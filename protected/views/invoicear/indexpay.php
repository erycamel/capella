<?php
$this->breadcrumbs=array(
	'Invoices',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata2()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('invoice/createpay'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog2 div.divcreate2').html(data.div);
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
			'url'=>array('invoice/updatepay'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("invoicepaydatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog2 div.divcreate2').html(data.div);
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
			'url'=>array('invoice/deletepay'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("invoicepaydatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('invoicepaydatagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata2()
{
    $.fn.yiiGridView.update('invoicepaydatagrid');
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
<?php echo $this->renderPartial('_formpay', array('model'=>$invoicepay)); ?>
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
	'id'=>'invoicepaydatagrid',
	'dataProvider'=>$invoicepay->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'invoicepayid', 'header'=>'ID','value'=>'$data->invoicepayid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'accountid', 'header'=>'Account Code','value'=>'($data->account!==null)?$data->account->accountcode:""'),
	array('name'=>'accountid', 'header'=>'Account Name','value'=>'($data->account!==null)?$data->account->accountname:""'),
            array(
      'name'=>'debet',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->debet)',
     ),
            array(
      'name'=>'credit',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->credit)',
     ),
	array('name'=>'currencyid', 'value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
  ),
));
?>

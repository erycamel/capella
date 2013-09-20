<?php
$this->breadcrumbs=array(
	'Invoicear',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.autoNumeric.js" ></script>
<script type="text/javascript">
var inputConfig = {aSep:',', aNeg:'-', mDec:2, mRound:'S', mNum:30};
$(function() {
            $('#Invoice_amount').autoNumeric(inputConfig);
            $('#Invoice_rate').autoNumeric(inputConfig);
            $('#Invoicedet_qty').autoNumeric(inputConfig);
            $('#Invoicedet_price').autoNumeric(inputConfig);
            $('#Invoicedet_rate').autoNumeric(inputConfig);
            $('#Invoiceacc_debit').autoNumeric(inputConfig);
            $('#Invoiceacc_credit').autoNumeric(inputConfig);
            $('#Invoiceacc_currencyrate').autoNumeric(inputConfig);
        });	
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=invoicear/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Invoice_invoiceid').val(data.invoiceid);
                $('#Invoice_invoicedate').val('');
                $('#Invoice_poheaderid').val('');
                $('#pono').val('');
                $('#Invoice_invoiceno').val('');
                $('#Invoice_amount').val('');
                $('#Invoice_currencyid').val(data.currencyid);
                $('#currencyname').val(data.currencyname);
                $('#Invoice_rate').val('1');
                $('#Invoice_headernote').val('');
                $('#Invoice_taxid').val('');
                $('#taxcode').val('');
                $('#Invoice_paymentmethodid').val('');
                $('#paycode').val('');
                document.forms[2].elements[1].value = data.invoiceid;
                document.forms[3].elements[1].value = data.invoiceid;
                $.fn.yiiGridView.update('detail1datagrid', {
                    data: {
                        'Invoicedet[invoiceid]': data.invoiceid
                    }
                });
                $.fn.yiiGridView.update('detail2datagrid', {
                    data: {
                        'Invoiceacc[invoiceid]': data.invoiceid
                    }
                });
                $('#createdialog').dialog('open');
            }
            else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function editdata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=invoicear/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Invoice_invoiceid').val(data.invoiceid);
                $('#Invoice_invoicedate').val(data.invoicedate);
                $('#Invoice_invoiceno').val(data.invoiceno);
                $('#Invoice_soheaderid').val(data.soheaderid);
                $('#sono').val(data.sono);
                $('#Invoice_amount').val(data.amount);
                $('#Invoice_currencyid').val(data.currencyid);
                $('#currencyname').val(data.currencyname);
                $('#Invoice_rate').val(data.rate);
                $('#Invoice_headernote').val(data.headernote);
                $('#Invoice_taxid').val(data.taxid);
                $('#taxcode').val(data.taxcode);
                $('#Invoice_paymentmethodid').val(data.paymentmethodid);
                $('#paycode').val(data.paycode);
                 document.forms[2].elements[1].value = data.invoiceid;
                 document.forms[3].elements[1].value = data.invoiceid;
               $.fn.yiiGridView.update('detail1datagrid', {
                    data: {
                        'Invoicedet[invoiceid]': data.invoiceid
                    }
                });
               $.fn.yiiGridView.update('detail2datagrid', {
                    data: {
                        'Invoiceacc[invoiceid]': data.invoiceid
                    }
                });
                $('#createdialog').dialog('open');
            }
            else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=invoicear/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function approvedata()
{jQuery.ajax({'url':'/smlive/index.php?r=invoicear/approve','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json',
'success':function(data) {
if (data.status == 'failure')
                {
                document.getElementById('messages').innerHTML = data.div;
            }},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
    jQuery.ajax({
        'url': '/smlive/index.php?r=invoicear/help',
        'data': {
            'id': value
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if (data.status == 'success') {
				document.getElementById('divhelp').innerHTML = data.div;
                $('#helpdialog').dialog('open');
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=invoicear/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('indetaildatagrid', {
                    data: {
                        'Invoicedet[invoiceid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    $.fn.yiiGridView.update('indetailaccdatagrid', {
                    data: {
                        'Invoiceacc[invoiceid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function generatedata() {
	jQuery.ajax({
        'url': '/smlive/index.php?r=invoicear/generatedetail',
        'data': {
            'id': $('#Invoice_soheaderid').val(),
            'hid': $('#Invoice_invoiceid').val()
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if(data.status=='failure') {
            document.getElementById('messages').innerHTML = data.div;
            }
            else 
            {
             $('#Invoice_addressbookid').val(data.addressbookid);
              $('#fullname').val(data.fullname);
              $('#Invoice_paymentmethodid').val(data.paymentmethodid);
              $('#paycode').val(data.paycode);
              $('#Invoice_amount').val(data.amount);
            }
            $.fn.yiiGridView.update("detail1datagrid");
        },
        'cache': false
    });;
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate"></div>
<?php echo $this->renderPartial('_form', array('model'=>$model,
'invoiceacc'=>$invoiceacc,
'invoicedet'=>$invoicedet
)); ?>
<?php $this->endWidget();?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpdialog',
    'options'=>array(
        'title'=>'Help',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divhelp"></div>
<?php $this->endWidget();?>
<h1>Transaction: Invoice to Customer</h1>
<div id="toolbar">
<ul>
<?php
$imgcreate=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgcreate,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata()}",
	'title'=>Yii::t('app','create data')
));
echo CHtml :: closeTag('li');

$imgedit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgedit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata()}",
	'title'=>Yii::t('app','edit data')
));
echo CHtml :: closeTag('li');

$imgapprove=CHtml::image(Yii::app()->request->baseUrl.'/images/approve.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgapprove,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{approvedata()}",
   'title'=>Yii::t('app','approve data')
));
echo CHtml :: closeTag('li');

$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>Yii::t('app','delete data')
));
echo CHtml :: closeTag('li');

$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
    'onclick'=>"{downloaddata()}",
   'title'=>Yii::t('app','download data')
));
echo CHtml :: closeTag('li');

$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>Yii::t('app','refresh data')
));
echo CHtml :: closeTag('li');

$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml :: openTag('li');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(1)}",
   'title'=>Yii::t('app','help')
));
echo CHtml :: closeTag('li');
?>
<div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></ul></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->Searchwfarstatus(),
	'filter'=>$model,
    'selectableRows'=>1,
	'selectionChanged'=>'showdetail',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'invoiceid', 'visible'=>false,'header'=>'ID','value'=>'$data->invoiceid','htmlOptions'=>array('width'=>'1%')),
	'invoiceno',
	array(
      'name'=>'invoicedate',
      'type'=>'raw',
         'value'=>'($data->invoicedate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->invoicedate)):""'
     ),
	array('name'=>'soheaderid', 'value'=>'($data->soheader!==null)?$data->soheader->sono:""'),
	        array(
      'name'=>'customer',
      'type'=>'raw',
         'value'=>'($data->soheader!==null)?($data->soheader->customer!==null)?$data->soheader->customer->fullname:"":""',
     ),
        array(
      'name'=>'amount',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->amount,($data->currency!==null)?$data->currency->symbol:"")',
     ),
	 array(
      'name'=>'tax',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->amount*(($data->tax!==null)?$data->tax->taxvalue:0)/100,($data->currency!==null)?$data->currency->symbol:"")',
     ),
	 array(
      'header'=>'Total',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency(($data->amount*(($data->tax!==null)?$data->tax->taxvalue:0)/100)+($data->amount),($data->currency!==null)?$data->currency->symbol:"")',
     ),
        array(
      'name'=>'rate',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->rate)',
     ),
	'headernote',
		array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appinvar",$data->recordstatus)')
  ),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indetaildatagrid',
	'dataProvider'=>$invoicedet->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
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
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indetailaccdatagrid',
	'dataProvider'=>$invoiceacc->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'invoiceaccid', 'visible'=>false, 'header'=>'ID','value'=>'$data->invoiceaccid','htmlOptions'=>array('width'=>'1%')),
array('name'=>'accountid', 'value'=>'($data->account!==null)?$data->account->accountname:""'),
        	array(
	  'header'=>'Debit',
'value'=>'Yii::app()->numberFormatter->formatCurrency($data->debit,($data->currency!==null)?$data->currency->symbol:"")',
      'type'=>'raw',	 
	  'footer'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$invoiceacc->getTotalDebit())     
      ),
        	array(
	  'header'=>'Credit',
'value'=>'Yii::app()->numberFormatter->formatCurrency($data->credit,($data->currency!==null)?$data->currency->symbol:"")',
      'type'=>'raw',	 
	  'footer'=>Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$invoiceacc->getTotalCredit())     
      ),
        array(
      'name'=>'currencyrate',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->currencyrate)',
     ),
	 'description'
  ),
));
?>
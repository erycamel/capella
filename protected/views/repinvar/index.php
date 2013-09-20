<?php
$this->breadcrumbs=array(
	'repinvars',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
    jQuery.ajax({
        'url': '/smlive/index.php?r=repinvar/help',
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
	window.open('/smlive/index.php?r=repinvar/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
	'dataProvider'=>$model->Searcharstatus(),
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
         'value'=>'($data->invoicedate!==null)?date(Yii::app()->params["dateviewfromdb"], 
		 strtotime($data->invoicedate)):""'
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
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->qty*$data->price*(($data->tax!==null)?$data->tax->taxvalue:0)/100,($data->currency!==null)?$data->currency->symbol:"")',
     ),
        array(
      'name'=>'rate',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->rate)',
     ),
		array(
	  'header'=>'Total',
      'value'=>'Yii::app()->numberFormatter->formatCurrency(($data->qty*$data->price)+($data->qty*$data->price*(($data->tax!==null)?$data->tax->taxvalue:0)/100),($data->currency!==null)?$data->currency->symbol:"")',
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
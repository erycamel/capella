<?php
$this->breadcrumbs=array(
	'Cashbankars',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.autoNumeric.js" ></script>
<script type="text/javascript">
var inputConfig = {aSep:',', aNeg:'-', mDec:2, mRound:'S', mNum:30};
$(function() {
            $('#Cashbank_amount').autoNumeric(inputConfig);
            $('#Cashbank_currencyrate').autoNumeric(inputConfig);
            $('#Cashbankacc_debit').autoNumeric(inputConfig);
            $('#Cashbankacc_credit').autoNumeric(inputConfig);
            $('#Cashbankacc_currencyrate').autoNumeric(inputConfig);
        });	
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=cashbankout/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Cashbank_cashbankid').val(data.cashbankid);
                $('#Cashbank_transdate').val('');
                $('#Cashbank_invoiceid').val('');
                $('#invoiceno').val('');
                $('#Cashbank_amount').val('');
                $('#Cashbank_currencyid').val(data.currencyid);
                $('#currencyname').val(data.currencyname);
				$('#Cashbank_accountid').val('');
                $('#accountname').val('');
                $('#Cashbank_currencyrate').val('1');
                $('#Cashbank_description').val('');
                document.forms[2].elements[1].value = data.cashbankid;
                $.fn.yiiGridView.update('detail2datagrid', {
                    data: {
                        'Cashbankacc[cashbankid]': data.cashbankid
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
        'url': '/smlive/index.php?r=cashbankout/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Cashbank_cashbankid').val(data.cashbankid);
                $('#Cashbank_transdate').val(data.transdate);
                $('#Cashbank_invoiceid').val(data.invoiceid);
                $('#invoiceno').val(data.invoiceno);
                $('#Cashbank_amount').val(data.amount);
                $('#Cashbank_currencyid').val(data.currencyid);
                $('#currencyname').val(data.currencyname);
				$('#Cashbank_accountid').val(data.accountid);
                $('#accountname').val(data.accountname);
                $('#Cashbank_currencyrate').val(data.currencyrate);
                $('#Cashbank_description').val(data.description);
                document.forms[2].elements[1].value = data.cashbankid;
                $.fn.yiiGridView.update('detail2datagrid', {
                    data: {
                        'Cashbankacc[cashbankid]': data.cashbankid
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
{jQuery.ajax({'url':'/smlive/index.php?r=cashbankout/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function approvedata()
{jQuery.ajax({'url':'/smlive/index.php?r=cashbankout/approve','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json',
'success':function(data)
{
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
        'url': '/smlive/index.php?r=cashbankout/help',
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
	window.open('/smlive/index.php?r=cashbankout/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('indetailaccdatagrid', {
                    data: {
                        'Cashbankacc[cashbankid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
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
'cashbankacc'=>$cashbankacc
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
<h1>Transaction: Cash / Bank Payment</h1>
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
	'dataProvider'=>$model->Searchwfoutstatus(),
	'filter'=>$model,
    'selectableRows'=>1,
	'selectionChanged'=>'showdetail',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'cashbankoutid', 'visible'=>false,'header'=>'ID','value'=>'$data->cashbankoutid','htmlOptions'=>array('width'=>'1%')),
	'cashbankno',
	array(
      'name'=>'transdate',
      'type'=>'raw',
         'value'=>'($data->transdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->transdate)):""'
     ),
	array('name'=>'invoiceid', 'value'=>'($data->invoice!==null)?$data->invoice->invoiceno:""'),
	array('name'=>'accountid', 'value'=>'($data->account!==null)?$data->account->accountname:""'),
        array(
      'name'=>'amount',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->amount,($data->currency!==null)?$data->currency->symbol:"")',
     ),
        array(
      'name'=>'currencyrate',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->currencyrate)',
     ),
	'description',
		array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appcbout",$data->recordstatus)')
  ),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indetailaccdatagrid',
	'dataProvider'=>$cashbankacc->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'cashbankaccid', 'visible'=>false, 'header'=>'ID','value'=>'$data->cashbankaccid','htmlOptions'=>array('width'=>'1%')),
array('name'=>'accountid', 'value'=>'($data->account!==null)?$data->account->accountname:""'),
array('name'=>'currencyid', 'value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
        array(
      'name'=>'debit',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->debit,($data->currency!==null)?$data->currency->symbol:"")',
     ),
        array(
      'name'=>'credit',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->credit,($data->currency!==null)?$data->currency->symbol:"")',
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
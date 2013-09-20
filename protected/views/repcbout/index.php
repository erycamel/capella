<?php
$this->breadcrumbs=array(
	'Cashbankars',
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
        'url': '/smlive/index.php?r=repcbout/help',
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
	window.open('/smlive/index.php?r=repcbout/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
<h1>Report: Cash / Bank Payment</h1>
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
	'dataProvider'=>$model->Searchoutstatus(),
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
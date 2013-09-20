<?php
$this->breadcrumbs=array(
	'Poheaders',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.autoNumeric.js" ></script>
<script type="text/javascript">
var inputConfig = {aSep:',', aNeg:'-', mDec:2, mRound:'S', mNum:30};
$(function() {
            $('#Podetail_netprice').autoNumeric(inputConfig);
            $('#Podetail_ratevalue').autoNumeric(inputConfig);
            $('#Podetail_poqty').autoNumeric(inputConfig);
        });	
function adddata()
{jQuery.ajax({'url':'/nwilive/index.php?r=poheader/create','data':$(this).serialize(),'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);					$('#Poheader_poheaderid').val(data.poheaderid);
					$('#Podetail_poheaderid').val(data.poheaderid);
					$('#Poheader_pono').val('');
					$('#Poheader_headernote').val('');
					$('#Poheader_postdate').val('');
					$('#Poheader_docdate').val('');
					$('#Poheader_purchasingorgid').val('');
					$('#purchasingorgcode').val('');
					$('#Poheader_purchasinggroupid').val('');
					$('#purchasinggroupcode').val('');
					$('#Poheader_addressbookid').val('');
					$('#fullname').val('');
					$('#Poheader_paymentmethodid').val('');
					$('#paycode').val('');
					document.forms[2].elements[1].value=data.poheaderid;
$.fn.yiiGridView.update('detaildatagrid',{data:{'Podetail[poheaderid]':data.poheaderid}});
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function editdata()
{jQuery.ajax({'url':'/nwilive/index.php?r=poheader/update','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Poheader_poheaderid').val(data.poheaderid);
					$('#Poheader_pono').val(data.pono);
					$('#Poheader_headernote').val(data.headernote);
					$('#Poheader_postdate').val(data.postdate);
					$('#Poheader_docdate').val(data.docdate);
					$('#Poheader_purchasingorgid').val(data.purchasingorgid);
					$('#purchasingorgcode').val(data.purchasingorgcode);
					$('#Poheader_purchasinggroupid').val(data.purchasinggroupid);
					$('#purchasinggroupcode').val(data.purchasinggroupcode);
					$('#Poheader_addressbookid').val(data.addressbookid);
					$('#fullname').val(data.fullname);
					$('#Poheader_paymentmethodid').val(data.paymentmethodid);
					$('#paycode').val(data.paycode);
					if (data.recordstatus == '1')
					{
					  document.forms[1].elements[12].checked=true;
					}
					else
					{
					  document.forms[1].elements[12].checked=false;
					}
					document.forms[2].elements[1].value=data.poheaderid;
	$.fn.yiiGridView.update('detaildatagrid',{data:{'Podetail[poheaderid]':data.poheaderid}});
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function deletedata()
{jQuery.ajax({'url':'/nwilive/index.php?r=poheader/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function approvedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('poheader/approve'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
if (data.status == 'failure')
                {
                document.getElementById('messages').innerHTML = data.div;
            }
            } ",
            ))?>;
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata()
{
    $.fn.yiiGridView.update('datagrid');
    $.fn.yiiGridView.update('indatagrid');
    return false;
}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/nwilive/index.php?r=poheader/help',
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
function showdetail() {
    $.fn.yiiGridView.update('indatagrid', {
                    data: {
                        'Podetail[poheaderid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/nwilive/index.php?r=poheader/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
				  'purchasingorg'=>$purchasingorg,
				  'purchasinggroup'=>$purchasinggroup,
    'paymentmethod'=>$paymentmethod,
				  'supplier'=>$supplier,
				  'podetail'=>$podetail,
				  'prheader'=>$prheader,
				  'product'=>$product,
				  'unitofmeasure'=>$unitofmeasure,
				  'currency'=>$currency,
				  'sloc'=>$sloc,
				  'tax'=>$tax)); ?>
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
<h1>Transaction: Purchase Orders</h1>
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
	'dataProvider'=>$model->searchwfstatus(),
	'filter'=>$model,
    'selectionChanged'=>'showdetail',
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'poheaderid','visible'=>false, 'header'=>'ID','value'=>'$data->poheaderid','htmlOptions'=>array('width'=>'1%')),
		'pono',
                array(
      'name'=>'docdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->docdate))'
     ),		
	array('name'=>'purchasinggroupid', 'value'=>'($data->purchasinggroup!==null)?$data->purchasinggroup->description:""'),
	array('name'=>'addressbookid', 'value'=>'($data->supplier!==null)?$data->supplier->fullname:""'),
		'headernote',
	array('name'=>'paymentmethodid', 'value'=>'($data->paymentmethod!==null)?$data->paymentmethod->paycode:""'),
	array('name'=>'recordstatus','header'=>'Status','value'=>'Wfstatus::model()->findstatusname("apppo",$data->recordstatus)')
  ),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$podetail->search(),
	'columns'=>array(
	array('name'=>'podetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->podetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'prdetailid', 'value'=>'($data->prdetail!==null)?(($data->prdetail->prheader!==null)?$data->prdetail->prheader->prno:""):""','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
        array(
      'name'=>'poqty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->poqty)',
     ),
	array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
        array(
      'name'=>'netprice',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->netprice,($data->currency!==null)?$data->currency->symbol:"")',
     ),
	array('name'=>'taxid', 'value'=>'($data->tax!==null)?Yii::app()->numberFormatter->formatCurrency($data->tax->taxvalue*$data->poqty*$data->netprice/100,($data->currency!==null)?$data->currency->symbol:""):"0"'),
            'underdelvtol',
            'overdelvtol',
			array(
      'name'=>'delvdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->delvdate))'
     ),         
	 array(
	  'header'=>'Total',
      'value'=>'Yii::app()->numberFormatter->formatCurrency(($data->poqty*$data->netprice)+($data->tax->taxvalue * $data->poqty*$data->netprice / 100),($data->currency!==null)?$data->currency->symbol:"")',
      'type'=>'raw',	 
      ),
			'itemtext'
  ),
));
?>

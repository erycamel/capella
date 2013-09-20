<?php
$this->breadcrumbs=array(
	'Reportpos',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=reportpo/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');$.fn.yiiGridView.update('indatagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=reportpo/help',
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
	window.open('/smlive/index.php?r=reportpo/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
<h1>Report: Purchase Order</h1>
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
	'dataProvider'=>$model->search(),
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
	array('name'=>'purchasinggroupid', 'value'=>'($data->purchasinggroup!==null)?$data->purchasinggroup->description:""'),
	array('name'=>'addressbookid', 'value'=>'($data->supplier!==null)?$data->supplier->fullname:""'),
		'headernote',
                array(
      'name'=>'docdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->docdate))'
     ),		
	array('name'=>'paymentmethodid', 'value'=>'($data->paymentmethod!==null)?$data->paymentmethod->paycode:""'),
	array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("apppo",$data->recordstatus)')
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
		 'htmlOptions'=>array('class'=>'ratakanan'),
      'name'=>'poqty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->poqty)',
     ),
	 array(
		 'htmlOptions'=>array('class'=>'ratakanan'),
      'name'=>'qtyres',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qtyres)',
     ),
	array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
        array(
		 'htmlOptions'=>array('class'=>'ratakanan'),
      'name'=>'netprice',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->formatCurrency($data->netprice,($data->currency!==null)?$data->currency->symbol:"")',
     ),
	array('name'=>'taxid',  'htmlOptions'=>array('class'=>'ratakanan'),
	'value'=>'($data->tax!==null)?Yii::app()->numberFormatter->formatCurrency($data->tax->taxvalue*$data->poqty*$data->netprice/100,($data->currency!==null)?$data->currency->symbol:""):"0"'),
            'underdelvtol',
            'overdelvtol',
			array(
      'name'=>'delvdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->delvdate))'
     ),         
	 array(
	  'htmlOptions'=>array('class'=>'ratakanan'),
	  'header'=>'Total',
      'value'=>'Yii::app()->numberFormatter->formatCurrency(($data->poqty*$data->netprice)+($data->tax->taxvalue * $data->poqty*$data->netprice / 100),($data->currency!==null)?$data->currency->symbol:"")',
      'type'=>'raw',	 
      ),
			'itemtext'
  ),
));
?>

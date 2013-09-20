<?php
$this->breadcrumbs=array(
	'Report So',
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
        'url': '/smlive/index.php?r=reportso/help',
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
                        'Sodetail[soheaderid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=reportso/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
<h1>Report: Sales Order</h1><div id="toolbar">
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
	array('name'=>'soheaderid','visible'=>false, 'header'=>'ID','value'=>'$data->soheaderid','htmlOptions'=>array('width'=>'1%')),
		'sono',
                array(
      'name'=>'sodate',
      'type'=>'raw',
         'value'=>'($data->sodate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->sodate)):""'
     ),		
	array('name'=>'addressbookid', 'value'=>'($data->customer!==null)?$data->customer->fullname:""'),
	array('name'=>'paymentmethodid', 'value'=>'($data->paymentmethod!==null)?$data->paymentmethod->paycode:""'),
	array('name'=>'employeeid', 'value'=>'($data->employee!==null)?$data->employee->fullname:""'),
	array(
      'name'=>'startdate',
      'type'=>'raw',
         'value'=>'($data->startdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->startdate)):""'
     ),		
	 array(
      'name'=>'enddate',
      'type'=>'raw',
         'value'=>'($data->enddate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->enddate)):""'
     ),		
		'headernote',
	array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appso",$data->recordstatus)')
  ),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$sodetail->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'sodetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->sodetailid','htmlOptions'=>array('width'=>'1%')),
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
      'name'=>'currencyrate',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->currencyrate)',
     ),
	array('name'=>'taxid', 'value'=>'Yii::app()->numberFormatter->formatCurrency(($data->qty*$data->price*($data->tax!==null)?$data->tax->taxvalue:0/100),($data->currency!==null)?$data->currency->symbol:"")'),
            'itemnote',
			array(
	  'header'=>'Total',
      'value'=>'Yii::app()->numberFormatter->formatCurrency(($data->qty*$data->price)+($data->qty*$data->price*($data->tax!==null)?$data->tax->taxvalue:0/100),($data->currency!==null)?$data->currency->symbol:"")',
      'type'=>'raw',	 
      ),
  ),
));
?>
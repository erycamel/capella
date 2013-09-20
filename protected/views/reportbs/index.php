<?php
$this->breadcrumbs=array(
	'Bsheaders',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('indatagrid', {
                    data: {
                        'Bsdetail[bsheaderid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function helpdata(value) {
    jQuery.ajax({
        'url': '/smlive/index.php?r=bsheader/help',
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
	window.open('/smlive/index.php?r=reportbs/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
<h1>Report: Tools Stock</h1>
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
	'dataProvider'=>$model->Search(),
	'filter'=>$model,
  'selectableRows'=>1,
    'selectionChanged'=>'showdetail',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'bsheaderid', 'visible'=>false,'header'=>'ID','value'=>'$data->bsheaderid','htmlOptions'=>array('width'=>'1%')),
        array(
      'name'=>'bsdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->bsdate))'
     ),
	 'headernote',
    	array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appbs",$data->recordstatus)'),
  ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$bsdetail->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'bsdetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->bsdetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
	array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
	        array(
      'name'=>'quantity',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->quantity)',
     ),
	array('name'=>'slocid', 'value'=>'($data->sloc!==null)?$data->sloc->description:""'),
	'itemnote',
	'pono',
	'productcode',
	        array(
      'name'=>'buyprice',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->buyprice)',
     ),
	array('name'=>'currencyid', 'value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
	array(
      'name'=>'buydate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->buydate))'
     ),
	 'serialno',
	array('name'=>'ownershipid', 'value'=>'($data->ownership!==null)?$data->ownership->ownershipname:""'),
  ),
));
?>

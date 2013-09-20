<?php
$this->breadcrumbs=array(
	'Deliveryadvices',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.autoNumeric.js" ></script>
<script type="text/javascript">
var inputConfig = {aSep:',', aNeg:'-', mDec:2, mRound:'S', mNum:30};
$(function() {
            $('#Deliveryadvicedetail_qty').autoNumeric(inputConfig);
        });	function refreshdata()
{$.fn.yiiGridView.update('datagrid');$.fn.yiiGridView.update('indatagrid');return false;}
</script>
<script type="text/javascript">
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=deliveryadvice/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
					$('#Deliveryadvice_deliveryadviceid').val(data.deliveryadviceid);
					$('#Deliveryadvice_dadate').val('');
					$('#Deliveryadvice_dano').val('');
					$('#Deliveryadvice_headernote').val('');
					$('#Deliveryadvice_slocid').val('');
					$('#description').val('');
                document.forms[2].elements[1].value = data.deliveryadviceid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Deliveryadvicedetail[deliveryadviceid]': data.deliveryadviceid
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
        'url': '/smlive/index.php?r=deliveryadvice/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                					$('#Deliveryadvice_deliveryadviceid').val(data.deliveryadviceid);
					$('#Deliveryadvice_dano').val(data.dano);
                                        $('#Deliveryadvice_dadate').val(data.dadate);
					$('#Deliveryadvice_headernote').val(data.headernote);
					$('#Deliveryadvice_slocid').val(data.slocid);
					$('#description').val(data.description);
					if (data.recordstatus == '1')
					{
					  document.forms[1].elements[3].checked=true;
					}
					else
					{
					  document.forms[1].elements[3].checked=false;
					}
                document.forms[2].elements[1].value = data.deliveryadviceid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Deliveryadvicedetail[deliveryadviceid]': data.deliveryadviceid
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
{jQuery.ajax({'url':'/smlive/index.php?r=deliveryadvice/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;refreshdata();return false;}
</script>
<script type="text/javascript">
function approvedata()
{jQuery.ajax({'url':'/smlive/index.php?r=deliveryadvice/approve','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json',
        'success':function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'failure') {
                document.getElementById('messages').innerHTML = data.div;
            }
        },'cache':false});;refreshdata();return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
    jQuery.ajax({
        'url': '/smlive/index.php?r=deliveryadvice/help',
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
                        'Deliveryadvicedetail[deliveryadviceid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=deliveryadvice/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
					'deliveryadvicedetail'=>$deliveryadvicedetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'requestedby'=>$requestedby,
    'project'=>$project)); ?>
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
<h1>Transaction: Form Request (goods/service/delivery)</h1>
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
	'dataProvider'=>$model->Searchwfstatus(),
    'selectionChanged'=>'showdetail',
	'filter'=>$model,
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'deliveryadviceid', 'visible'=>false,'header'=>'ID','value'=>'$data->deliveryadviceid','htmlOptions'=>array('width'=>'1%')),
		array(
      'name'=>'dadate',
      'type'=>'raw',
         'value'=>'($data->dadate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->dadate)):""'
     ),  
		'dano',
		'headernote',
        	array('name'=>'slocid', 'value'=>'($data->sloc!==null)?$data->sloc->description:""'),
        	array('name'=>'useraccessid', 'value'=>'($data->useraccess!==null)?$data->useraccess->username:""'),
	array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appda",$data->recordstatus)'),
  ),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$deliveryadvicedetail->Search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
            array('name'=>'deliveryadvicedetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->deliveryadvicedetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
	 array(
      'name'=>'qty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
	array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
	array('name'=>'requestedbyid', 'value'=>'($data->requestedby!==null)?$data->requestedby->description:""'),
        array(
      'name'=>'reqdate',
      'type'=>'raw',
         'value'=>'($data->reqdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->reqdate)):""'
     ),            
            'itemtext'
  ),
));
?>
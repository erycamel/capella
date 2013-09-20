<?php
$this->breadcrumbs=array(
	'Prheaders',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.autoNumeric.js" ></script>
<script type="text/javascript">
var inputConfig = {aSep:',', aNeg:'-', mDec:2, mRound:'S', mNum:30};
$(function() {
            $('#Prmaterial_qty').autoNumeric(inputConfig);
        });	
function refreshdata()
{$.fn.yiiGridView.update('datagrid');$.fn.yiiGridView.update('indatagrid');return false;}
</script>
<script type="text/javascript">
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=prheader/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
					$('#Prheader_prheaderid').val(data.prheaderid);
					$('#Prheader_prdate').val('');
					$('#Prheader_prno').val('');
					$('#Prheader_slocid').val('');
					$('#sloccode').val('');
					$('#Prheader_deliveryadviceid').val('');
					$('#dano').val('');
					$('#Prheader_headernote').val('');
                document.forms[2].elements[1].value = data.prheaderid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Prmaterial[prheaderid]': data.prheaderid
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
        'url': '/smlive/index.php?r=prheader/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                					$('#Prheader_prheaderid').val(data.prheaderid);
					$('#Prheader_prno').val(data.prno);
                                        $('#Prheader_prdate').val(data.prdate);
					$('#Prheader_headernote').val(data.headernote);
					$('#Prheader_slocid').val(data.slocid);
					$('#sloccode').val(data.sloccode);
						$('#Prheader_deliveryadviceid').val(data.deliveryadviceid);
					$('#dano').val(data.dano);
				if (data.recordstatus == '1')
					{
					  document.forms[1].elements[9].checked=true;
					}
					else
					{
					  document.forms[1].elements[9].checked=false;
					}
                document.forms[2].elements[1].value = data.prheaderid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Prmaterial[prheaderid]': data.prheaderid
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
{jQuery.ajax({'url':'/smlive/index.php?r=prheader/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;refreshdata();return false;}
</script>
<script type="text/javascript">
function approvedata()
{jQuery.ajax({'url':'/smlive/index.php?r=prheader/approve','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json',
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
        'url': '/smlive/index.php?r=prheader/help',
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
function generatedata1() {
	jQuery.ajax({
        'url': '/smlive/index.php?r=prheader/generatedetail',
        'data': {
            'id': $('#Prheader_projectid').val(),
            'hid': $('#Prheader_prheaderid').val()
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if(data.status=='failure') {
            document.getElementById('messages').innerHTML = data.div;
            } else {
                $('#fullname').val(data.customername);
            }
            $.fn.yiiGridView.update("detaildatagrid");
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function generatedata2() {
	jQuery.ajax({
        'url': '/smlive/index.php?r=prheader/generatedetail1',
        'data': {
            'id': $('#Prheader_deliveryadviceid').val(),
            'hid': $('#Prheader_prheaderid').val()
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if(data.status=='failure') {
            document.getElementById('messages').innerHTML = data.div;
            } else {
                $('#Prheader_headernote').val(data.headernote);
            }
            $.fn.yiiGridView.update("detaildatagrid");
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
                        'Prmaterial[prheaderid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=prheader/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
					'prmaterial'=>$prmaterial,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'sloc'=>$sloc,
					'requestedby'=>$requestedby,
    'deliveryadvice'=>$deliveryadvice)); ?>
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
<h1>Transaction: Purchase Requisition</h1>
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
	array('name'=>'prheaderid', 'visible'=>false,'header'=>'ID','value'=>'$data->prheaderid','htmlOptions'=>array('width'=>'1%')),
		'prno',
                array(
      'name'=>'prdate',
      'type'=>'raw',
         'value'=>'($data->prdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->prdate)):""'
     ),
	array('name'=>'slocid', 'value'=>'($data->sloc!==null)?$data->sloc->description:""'),
    array('name'=>'deliveryadviceid', 'value'=>'($data->deliveryadvice!==null)?$data->deliveryadvice->dano:""'),
		'headernote',
	array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("apppr",$data->recordstatus)')
  ),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$prmaterial->Search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
            array('name'=>'prmaterialid', 'visible'=>false,'header'=>'ID','value'=>'$data->prmaterialid','htmlOptions'=>array('width'=>'1%')),
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
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->reqdate))'
     ),
            'itemtext',
			array(
      'name'=>'poqty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->poqty)',
     ),
  ),
));
?>
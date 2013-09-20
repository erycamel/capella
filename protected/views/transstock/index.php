<?php
$this->breadcrumbs=array(
	'Transstocks',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');$.fn.yiiGridView.update('indatagrid');return false;}
</script>
<script type="text/javascript">
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=transstock/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
					$('#Transstock_transstockid').val(data.transstockid);
					$('#Transstock_headernote').val('');
					$('#Transstock_slocfromid').val('');
					$('#slocfromcode').val('');
					$('#Transstock_sloctoid').val('');
					$('#sloctocode').val('');
                document.forms[2].elements[1].value = data.transstockid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Transstockdet[transstockid]': data.transstockid
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
        'url': '/smlive/index.php?r=transstock/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                					$('#Transstock_transstockid').val(data.transstockid);
					$('#Transstock_headernote').val(data.headernote);
					$('#Transstock_slocfromid').val(data.slocfromid);
					$('#slocfromcode').val(data.slocfromcode);
					$('#Transstock_sloctoid').val(data.sloctoid);
					$('#sloctocode').val(data.sloctocode);
					if (data.recordstatus == '1')
					{
					  document.forms[1].elements[3].checked=true;
					}
					else
					{
					  document.forms[1].elements[3].checked=false;
					}
                document.forms[2].elements[1].value = data.transstockid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Transstockdet[transstockid]': data.transstockid
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
{jQuery.ajax({'url':'/smlive/index.php?r=transstock/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;refreshdata();return false;}
</script>
<script type="text/javascript">
function approvedata()
{jQuery.ajax({'url':'/smlive/index.php?r=transstock/approve','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json',
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
        'url': '/smlive/index.php?r=transstock/help',
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
                        'Transstockdet[transstockid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=transstock/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
					'transstockdet'=>$transstockdet,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'slocfrom'=>$slocfrom,
    'slocto'=>$slocto,
					'requestedby'=>$requestedby)); ?>
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
<h1>Transaction: Transfer Stock Exchange</h1>
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
	array('name'=>'transstockid', 'visible'=>false, 'header'=>'ID','value'=>'$data->transstockid','htmlOptions'=>array('width'=>'1%')),
		'transstockno',
        	array('name'=>'slocfromid', 'value'=>'($data->slocfrom!==null)?$data->slocfrom->description:""'),
        	array('name'=>'sloctoid', 'value'=>'($data->slocto!==null)?$data->slocto->description:""'),
		'headernote',
        array(
      'name'=>'docdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->docdate))'
     ),
        array(
      'name'=>'postdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->postdate))'
     ),        
	array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appts",$data->recordstatus)')
  ),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$transstockdet->Search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
        	 array(
      'name'=>'qty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
//	 array(
//      'class'=>'application.extensions.TotalColumn',
//      'name'=>'qty',
//      'type'=>'raw',
//      'footer'=>true
//     ),
	array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
            'itemtext'
  ),
));
?>
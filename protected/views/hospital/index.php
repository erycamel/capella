<?php
$this->breadcrumbs=array(
	'Hospitals',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{jQuery.ajax({'url':'/smlive/index.php?r=hospital/create','data':$(this).serialize(),'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Hospital_addressbookid').val(data.addressbookid);$('#Hospital_fullname').val('');
$('#Hospital_accountid').val('');$('#accpiutangname').val('');$('#Hospital_taxno').val('');
document.forms[2].elements[1].value = data.addressbookid;
$.fn.yiiGridView.update('addressdatagrid', {
                    data: {
                        'Hospitaladdress[addressbookid]': data.addressbookid
                    }});
                                        document.forms[3].elements[1].value = data.addressbookid;
$.fn.yiiGridView.update('contactdatagrid', {
                    data: {
                        'Hospitalcontact[addressbookid]': data.addressbookid
                    }
                });
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function editdata()
{jQuery.ajax({'url':'/smlive/index.php?r=hospital/update','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Hospital_addressbookid').val(data.addressbookid);
$('#Hospital_accountid').val(data.accountid);$('#accpiutangname').val(data.accountname);$('#Hospital_taxno').val(data.taxno);
$('#Hospital_fullname').val(data.fullname);if(data.recordstatus=='1')
{document.forms[1].elements[7].checked=true;}
else
{document.forms[1].elements[7].checked=false;}
document.forms[2].elements[1].value = data.addressbookid;
$.fn.yiiGridView.update('addressdatagrid', {
                    data: {
                        'Hospitaladdress[addressbookid]': data.addressbookid
                    }});
                    document.forms[3].elements[1].value = data.addressbookid;
$.fn.yiiGridView.update('contactdatagrid', {
                    data: {
                        'Hospitalcontact[addressbookid]': data.addressbookid
                    }
                });
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=hospital/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
    jQuery.ajax({
        'url': '/smlive/index.php?r=hospital/help',
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
    $.fn.yiiGridView.update('inaddressdatagrid', {
                    data: {
                        'Hospitaladdress[addressbookid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
                   $.fn.yiiGridView.update('incontactdatagrid', {
                    data: {
                        'Hospitalcontact[addressbookid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=hospital/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
'hospitaladdress'=>$hospitaladdress,
'hospitalcontact'=>$hospitalcontact,
        'accpiutang'=>$accpiutang)); ?>
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
<h1>Parameter: Hospital</h1><div id="toolbar">
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
	'dataProvider'=>$model->search(),
	'filter'=>$model,
  'selectableRows'=>1,
    'selectionChanged'=>'showdetail',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'addressbookid',
    ),
	array('name'=>'addressbookid', 'visible'=>false,'header'=>'ID','value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
		'fullname',
        'taxno',
		array('name'=>'accpiutangid','value'=>'($data->accpiutang!==null)?$data->accpiutang->accountname:""'),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->recordstatus'
    ),
	),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inaddressdatagrid',
	'dataProvider'=>$hospitaladdress->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'addressid', 'visible'=>false,'header'=>'ID','value'=>'$data->addressid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'addressbookid', 'visible'=>false,'value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
array('name'=>'addresstypeid', 'header'=>'Address Type Name','value'=>'$data->addresstype->addresstypename'),
		'addressname',
		'rt',
    'rw',
		array('name'=>'cityid','header'=>'City','value'=>'($data->city!==null)?$data->city->cityname:""'),
		array('name'=>'kelurahanid','header'=>'Sub Subdistrict','value'=>'($data->kelurahan!==null)?$data->kelurahan->kelurahanname:""'),
		array('name'=>'subdistrictid','header'=>'Subdistrict','value'=>'($data->subdistrict!==null)?$data->subdistrict->subdistrictname:""'),
        'phoneno',
  ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'incontactdatagrid',
	'dataProvider'=>$hospitalcontact->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'addresscontactid','visible'=>false, 'header'=>'ID','value'=>'$data->addresscontactid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'addressbookid','visible'=>false, 'value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
array('name'=>'contacttypeid', 'value'=>'($data->contacttype!==null)?$data->contacttype->contacttypename:""'),
		'addresscontactname',
		'phoneno',
		'mobilephone',
		'emailaddress',
  ),
));
?>
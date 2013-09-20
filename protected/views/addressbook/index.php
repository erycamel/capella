<?php
$this->breadcrumbs=array(
	'Addressbooks',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{jQuery.ajax({'url':'/smlive/index.php?r=addressbook/create','data':$(this).serialize(),'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Addressbook_addressbookid').val('');$('#Addressbook_fullname').val('');$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function editdata()
{jQuery.ajax({'url':'/smlive/index.php?r=addressbook/update','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Addressbook_addressbookid').val(data.addressbookid);$('#Addressbook_fullname').val(data.fullname);if(data.iscustomer=='1')
{document.forms[1].elements[3].checked=true;}
else
{document.forms[1].elements[3].checked=false;}
if(data.isemployee=='1')
{document.forms[1].elements[5].checked=true;}
else
{document.forms[1].elements[5].checked=false;}
if(data.isapplicant=='1')
{document.forms[1].elements[7].checked=true;}
else
{document.forms[1].elements[7].checked=false;}
if(data.isvendor=='1')
{document.forms[1].elements[9].checked=true;}
else
{document.forms[1].elements[9].checked=false;}
if(data.isinsurance=='1')
{document.forms[1].elements[11].checked=true;}
else
{document.forms[1].elements[11].checked=false;}
if(data.isbank=='1')
{document.forms[1].elements[13].checked=true;}
else
{document.forms[1].elements[13].checked=false;}
if(data.ishospital=='1')
{document.forms[1].elements[15].checked=true;}
else
{document.forms[1].elements[15].checked=false;}
if(data.iscatering=='1')
{document.forms[1].elements[17].checked=true;}
else
{document.forms[1].elements[17].checked=false;}
if(data.recordstatus=='1')
{document.forms[1].elements[19].checked=true;}
else
{document.forms[1].elements[19].checked=false;}
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=addressbook/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=addressbook/help',
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
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
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
<h1>Parameter: Address Books</h1>
<div id="toolbardoublegrid">
<?php
$imgcreate=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($imgcreate,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata()}",
	'title'=>Yii::t('app','create data')
));
$imgedit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($imgedit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata()}",
	'title'=>Yii::t('app','edit data')
));
$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>Yii::t('app','delete data')
));
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml::link($imgdown,array('/addressbook/download'),array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'title'=>Yii::t('app','download data')
));
$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>Yii::t('app','refresh data')
));
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(1)}",
   'title'=>Yii::t('app','help')
));
?><div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div><?php
// $this->widget('ext.EAjaxUpload.EAjaxUpload',
                 // array(
                       // 'id'=>'uploadFile',
                       // 'config'=>array(
                                       // 'action'=>'index.php?r=addressbook/upload',
                                       // 'allowedExtensions'=>array("csv"),
                                       // 'sizeLimit'=>(int)Yii::app()->params['sizeLimit'],
									   // 'onComplete'=>"js:function(id, fileName, responseJSON){ $.fn.yiiGridView.update('datagrid');  }",
                                       // 'messages'=>array(
                                                         // 'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                                         // 'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                                         // 'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                                         // 'emptyError'=>"{file} is empty, please select files again without it.",
                                                         // 'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                                        // ),
                                       // 'showMessage'=>"js:function(message){ alert(message); }"
                                      // )
                      // ));
?></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'addressbookid','visible'=>false, 'value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
	'fullname',
        'taxno',
        'abno',
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'iscustomer',
      'selectableRows'=>'0',
      'header'=>'Is Customer',
      'checked'=>'$data->iscustomer',
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'isemployee',
      'selectableRows'=>'0',
      'header'=>'Is Employee',
      'checked'=>'$data->isemployee',
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'isapplicant',
      'selectableRows'=>'0',
      'header'=>'Is Applicant',
      'checked'=>'$data->isapplicant',
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'iscustomer',
      'selectableRows'=>'0',
      'header'=>'Is Vendor',
      'checked'=>'$data->isvendor',
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'isinsurance',
      'selectableRows'=>'0',
      'header'=>'Is Insurance',
      'checked'=>'$data->isinsurance',
    ),
	array(
      'class'=>'CCheckBoxColumn',
      'name'=>'isbank',
      'selectableRows'=>'0',
      'header'=>'Is Bank',
      'checked'=>'$data->isbank',
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'ishospital',
      'selectableRows'=>'0',
      'header'=>'Is Hospital',
      'checked'=>'$data->ishospital',
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'iscatering',
      'selectableRows'=>'0',
      'header'=>'Is Catering',
      'checked'=>'$data->iscatering',
    ),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->recordstatus',
    ),
  ),
));
?>

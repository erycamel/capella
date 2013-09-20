<?php
$this->breadcrumbs=array(
	'Groupmenues',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=groupmenu/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Groupmenu_groupmenuid').val('');
                $('#Groupmenu_groupaccessid').val('');
                $('#groupname').val('');
                $('#Groupmenu_menuaccessid').val('');
                $('#menuname').val('');
                $('#createdialog').dialog('open');
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
function editdata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=groupmenu/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Groupmenu_groupmenuid').val(data.groupmenuid);
                $('#Groupmenu_groupaccessid').val(data.groupaccessid);
                $('#groupname').val(data.groupname);
                $('#Groupmenu_menuaccessid').val(data.menuaccessid);
                $('#menuname').val(data.menuname);
                if (data.isread == '1') {
                    document.forms[1].elements[8].checked = true;
                } else {
                    document.forms[1].elements[8].checked = false;
                }
                if (data.iswrite == '1') {
                    document.forms[1].elements[10].checked = true;
                } else {
                    document.forms[1].elements[10].checked = false;
                }
                if (data.ispost == '1') {
                    document.forms[1].elements[12].checked = true;
                } else {
                    document.forms[1].elements[12].checked = false;
                }
                if (data.isreject == '1') {
                    document.forms[1].elements[14].checked = true;
                } else {
                    document.forms[1].elements[14].checked = false;
                }
                if (data.isupload == '1') {
                    document.forms[1].elements[16].checked = true;
                } else {
                    document.forms[1].elements[16].checked = false;
                }
                if (data.isdownload == '1') {
                    document.forms[1].elements[18].checked = true;
                } else {
                    document.forms[1].elements[18].checked = false;
                }
                $('#createdialog').dialog('open');
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
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=groupmenu/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML=data.div;},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=groupmenu/help',
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
	window.open('/smlive/index.php?r=groupmenu/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
'groupaccess'=>$groupaccess,
'menuaccess'=>$menuaccess));?>
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
<h1>Parameter: Group Menus</h1>
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
?><div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></ul></div>
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
		'id'=>'groupmenuid',
	  ),
	  array('name'=>'groupmenuid','visible'=>false, 'value'=>'$data->groupmenuid','htmlOptions'=>array('width'=>'1%')),
	  array('name'=>'groupaccessid', 'value'=>'$data->groupaccess->groupname'),
//      array(
//            'name'=>'groupaccessid',
//            //call the method 'gridUniqueProductName' of the controller
//            //the params extracted to the method are $data (=the current rowdata) and $row (the row index)
//            'value'=>array($this,'gridGroupName')
//        ),
	  array('name'=>'menuaccessid', 'value'=>'($data->menuaccess!==null)?$data->menuaccess->description:""'),
	  array('class'=>'CCheckBoxColumn',
		'name'=>'isread',
		'header'=>'Is Read',
		'selectableRows'=>'0',
		'checked'=>'$data->isread'),
array('class'=>'CCheckBoxColumn',
		'name'=>'iswrite',
		'header'=>'Is Write',
		'selectableRows'=>'0',
		'checked'=>'$data->iswrite'),
array('class'=>'CCheckBoxColumn',
		'name'=>'ispost',
		'header'=>'Is Post',
		'selectableRows'=>'0',
		'checked'=>'$data->ispost'),
array('class'=>'CCheckBoxColumn',
		'name'=>'isreject',
		'header'=>'Is Reject',
		'selectableRows'=>'0',
		'checked'=>'$data->isreject'),
array('class'=>'CCheckBoxColumn',
		'name'=>'isupload',
		'header'=>'Is Upload',
		'selectableRows'=>'0',
		'checked'=>'$data->isupload'),
array('class'=>'CCheckBoxColumn',
		'name'=>'isdownload',
		'header'=>'Is Download',
		'selectableRows'=>'0',
		'checked'=>'$data->isdownload'),

	),
));
?>

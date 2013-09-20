<?php
$this->breadcrumbs=array(
	'Workorderes',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=workorder/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Workorder_workorderid').val('');
                $('#Workorder_productid').val('');
                $('#productname').val('');
                $('#Workorder_workstartdate').val('');
                $('#Workorder_worktargetdate').val('');
                $('#Workorder_workorderstaffid').val('');
                $('#useraccessid').val('');
                $('#Workorder_description').val('');
                $('#Workorder_workorderstatus').val('');
                $('#Workorder_eventrequestid').val('');
                $('#eventtitle').val('');
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
        'url': '/smlive/index.php?r=workorder/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Workorder_workorderid').val(data.workorderid);
                $('#Workorder_productid').val(data.productid);
                $('#productname').val(data.productname);
                $('#Workorder_workstartdate').val(data.workstartdate);
                $('#Workorder_worktargetdate').val(data.worktargetdate);
                $('#Workorder_workorderstaffid').val(data.workorderstaffid);
                $('#useraccessid').val(data.useraccessid);
                $('#Workorder_description').val(data.description);
                $('#Workorder_workorderstatus').val(data.workorderstatus);
                $('#Workorder_eventrequestid').val(data.eventrequestid);
                $('#eventtitle').val(data.eventtitle);
                if (data.recordstatus == '1') {
                    document.forms[1].elements[15].checked = true;
                } else {
                    document.forms[1].elements[15].checked = false;
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
function assigndata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=workorder/assign',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid"),
			'workorderstaffid': document.getElementById('workorderstaffid').value
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function viewdata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=workorder/view',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
			  document.getElementById('divview').innerHTML = data.div;
                $('#viewdialog').dialog('open');
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
{jQuery.ajax({'url':'/smlive/index.php?r=workorder/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML=data.div;},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
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
  'workorderstaff'=>$workorderstaff,
'eventrequest'=>$eventrequest,
'product'=>$product));
?>
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
<?php echo $this->renderPartial('_help'); ?>
<?php $this->endWidget();?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'viewdialog',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divview"></div>
<?php $this->endWidget();?>
<h1>Work Orders</h1><div id="toolbar">
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
$imgview=CHtml::image(Yii::app()->request->baseUrl.'/images/view.png');
echo CHtml::link($imgview,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{viewdata()}",
	'title'=>Yii::t('app','view data')
));
$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>Yii::t('app','delete data')
));
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml::link($imgdown,array('/workorder/download'),array(
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
   'onclick'=>"$('#helpdialog').dialog('open');",
   'title'=>Yii::t('app','help')
));
?>Record/page <?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?>
	<?php
$this->widget('ext.EAjaxUpload.EAjaxUpload',
                 array(
                       'id'=>'uploadFile',
                       'config'=>array(
                                       'action'=>'index.php?r=workorder/upload',
                                       'allowedExtensions'=>array("csv"),
                                       'sizeLimit'=>(int)Yii::app()->params['sizeLimit'],
									   'onComplete'=>"js:function(id, fileName, responseJSON){ $.fn.yiiGridView.update('datagrid');  }",
                                       'messages'=>array(
                                                         'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                                         'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                                         'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                                         'emptyError'=>"{file} is empty, please select files again without it.",
                                                         'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                                        ),
                                       'showMessage'=>"js:function(message){ alert(message); }"
                                      )
                      ));
?></div>
<input type="hidden" id="workorderstaffid">
	  <input type="text" id="username" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'workorderstaff1_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Absence Schedules'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'workorderstaff-grid',
      'dataProvider'=>$workorderstaff->Searchwstatus(),
      'filter'=>$workorderstaff,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#workorderstaff1_dialog\").dialog(\"close\"); $(\"#username\").val(\"$data->useraccessid\"); $(\"#workorderstaffid\").val(\"$data->workorderstaffid\");
		  "))',
          ),
        'workorderstaffid',
		'useraccessid',
        'useraccess.username',
        array(
          'class'=>'CCheckBoxColumn',
          'name'=>'recordstatus',
          'selectableRows'=>'0',
          'header'=>'Record Status',
          'checked'=>'$data->recordstatus'
        ),
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#workorderstaff1_dialog").dialog("open"); return false;',
                       ))?>
  <?php $imgedit=CHtml::image(Yii::app()->request->baseUrl.'/images/approve.png');
echo CHtml::link($imgedit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{assigndata()}",
	'title'=>Yii::t('app','edit data')
)); ?>

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
		'id'=>'workorderid',
	  ),
	  array('name'=>'workorderid', 'value'=>'$data->workorderid','htmlOptions'=>array('width'=>'1%')),
	  array('name'=>'productid', 'value'=>'$data->product->productname'),
	  array('name'=>'workorderstaffid', 'value'=>'$data->workorderstaff->useraccess->username'),
	  array('name'=>'eventrequestid', 'value'=>'$data->eventrequest->eventtitle'),
		  'description',
	  array('name'=>'workorderstatusid', 'value'=>'$data->workorderstatus->statusname'),
		  'workstartdate',
		  'worktargetdate',
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

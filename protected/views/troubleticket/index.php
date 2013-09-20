<?php
$this->breadcrumbs=array(
	'troubletickets',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=troubleticket/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
				//document.getElementById('divcreate').innerHTML = data.div;
                $('#Troubleticket_troubleticketid').val('');
                $('#Troubleticket_useraccessid').val('');
                $('#realname').val('');
                $('#Troubleticket_customername').val('');
                $('#Troubleticket_unitkerja').val('');
                $('#Troubleticket_phoneno').val('');
                $('#Troubleticket_mobilephoneno').val('');
                $('#Troubleticket_customeraddress').val('');
                $('#Troubleticket_description').val('');
                $('#Troubleticket_serviceno').val('');
                $('#Troubleticket_startdate').val('');
                $('#Troubleticket_enddate').val('');
                $('#Troubleticket_troubleticketstatusid').val('');
                $('#troublecode').val('');
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
        'url': '/smlive/index.php?r=troubleticket/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
				//document.getElementById('divcreate').innerHTML = data.div;
                $('#Troubleticket_troubleticketid').val(data.troubleticketid);
                $('#Troubleticket_useraccessid').val(data.useraccessid);
                $('#realname').val(data.realname);
                $('#Troubleticket_customername').val(data.customername);
                $('#Troubleticket_unitkerja').val(data.unitkerja);
                $('#Troubleticket_phoneno').val(data.phoneno);
                $('#Troubleticket_mobilephoneno').val(data.mobilephoneno);
                $('#Troubleticket_customeraddress').val(data.customeraddress);
                $('#Troubleticket_description').val(data.description);
                $('#Troubleticket_serviceno').val(data.serviceno);
                $('#Troubleticket_startdate').val(data.startdate);
                $('#Troubleticket_enddate').val(data.enddate);
                $('#Troubleticket_troubleticketstatusid').val(data.troubleticketstatusid);
                $('#troublecode').val(data.troublecode);
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
{jQuery.ajax({'url':'/smlive/index.php?r=troubleticket/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML=data.div;},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function approvedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('troubleticket/approve'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
if (data.status == 'failure')
                {
                document.getElementById('messages').innerHTML = data.div;
            }
            } ",
            ))?>;
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=troubleticket/help',
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
                        'Troubleticketdetail[troubleticketid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
	jQuery.ajax({
        'url': '/smlive/index.php?r=troubleticket/getdowntime',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")[0]
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if (data.status == 'success') {
				document.getElementById('current_selected_downtime').innerHTML = data.div;
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
	window.open('/smlive/index.php?r=troubleticket/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#messages');
		new AjaxUpload(btnUpload, {
			action: 'index.php?r=troubleticket/upload',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (!(ext && /^(csv)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only RAR, ZIP, DOC, XLS, PPT, TXT, DOCX, XLSX, PPTX files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				status.text('');
				//Add uploaded file to list
				if(response=='success'){
					$.fn.yiiGridView.update('indatagrid');
				} else{
					status.text(response);
				}
			}
		});		
	});
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
<?php echo $this->renderPartial('_form', array('model'=>$model,
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
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpmodifdialog',
    'options'=>array(
        'title'=>'Help',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divhelpmodif"></div>
<?php $this->endWidget();?>
<h1>Transaction: Trouble Ticket</h1>
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
?>
<li>
<a id="upload" class="hover" style="cursor: pointer; text-decoration: underline; padding-top:15px; " title="upload file">
<img src="images/up.png" alt="">
</a>
</li>
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
?><div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></ul></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->searchwstatus(),
	'filter'=>$model,
    'selectionChanged'=>'showdetail',
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	  array(
		'class'=>'CCheckBoxColumn',
		'id'=>'troubleticketid',
	  ),
	  array('name'=>'troubleticketid', 'visible'=>false,'value'=>'$data->troubleticketid','htmlOptions'=>array('width'=>'1%')),
		  'troubleticketno',
		  'serviceno',
		  'customername',
		  'unitkerja',
		  'phoneno',
		  'mobilephoneno',
		  'customeraddress',
		  array(
      'name'=>'description',
      'type'=>'raw',
         'value'=>'substr($data->description,0,19)."..."'
     ),
	array('name'=>'useraccessid', 'value'=>'($data->userku!==null)?$data->userku->realname:""'),
	array(
      'name'=>'startdate',
      'type'=>'raw',
         'value'=>'($data->startdate!==null)?date(Yii::app()->params["datetimeviewfromdb"], strtotime($data->startdate)):""'
     ),
			array(
      'name'=>'enddate',
      'type'=>'raw',
         'value'=>'($data->enddate!==null)?date(Yii::app()->params["datetimeviewfromdb"], strtotime($data->enddate)):""'
     ),
	 	array('name'=>'troubleticketstatusid', 'value'=>'($data->troubleticketstatus!==null)?$data->troubleticketstatus->troublecode:""'),
	),
));
?>
<div id="current_selected_downtime"></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$troubleticketdetail->search(),
	'filter'=>$troubleticketdetail,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	  array('name'=>'troubleticketid', 'visible'=>false,'value'=>'$data->troubleticketid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'woino', 'type'=>'raw',
        'value'=>'($data->filename!==null)?CHtml::link($data->woino,"document/".$data->filename):$data->woino'),  
			array(
      'name'=>'startdate',
      'type'=>'raw',
         'value'=>'($data->startdate!==null)?date(Yii::app()->params["datetimeviewfromdb"], strtotime($data->startdate)):""'
     ),
			array(
      'name'=>'enddate',
      'type'=>'raw',
         'value'=>'($data->enddate!==null)?date(Yii::app()->params["datetimeviewfromdb"], strtotime($data->enddate)):""'
     ),
			array(
      'name'=>'uploaddate',
      'type'=>'raw',
         'value'=>'($data->uploaddate!==null)?date(Yii::app()->params["datetimeviewfromdb"], strtotime($data->uploaddate)):""'
     ),
	 'description',
	array('name'=>'useraccessid', 'value'=>'($data->userku!==null)?$data->userku->realname:""'),
	array('name'=>'troubleticketstatusid', 'value'=>'($data->troubleticketstatus!==null)?$data->troubleticketstatus->troublecode:""'),
)));
?>

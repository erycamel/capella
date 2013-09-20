<?php
$this->breadcrumbs=array(
	'Employeeschedules',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=employeeschedule/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Employeeschedule_employeescheduleid').val(data.employeescheduleid);
                $('#Employeeschedule_employeeid').val(data.employeeid);
                $('#employee_name').val(data.fullname);
                $('#Employeeschedule_month').val(data.month);
                $('#Employeeschedule_year').val(data.year);
                $('#Employeeschedule_d1').val('');
				$('#d1_name').val('');
                $('#Employeeschedule_d2').val('');
				$('#d2_name').val('');
                $('#Employeeschedule_d3').val('');
				$('#d3_name').val('');
                $('#Employeeschedule_d4').val('');
				$('#d4_name').val('');
                $('#Employeeschedule_d5').val('');
				$('#d5_name').val('');
                $('#Employeeschedule_d6').val('');
				$('#d6_name').val('');
                $('#Employeeschedule_d7').val('');
				$('#d7_name').val('');
                $('#Employeeschedule_d8').val('');
				$('#d8_name').val('');
                $('#Employeeschedule_d9').val('');
				$('#d9_name').val('');
                $('#Employeeschedule_d10').val('');
				$('#d10_name').val('');
                $('#Employeeschedule_d11').val(data.d11);
				$('#d11_name').val(data.d11_name);
                $('#Employeeschedule_d12').val(data.d12);
				$('#d12_name').val(data.d12_name);
                $('#Employeeschedule_d13').val(data.d13);
				$('#d13_name').val(data.d13_name);
                $('#Employeeschedule_d14').val(data.d14);
				$('#d14_name').val(data.d14_name);
                $('#Employeeschedule_d15').val(data.d15);
				$('#d15_name').val(data.d15_name);
                $('#Employeeschedule_d16').val(data.d16);
				$('#d16_name').val(data.d16_name);
                $('#Employeeschedule_d17').val(data.d17);
				$('#d17_name').val(data.d17_name);
                $('#Employeeschedule_d18').val(data.d18);
				$('#d18_name').val(data.d18_name);
                $('#Employeeschedule_d19').val(data.d19);
				$('#d19_name').val(data.d19_name);
                $('#Employeeschedule_d20').val(data.d20);
				$('#d20_name').val(data.d20_name);
                $('#Employeeschedule_d21').val(data.d21);
				$('#d21_name').val(data.d21_name);
                $('#Employeeschedule_d22').val(data.d22);
				$('#d22_name').val(data.d22_name);
                $('#Employeeschedule_d23').val(data.d23);
				$('#d23_name').val(data.d23_name);
                $('#Employeeschedule_d24').val(data.d24);
				$('#d24_name').val(data.d24_name);
                $('#Employeeschedule_d25').val(data.d25);
				$('#d25_name').val(data.d25_name);
                $('#Employeeschedule_d26').val(data.d26);
				$('#d26_name').val(data.d26_name);
                $('#Employeeschedule_d27').val(data.d27);
				$('#d27_name').val(data.d27_name);
                $('#Employeeschedule_d28').val(data.d28);
				$('#d28_name').val(data.d28_name);
                $('#Employeeschedule_d29').val(data.d29);
				$('#d29_name').val(data.d29_name);
                $('#Employeeschedule_d30').val(data.d30);
				$('#d30_name').val(data.d30_name);
                $('#Employeeschedule_d31').val(data.d31);
				$('#d31_name').val(data.d31_name);
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
        'url': '/smlive/index.php?r=employeeschedule/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Employeeschedule_employeescheduleid').val(data.employeescheduleid);
                $('#Employeeschedule_employeeid').val(data.employeeid);
                $('#employee_name').val(data.fullname);
                $('#Employeeschedule_month').val(data.month);
                $('#Employeeschedule_year').val(data.year);
                $('#Employeeschedule_d1').val(data.d1);
				$('#d1_name').val(data.d1_name);
                $('#Employeeschedule_d2').val(data.d2);
				$('#d2_name').val(data.d2_name);
                $('#Employeeschedule_d3').val(data.d3);
				$('#d3_name').val(data.d3_name);
                $('#Employeeschedule_d4').val(data.d4);
				$('#d4_name').val(data.d4_name);
                $('#Employeeschedule_d5').val(data.d5);
				$('#d5_name').val(data.d5_name);
                $('#Employeeschedule_d6').val(data.d6);
				$('#d6_name').val(data.d6_name);
                $('#Employeeschedule_d7').val(data.d7);
				$('#d7_name').val(data.d7_name);
                $('#Employeeschedule_d8').val(data.d8);
				$('#d8_name').val(data.d8_name);
                $('#Employeeschedule_d9').val(data.d9);
				$('#d9_name').val(data.d9_name);
                $('#Employeeschedule_d10').val(data.d10);
				$('#d10_name').val(data.d10_name);
                $('#Employeeschedule_d11').val(data.d11);
				$('#d11_name').val(data.d11_name);
                $('#Employeeschedule_d12').val(data.d12);
				$('#d12_name').val(data.d12_name);
                $('#Employeeschedule_d13').val(data.d13);
				$('#d13_name').val(data.d13_name);
                $('#Employeeschedule_d14').val(data.d14);
				$('#d14_name').val(data.d14_name);
                $('#Employeeschedule_d15').val(data.d15);
				$('#d15_name').val(data.d15_name);
                $('#Employeeschedule_d16').val(data.d16);
				$('#d16_name').val(data.d16_name);
                $('#Employeeschedule_d17').val(data.d17);
				$('#d17_name').val(data.d17_name);
                $('#Employeeschedule_d18').val(data.d18);
				$('#d18_name').val(data.d18_name);
                $('#Employeeschedule_d19').val(data.d19);
				$('#d19_name').val(data.d19_name);
                $('#Employeeschedule_d20').val(data.d20);
				$('#d20_name').val(data.d20_name);
                $('#Employeeschedule_d21').val(data.d21);
				$('#d21_name').val(data.d21_name);
                $('#Employeeschedule_d22').val(data.d22);
				$('#d22_name').val(data.d22_name);
                $('#Employeeschedule_d23').val(data.d23);
				$('#d23_name').val(data.d23_name);
                $('#Employeeschedule_d24').val(data.d24);
				$('#d24_name').val(data.d24_name);
                $('#Employeeschedule_d25').val(data.d25);
				$('#d25_name').val(data.d25_name);
                $('#Employeeschedule_d26').val(data.d26);
				$('#d26_name').val(data.d26_name);
                $('#Employeeschedule_d27').val(data.d27);
				$('#d27_name').val(data.d27_name);
                $('#Employeeschedule_d28').val(data.d28);
				$('#d28_name').val(data.d28_name);
                $('#Employeeschedule_d29').val(data.d29);
				$('#d29_name').val(data.d29_name);
                $('#Employeeschedule_d30').val(data.d30);
				$('#d30_name').val(data.d30_name);
                $('#Employeeschedule_d31').val(data.d31);
				$('#d31_name').val(data.d31_name);
                if (data.recordstatus == '1') {
                    document.forms[1].elements[100].checked = true;
                }
                else {
                    document.forms[1].elements[100].checked = false;
                }
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
{jQuery.ajax({'url':'/smlive/index.php?r=employeeschedule/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function approvedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('employeeschedule/approve'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
if (data.status == 'success')
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
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=employeeschedule/help',
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
	window.open('/smlive/index.php?r=employeeschedule/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#messagesku');
		new AjaxUpload(btnUpload, {
			action: 'index.php?r=employeeschedule/upload',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (!(ext && /^(csv)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only CSV files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				status.text('');
				//Add uploaded file to list
				if(response==="success"){
					$.fn.yiiGridView.update('datagrid');
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
<div id="divcreate"></div>
<?php echo $this->renderPartial('_form', array('model'=>$model,
			'employee'=>$employee)); ?>
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
<h1>Parameter: Employee Schedules</h1>
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

$imgapp=CHtml::image(Yii::app()->request->baseUrl.'/images/approve.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgapp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{approvedata()}",
   'title'=>Yii::t('app','Approve Data')
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
</li><?php
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
	'dataProvider'=>$model->searchwstatus(),
	'filter'=>$model,
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'employeescheduleid', 'visible'=>false,'header'=>'ID','value'=>'$data->employeescheduleid','htmlOptions'=>array('width'=>'1%')),
		array('name'=>'employeeid', 'header'=>'Employee','value'=>'$data->employee->fullname'),
		'month',
		'year',
		array('name'=>'d1', 'value'=>'($data->d100!==null)?$data->d100->absschedulename:""'),
		array('name'=>'d2', 'value'=>'($data->d200!==null)?$data->d200->absschedulename:""'),
		array('name'=>'d3', 'value'=>'($data->d300!==null)?$data->d300->absschedulename:""'),
		array('name'=>'d4', 'value'=>'($data->d400!==null)?$data->d400->absschedulename:""'),
		array('name'=>'d5', 'value'=>'($data->d500!==null)?$data->d500->absschedulename:""'),
		array('name'=>'d6', 'value'=>'($data->d600!==null)?$data->d600->absschedulename:""'),
		array('name'=>'d7', 'value'=>'($data->d700!==null)?$data->d700->absschedulename:""'),
		array('name'=>'d8', 'value'=>'($data->d800!==null)?$data->d800->absschedulename:""'),
		array('name'=>'d9', 'value'=>'($data->d900!==null)?$data->d900->absschedulename:""'),
		array('name'=>'d10', 'value'=>'($data->d1000!==null)?$data->d1000->absschedulename:""'),
		array('name'=>'d11', 'value'=>'($data->d1100!==null)?$data->d1100->absschedulename:""'),
		array('name'=>'d12', 'value'=>'($data->d1200!==null)?$data->d1200->absschedulename:""'),
		array('name'=>'d13', 'value'=>'($data->d1300!==null)?$data->d1300->absschedulename:""'),
		array('name'=>'d14', 'value'=>'($data->d1400!==null)?$data->d1400->absschedulename:""'),
		array('name'=>'d15', 'value'=>'($data->d1500!==null)?$data->d1500->absschedulename:""'),
		array('name'=>'d16', 'value'=>'($data->d1600!==null)?$data->d1600->absschedulename:""'),
		array('name'=>'d17', 'value'=>'($data->d1700!==null)?$data->d1700->absschedulename:""'),
		array('name'=>'d18', 'value'=>'($data->d1800!==null)?$data->d1800->absschedulename:""'),
		array('name'=>'d19', 'value'=>'($data->d1900!==null)?$data->d1900->absschedulename:""'),
		array('name'=>'d20', 'value'=>'($data->d2000!==null)?$data->d2000->absschedulename:""'),
		array('name'=>'d21', 'value'=>'($data->d2100!==null)?$data->d2100->absschedulename:""'),
		array('name'=>'d22', 'value'=>'($data->d2200!==null)?$data->d2200->absschedulename:""'),
		array('name'=>'d23', 'value'=>'($data->d2300!==null)?$data->d2300->absschedulename:""'),
		array('name'=>'d24', 'value'=>'($data->d2400!==null)?$data->d2400->absschedulename:""'),
		array('name'=>'d25', 'value'=>'($data->d2500!==null)?$data->d2500->absschedulename:""'),
		array('name'=>'d26', 'value'=>'($data->d2600!==null)?$data->d2600->absschedulename:""'),
		array('name'=>'d27', 'value'=>'($data->d2700!==null)?$data->d2700->absschedulename:""'),
		array('name'=>'d28', 'value'=>'($data->d2800!==null)?$data->d2800->absschedulename:""'),
		array('name'=>'d29', 'value'=>'($data->d2900!==null)?$data->d2900->absschedulename:""'),
		array('name'=>'d30', 'value'=>'($data->d3000!==null)?$data->d3000->absschedulename:""'),
		array('name'=>'d31', 'value'=>'($data->d3100!==null)?$data->d3100->absschedulename:""'),
    	array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appempsched",$data->recordstatus)')
	),
)); 
?>
<div id="messagesku"></div>

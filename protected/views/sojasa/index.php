<?php
$this->breadcrumbs=array(
	'Soheaders',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{jQuery.ajax({'url':'/smlive/index.php?r=soheader/create','data':$(this).serialize(),'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);
    $('#Soheader_soheaderid').val(data.soheaderid);
					$('#Soheader_sono').val('');
					$('#Soheader_sodate').val('');
					$('#Soheader_postdate').val('');
					$('#Soheader_addressbookid').val('');
					$('#fullname').val('');
					$('#Soheader_servicetypeid').val('');
					$('#servicetypename').val('');
					$('#Soheader_contractno').val('');
					$('#Soheader_startdate').val('');
					$('#Soheader_enddate').val('');
					$('#Soheader_employeeid');
					$('#employeename').val('');
					$('#Soheader_currencyid').val('');
					$('#currencyname').val('');
					$('#Soheader_projectvalue').val('');
					$('#Soheader_projecttypeid').val('');
					$('#projecttypecode').val('');
					$('#Soheader_projectname').val('');
					$('#Soheader_personincharge').val('');
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function editdata()
{jQuery.ajax({'url':'/smlive/index.php?r=soheader/update','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);
    $('#Soheader_soheaderid').val(data.soheaderid);
					$('#Soheader_sono').val(data.sono);
					$('#Soheader_sodate').val(data.sodate);
					$('#Soheader_postdate').val(data.postdate);
					$('#Soheader_addressbookid').val(data.addressbookid);
					$('#fullname').val(data.fullname);
					$('#Soheader_servicetypeid').val(data.servicetypeid);
					$('#servicetypename').val(data.servicetypename);
					$('#Soheader_contractno').val(data.contractno);
					$('#Soheader_startdate').val(data.startdate);
					$('#Soheader_enddate').val(data.enddate);
					$('#Soheader_employeeid').val(data.employeeid);
					$('#employeename').val(data.employeename);
					$('#Soheader_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Soheader_projectvalue').val(data.projectvalue);
					$('#Soheader_projecttypeid').val(data.projecttypeid);
					$('#projecttypecode').val(data.projecttypecode);
					$('#Soheader_projectname').val(data.projectname);
					$('#Soheader_personincharge').val(data.personincharge);
					if (data.recordstatus == '1')
					{
					  document.forms[1].elements[23].checked=true;
					}
					else
					{
					  document.forms[1].elements[23].checked=false;
					}
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function deletedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('soheader/delete'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function approvedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('soheader/approve'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = data.div;
            } ",
            ))?>;
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata()
{
    $.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function generatedata1() {
	jQuery.ajax({
        'url': '/smlive/index.php?r=soheader/generatedetail',
        'data': {
            'id': $('#Soheader_pocheaderid').val(),
            'hid': $('#Soheader_soheaderid').val()
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
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=soheader/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=soheader/help',
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
	window.open('/smlive/index.php?r=soheader/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#messages');
		new AjaxUpload(btnUpload, {
			action: 'index.php?r=soheader/upload',
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
				if(response=='success'){
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
                  'customer'=>$this->customer,
				  'projecttype'=>$this->projecttype,
				  'servicetype'=>$this->servicetype,
				  'employee'=>$this->employee,
    'currency'=>$currency)); ?>
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
<h1>Sales Orders</h1><div id="toolbar">
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
?>
<div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></ul></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->searchwfstatus(),
	'filter'=>$model,
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'soheaderid','visible'=>false, 'header'=>'ID','value'=>'$data->soheaderid','htmlOptions'=>array('width'=>'1%')),
		'sono',
		 array(
      'name'=>'sodate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->sodate))'
     ),
	array('name'=>'addressbookid', 'value'=>'($data->customer!==null)?$data->customer->fullname:""'),
		'contractno',
	  array(
      'name'=>'startdate',
      'type'=>'raw',
         'value'=>'($data->startdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->startdate)):""'
     ),
	  array(
      'name'=>'enddate',
      'type'=>'raw',
         'value'=>'($data->enddate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->enddate)):""'
     ),
	array('name'=>'servicetypeid', 'value'=>'($data->servicetype!==null)?$data->servicetype->servicetypename:""'),
	 'projectname',
	 array(
      'name'=>'projectvalue',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->projectvalue)',
     ),
	array('name'=>'currencyid', 'value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
	array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("apppo",$data->recordstatus)')

   
  ),
));
?>
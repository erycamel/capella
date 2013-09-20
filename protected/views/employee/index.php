<?php
$this->breadcrumbs=array(
	'Employees',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{jQuery.ajax({'url':'/smlive/index.php?r=employee/create','data':$(this).serialize(),'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Employee_employeeid').val('');$('#Employee_addressbookid').val('');$('#Employee_fullname').val('');$('#Employee_oldnik').val('');$('#Employee_orgstructureid').val('');$('#orgstructure_name').val('');$('#Employee_positionid').val('');$('#position_name').val('');$('#Employee_employeetypeid').val('');$('#employeetype_name').val('');$('#Employee_sexid').val('');$('#sex_name').val('');$('#Employee_bloodtypeid').val('');$('#bloodtype_name').val('');$('#Employee_birthcityid').val('');$('#birthcity_name').val('');$('#Employee_birthdate').val('');$('#Employee_religionid').val('');$('#religion_name').val('');$('#Employee_maritalstatusid').val('');$('#maritalstatus_name').val('');$('#Employee_tribeid').val('');$('#tribe_name').val('');$('#Employee_referenceby').val('');$('#Employee_joindate').val('');$('#Employee_employeestatusid').val('');$('#employeestatus_name').val('');$('#Employee_bodyheight').val('');$('#Employee_bodyweight').val('');$('#Employee_dresssize').val('');$('#Employee_resigndate').val('');$('#Employee_shoesize').val('');
$('#Employee_levelorgid').val('');$('#levelorgname').val('');
$('#Employee_email').val('');
$('#Employee_phoneno').val('');
$('#Employee_hpno').val('');
$('#Employee_alternateemail').val('');
$('#Employee_taxno').val('');
$('#Employee_hpno2').val('');
$('#Employee_medical').val('');
$('#Employee_accountno').val('');
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function editdata()
{jQuery.ajax({'url':'/smlive/index.php?r=employee/update','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Employee_employeeid').val(data.employeeid);$('#Employee_addressbookid').val(data.addressbookid);$('#Employee_fullname').val(data.fullname);$('#Employee_oldnik').val(data.oldnik);$('#Employee_orgstructureid').val(data.orgstructureid);$('#orgstructure_name').val(data.structurename);$('#Employee_positionid').val(data.positionid);$('#position_name').val(data.positionname);$('#Employee_employeetypeid').val(data.employeetypeid);$('#employeetype_name').val(data.employeetypename);$('#Employee_sexid').val(data.sexid);$('#sex_name').val(data.sexname);$('#Employee_bloodtypeid').val(data.bloodtypeid);$('#bloodtype_name').val(data.bloodtypename);$('#Employee_birthcityid').val(data.birthcityid);$('#birthcity_name').val(data.birthcityname);$('#Employee_birthdate').val(data.birthdate);$('#Employee_religionid').val(data.religionid);$('#religion_name').val(data.religionname);$('#Employee_maritalstatusid').val(data.maritalstatusid);$('#maritalstatus_name').val(data.maritalstatusname);$('#Employee_tribeid').val(data.tribeid);$('#tribe_name').val(data.tribename);$('#Employee_referenceby').val(data.referenceby);$('#Employee_joindate').val(data.joindate);$('#Employee_employeestatusid').val(data.employeestatusid);$('#employeestatus_name').val(data.employeestatusname);
if(data.istrial=='1')
{$('#Employee_istrial').checked='checked';}
$('#Employee_bodyheight').val(data.bodyheight);$('#Employee_bodyweight').val(data.bodyweight);$('#Employee_dresssize').val(data.dresssize);$('#Employee_resigndate').val(data.resigndate);$('#Employee_shoesize').val(data.shoesize);
$('#Employee_levelorgid').val(data.levelorgid);$('#levelorgname').val(data.levelorgname);
$('#Employee_email').val(data.email);
$('#Employee_phoneno').val(data.phoneno);
$('#Employee_hpno').val(data.hpno);
$('#Employee_alternateemail').val(data.alternateemail);
$('#Employee_hpno2').val(data.hpno2);
$('#Employee_medical').val(data.medical);
$('#Employee_taxno').val(data.taxno);
$('#Employee_accountno').val(data.accountno);
if(data.recordstatus=='1')
{$('#recordstatus').checked='checked';}
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=employee/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=employee/help',
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
	window.open('/smlive/index.php?r=employee/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#messages');
		new AjaxUpload(btnUpload, {
			action: 'index.php?r=employee/upload',
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
	
	$(function(){
		var btnUpload=$('#upload2');
		var status=$('#messages');
		new AjaxUpload(btnUpload, {
			action: 'index.php?r=employee/uploadphoto',
			name: 'uploadgambar',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
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
			  'orgstructure'=>$orgstructure,
			  'position'=>$position,
			  'employeetype'=>$employeetype,
			  'sex'=>$sex,
			  'bloodtype'=>$bloodtype,
			  'birthcity'=>$birthcity,
			  'religion'=>$religion,
			  'maritalstatus'=>$maritalstatus,
			  'tribe'=>$tribe,
			  'employeestatus'=>$employeestatus,
    'levelorg'=>$levelorg)); ?>
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
<h1>Transaction: Employees</h1>
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
<li>
<a id="upload2" class="hover" style="cursor: pointer; text-decoration: underline; padding-top:15px;  " title="upload gamber">
<img src="images/up-gam.png" alt="">
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
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'employeeid',
		'visible'=>false, 
		'header'=>'ID',
		'value'=>'$data->employeeid',
		'htmlOptions'=>array('width'=>'1%'),
	),
        	array(
            'name'=>'employeeid',
			'header'=>'Picture',
             'type'=>'image',
             'value'=>'"images/employee/photo-" . $data->oldnik . ".jpg"',
        ),
		array(
		'class'=>'ext.CountColumn',
		'name'=>'fullname',
		'visible'=>true, 
		'value'=>'$data->fullname',
		'footer'=>true
	),
		'oldnik',
		array('name'=>'orgstructureid', 'value'=>'($data->orgstructure!==null)?$data->orgstructure->structurename:""'),
		array('name'=>'positionid', 'value'=>'($data->position!==null)?$data->position->positionname:""'),
		array('name'=>'levelorgid', 'value'=>'($data->levelorg!==null)?$data->levelorg->levelorgname:""'),
		array('name'=>'employeetypeid', 'value'=>'($data->employeetype!==null)?$data->employeetype->employeetypename:""'),
		array('name'=>'sexid', 'value'=>'($data->sex!==null)?$data->sex->sexname:""'),
		array('name'=>'birthcityid', 'value'=>'($data->birthcity!==null)?$data->birthcity->cityname:""'),
        array(
      'name'=>'birthdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->birthdate))'
     ),
		array('name'=>'religionid', 'value'=>'($data->religion!==null)?$data->religion->religionname:""'),
		array('name'=>'maritalstatusid', 'value'=>'($data->maritalstatus!==null)?$data->maritalstatus->maritalstatusname:""'),
        'referenceby',
                array(
      'name'=>'joindate',
      'type'=>'raw',
         'value'=>'($data->joindate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->joindate)):""'
     ),
		array('name'=>'employeestatusid', 'value'=>'($data->employeestatus!==null)?$data->employeestatus->employeestatusname:""'),
        'phoneno',
        'hpno',
        'hpno2',
        'taxno',
        'dplkno',
        'email',
        'alternateemail',
        array(
      'class'=>'CCheckBoxColumn',
      'name'=>'istrial',
      'selectableRows'=>'0',
      'header'=>'Is Trial',
      'checked'=>'$data->istrial'
    ),
        array(
      'name'=>'resigndate',
      'type'=>'raw',
         'value'=>'($data->resigndate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->resigndate)):""'
     ),
        'medical',
        array(
      'class'=>'CCheckBoxColumn',
      'name'=>'addressbook.recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->addressbook->recordstatus'
    ),
	),
)); 
?>
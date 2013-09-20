<?php
$this->breadcrumbs=array(
	'Applicants',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{jQuery.ajax({'url':'/smlive/index.php?r=applicant/create','data':$(this).serialize(),'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Applicant_employeeid').val('');$('#Applicant_addressbookid').val('');$('#Applicant_fullname').val('');$('#Applicant_oldnik').val('');$('#Applicant_orgstructureid').val('');$('#orgstructure_name').val('');$('#Applicant_positionid').val('');$('#position_name').val('');$('#Applicant_employeetypeid').val('');$('#employeetype_name').val('');$('#Applicant_sexid').val('');$('#sex_name').val('');$('#Applicant_bloodtypeid').val('');$('#bloodtype_name').val('');$('#Applicant_birthcityid').val('');$('#birthcity_name').val('');$('#Applicant_birthdate').val('');$('#Applicant_religionid').val('');$('#religion_name').val('');$('#Applicant_maritalstatusid').val('');$('#maritalstatus_name').val('');$('#Applicant_tribeid').val('');$('#tribe_name').val('');$('#Applicant_referenceby').val('');$('#Applicant_joindate').val('');$('#Applicant_employeestatusid').val('');$('#employeestatus_name').val('');$('#Applicant_istrial').val('');$('#Applicant_bodyheight').val('');$('#Applicant_bodyweight').val('');$('#Applicant_dresssize').val('');$('#Applicant_resigndate').val('');$('#Applicant_shoesize').val('');$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function editdata()
{jQuery.ajax({'url':'/smlive/index.php?r=applicant/update','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Applicant_employeeid').val(data.employeeid);$('#Applicant_addressbookid').val(data.addressbookid);$('#Applicant_fullname').val(data.fullname);$('#Applicant_oldnik').val(data.oldnik);$('#Applicant_orgstructureid').val(data.orgstructureid);$('#orgstructure_name').val(data.structurename);$('#Applicant_positionid').val(data.positionid);$('#position_name').val(data.positionname);$('#Applicant_employeetypeid').val(data.employeetypeid);$('#employeetype_name').val(data.employeetypename);$('#Applicant_sexid').val(data.sexid);$('#sex_name').val(data.sexname);$('#Applicant_bloodtypeid').val(data.bloodtypeid);$('#bloodtype_name').val(data.bloodtypename);$('#Applicant_birthcityid').val(data.birthcityid);$('#birthcity_name').val(data.birthcityname);$('#Applicant_birthdate').val(data.birthdate);$('#Applicant_religionid').val(data.religionid);$('#religion_name').val(data.religionname);$('#Applicant_maritalstatusid').val(data.maritalstatusid);$('#maritalstatus_name').val(data.maritalstatusname);$('#Applicant_tribeid').val(data.tribeid);$('#tribe_name').val(data.tribename);$('#Applicant_referenceby').val(data.referenceby);$('#Applicant_joindate').val(data.joindate);$('#Applicant_employeestatusid').val(data.employeestatusid);$('#employeestatus_name').val(data.employeestatusname);$('#Applicant_istrial').val(data.istrial);$('#Applicant_bodyheight').val(data.bodyheight);$('#Applicant_bodyweight').val(data.bodyweight);$('#Applicant_dresssize').val(data.dresssize);$('#Applicant_resigndate').val(data.resigndate);$('#Applicant_shoesize').val(data.shoesize);if(data.istrial=='1')
{document.forms[1].elements[38].checked=true;}
else
{document.forms[1].elements[38].checked=false;}
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=applicant/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function approvedata()
{jQuery.ajax({'url':'/smlive/index.php?r=applicant/approve','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=applicant/help',
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
			  'employeestatus'=>$employeestatus)); ?>
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
<h1>Applicants</h1>
<div id="toolbar">
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
$imgapprove=CHtml::image(Yii::app()->request->baseUrl.'/images/approve.png');
echo CHtml::link($imgapprove,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{approvedata()}",
   'title'=>Yii::t('app','approve data')
));
$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>Yii::t('app','delete data')
));
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata(); $('#createdialog').dialog('open');}",
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
?>Record/page <?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?><?php
$this->widget('ext.EAjaxUpload.EAjaxUpload',
                 array(
                       'id'=>'uploadFile',
                       'config'=>array(
                                       'action'=>'index.php?r=applicant/upload',
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
	array('name'=>'employeeid', 'visible'=>false,'header'=>'ID','value'=>'$data->employeeid','htmlOptions'=>array('width'=>'1%')),
		array('name'=>'addressbookid', 'header'=>'Full Name','value'=>'($data->addressbook!==null)?$data->addressbook->fullname:""'),
		'oldnik',
		'newnik',
		array('name'=>'orgstructureid', 'header'=>'Structure','value'=>'($data->orgstructure!==null)?$data->orgstructure->structurename:""'),
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
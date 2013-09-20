<?php
$this->breadcrumbs=array(
	'Employeebenefits',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('employeebenefit/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#Employeebenefit_employeebenefitid').val(data.employeebenefitid);
					$('#Employeebenefit_employeeid').val('');
					$('#fullname').val('');
					$('#Employeebenefit_currencyid').val('');
					$('#currencyname').val('');
					$('#Employeebenefit_ratevalue').val('');
document.forms[2].elements[1].value=data.employeebenefitid;
$.fn.yiiGridView.update('detaildatagrid',{data:{'Employeebenefitdetail[employeebenefitid]':data.employeebenefitid}});
                          // Here is the trick: on submit-> once again this function!
                     $('#createdialog').dialog('open');
                }
                else
                {
                   document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function editdata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('employeebenefit/update'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#Employeebenefit_employeebenefitid').val(data.employeebenefitid);
					$('#Employeebenefit_employeeid').val(data.employeeid);
					$('#fullname').val(data.fullname);
					$('#Employeebenefit_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Employeebenefit_ratevalue').val(data.ratevalue);
if (data.recordstatus == '1')
					{
					  document.forms[1].elements[9].checked=true;
					}
					else
					{
					  document.forms[1].elements[9].checked=false;
					}
					document.forms[2].elements[1].value=data.employeebenefitid;
$.fn.yiiGridView.update('detaildatagrid',{data:{'Employeebenefitdetail[employeebenefitid]':data.employeebenefitid}});
                          // Here is the trick: on submit-> once again this function!
                     $('#createdialog').dialog('open');
                }
                else
                {
                    document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function deletedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('employeebenefit/delete'),
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
			'url'=>array('employeebenefit/approve'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
if (data.status == 'failure')
                {
                document.getElementById('messages').innerHTML = data.div;
            } }",
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
function showdetail() {
    $.fn.yiiGridView.update('indatagrid', {
                    data: {
                        'Employeebenefitdetail[employeebenefitid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=employeebenefit/help',
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
	window.open('/smlive/index.php?r=employeebenefit/download');
}
</script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#messagesku');
		new AjaxUpload(btnUpload, {
			action: 'index.php?r=employeebenefit/upload',
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
				  'employeebenefitdetail'=>$employeebenefitdetail)); ?>
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
<h1>Transaction: Employee Benefit</h1>
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
?>
<div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></ul></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->Searchwstatus(),
	'filter'=>$model,
  'selectableRows'=>1,
    'selectionChanged'=>'showdetail',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'employeebenefitid','visible'=>false,'header'=>'ID','value'=>'$data->employeebenefitid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'employeeid', 'value'=>'$data->employee->fullname'),
		array('name'=>'currencyid', 'value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
array(
      'name'=>'ratevalue',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->ratevalue)',
     ),
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
	'id'=>'indatagrid',
	'dataProvider'=>$employeebenefitdetail->search(),
  'selectableRows'=>0,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'employeebenefitdetailid', 'visible'=>false, 'header'=>'ID','value'=>'$data->employeebenefitdetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'wagetypeid', 'value'=>'$data->wagetype->wagename'),
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
        'reason',
        array(
      'name'=>'amount',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->amount)',
     ),
        array(
      'class'=>'CCheckBoxColumn',
      'name'=>'isfinal',
      'selectableRows'=>'0',
      'header'=>'Is Final',
      'checked'=>'$data->isfinal'
    ),
  ),
));
?>
<div id="messagesku"></div>
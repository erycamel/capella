<?php
$this->breadcrumbs=array(
	'Productbasics',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('productbasic/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#Productbasic_productbasicid').val('');
					$('#Productbasic_productid').val('');
					$('#productname').val('');
					$('#Productbasic_baseuom').val('');
					$('#uomcode').val('');
					$('#Productbasic_materialgroupid').val('');
					$('#materialgroupcode').val('');
					$('#Productbasic_materialgroupid').val('');
					$('#materialgroupcode').val('');
					$('#Productbasic_oldmatno').val('');
					$('#Productbasic_divisionid').val('');
					$('#divisionname').val('');
					$('#Productbasic_grossweight').val('');
					$('#Productbasic_weightunit').val('');
					$('#weightuomcode').val('');
					$('#Productbasic_netweight').val('');
					$('#Productbasic_volume').val('');
					$('#Productbasic_volumeunit').val('');
					$('#volumeuomcode').val('');
					$('#Productbasic_sizedimension').val('');
					$('#Productbasic_divisionid').val('');
					$('#divisionname').val('');
					$('#Productbasic_materialpackage').val('');
					$('#materialname').val('');
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
			'url'=>array('productbasic/update'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#Productbasic_productbasicid').val(data.productbasicid);
					$('#Productbasic_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Productbasic_baseuom').val(data.baseuom);
					$('#uomcode').val(data.uomcode);
					$('#Productbasic_materialgroupid').val(data.materialgroupid);
					$('#materialgroupcode').val(data.materialgroupcode);
					$('#Productbasic_materialgroupid').val(data.materialgroupid);
					$('#materialgroupcode').val(data.materialgroupcode);
					$('#Productbasic_oldmatno').val(data.oldmatno);
					$('#Productbasic_divisionid').val(data.divisionid);
					$('#divisionname').val(data.divisionname);
					$('#Productbasic_grossweight').val(data.grossweight);
					$('#Productbasic_weightunit').val(data.weightunit);
					$('#weightuomcode').val(data.weightuomcode);
					$('#Productbasic_netweight').val(data.netweight);
					$('#Productbasic_volume').val(data.volume);
					$('#Productbasic_volumeunit').val(data.volumeunit);
					$('#volumeuomcode').val(data.volumeuomcode);
					$('#Productbasic_sizedimension').val(data.sizedimension);
					$('#Productbasic_divisionid').val(data.divisionid);
					$('#divisionname').val(data.divisioncode);
					$('#Productbasic_materialpackage').val(data.materialpackage);
					$('#materialname').val(data.materialpackagename);
					if (data.recordstatus == '1')
					{
					  document.forms[1].elements[26].checked=true;
					}
					else
					{
					  document.forms[1].elements[26].checked=false;
					}
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
			'url'=>array('productbasic/delete'),
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
function refreshdata()
{
    $.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=productbasic/help',
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
	window.open('/smlive/index.php?r=productbasic/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
				  'product'=>$product,
				  'baseuom'=>$baseuom,
				  'materialgroup'=>$materialgroup,
				  'division'=>$division,
				  'weightunit'=>$weightunit,
				  'volumeunit'=>$volumeunit,
				  'materialpackage'=>$materialpackage)); ?>
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
<h1>Parameter: Material - Detail Data</h1>
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
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'productbasicid', 'visible'=>false,'header'=>'ID','value'=>'$data->productbasicid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
	array(
            'name'=>'product.productpic',
			'header'=>'Picture',
             'type'=>'image',
             'value'=>'"images/material/" . $data->product->productpic',
        ),
	array('name'=>'baseuom', 'value'=>'($data->baseuom0!==null)?$data->baseuom0->uomcode:""'),
	array('name'=>'materialgroupid', 'value'=>'($data->materialgroup!==null)?$data->materialgroup->materialgroupcode:""'),
	'oldmatno',
	array('name'=>'divisionid', 'value'=>'($data->division!==null)?$data->division->divisioncode:""'),
	'sizedimension',
	'grossweight',
	'netweight',
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


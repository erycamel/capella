<?php
$this->breadcrumbs=array(
	'Pocheaders',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('pocheader/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#Pocheader_pocheaderid').val(data.pocheaderid);
					$('#Pocheader_pocno').val('');
					$('#Pocheader_pocdate').val('');
					$('#Pocheader_postdate').val('');
					$('#Pocheader_addressbookid').val('');
					$('#fullname').val('');
					$('#Pocheader_sono').val('');
					$('#Pocheader_contractno').val('');
					$('#Pocheader_woino').val('');
					$('#Pocheader_deliverydate').val('');
					$('#Pocheader_testdate').val('');
					$('#Pocheader_qcdate').val('');
					$('#Pocheader_docdate').val('');
					$('#Pocheader_piccust').val('');
					$('#Pocheader_phoneno').val('');
					$('#Pocheader_projecttypeid').val('');
					$('#protypedescription').val('');
document.forms[2].elements[1].value=data.pocheaderid;
$.fn.yiiGridView.update('detaildatagrid',{data:{'Pocdetail[pocheaderid]':data.pocheaderid}});
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
			'url'=>array('pocheader/update'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#Pocheader_pocheaderid').val(data.pocheaderid);
					$('#Pocheader_pocno').val(data.pocno);
					$('#Pocheader_pocdate').val(data.pocdate);
					$('#Pocheader_postdate').val(data.postdate);
					$('#Pocheader_addressbookid').val(data.addressbookid);
					$('#fullname').val(data.fullname);
					$('#Pocheader_sono').val(data.sono);
					$('#Pocheader_contractno').val(data.contractno);
					$('#Pocheader_woino').val(data.woino);
					$('#Pocheader_deliverydate').val(data.deliverydate);
					$('#Pocheader_testdate').val(data.testdate);
					$('#Pocheader_qcdate').val(data.qcdate);
					$('#Pocheader_docdate').val(data.docdate);
					$('#Pocheader_piccust').val(data.piccust);
					$('#Pocheader_phoneno').val(data.phoneno);
					$('#Pocheader_projecttypeid').val(data.projecttypeid);
					$('#protypedescription').val(data.protypedescription);
					if (data.recordstatus == '1') {
                    document.forms[1].elements[19].checked = true;
                }
                else {
                    document.forms[1].elements[19].checked = false;
                }
document.forms[2].elements[1].value=data.pocheaderid;
$.fn.yiiGridView.update('detaildatagrid',{data:{'Pocdetail[pocheaderid]':data.pocheaderid}});
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
			'url'=>array('pocheader/delete'),
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
			'url'=>array('pocheader/approve'),
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
        'url': '/smlive/index.php?r=pocheader/help',
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
                        'Pocdetail[pocheaderid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
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
                  'pocdetail'=>$this->pocdetail,
                  'customer'=>$this->customer,
                  'product'=>$this->product,
                  'unitofmeasure'=>$this->unitofmeasure,
                    'currency'=>$this->currency,
    'projecttype'=>$projecttype)); ?>
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
<h1>PO Customer</h1>
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
echo CHtml::link($imgdown,array('/pocheader/download'),array(
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
?>Record/page <?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?><?php
$this->widget('ext.EAjaxUpload.EAjaxUpload',
                 array(
                       'id'=>'uploadFile',
                       'config'=>array(
                                       'action'=>'index.php?r=pocheader/upload',
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
	'dataProvider'=>$model->Searchwfstatus(),
	'filter'=>$model,
    'selectionChanged'=>'showdetail',
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'pocheaderid', 'visible'=>false,'header'=>'ID','value'=>'$data->pocheaderid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'projecttypeid', 'value'=>'($data->projecttype!==null)?$data->projecttype->description:""'),
	array('name'=>'addressbookid', 'value'=>'($data->customer!==null)?$data->customer->fullname:""'),
		'pocno',
        'sono',
        'contractno',
        'woino',
        'piccust',
        'phoneno',
		'pocdate',
		'postdate',
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
	'dataProvider'=>$pocdetail->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'pocdetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->pocdetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid','value'=>'($data->product!==null)?$data->product->productname:""'),
        array(
      'name'=>'qty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
	array('name'=>'unitofmeasureid','value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
        array(
      'name'=>'price',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->price)',
     ),
	array('name'=>'currencyid','value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
        array(
      'name'=>'serviceqty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->serviceqty)',
     ),
	array('name'=>'serviceuomid','value'=>'($data->serviceuom!==null)?$data->serviceuom->uomcode:""'),
        array(
      'name'=>'serviceprice',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->serviceprice)',
     ),
	array('name'=>'servicecurrencyid','value'=>'($data->servicecurrency!==null)?$data->servicecurrency->currencyname:""'),
        'description'
  ),
));?>

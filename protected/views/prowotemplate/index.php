<?php
$this->breadcrumbs=array(
	'Prowotemplates',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{jQuery.ajax({'url':'/smlive/index.php?r=prowotemplate/create','data':$(this).serialize(),'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);$('#Prowotemplate_prowotemplateid').val('');
$('#Prowotemplate_projecttypeid').val('');
$('#protypedescription').val('');
$('#Prowotemplate_addressbookid').val('');
$('#fullname').val('');
$('#Prowotemplate_productid').val('');
$('#productname').val('');
$('#Prowotemplate_price').val('');
$('#Prowotemplate_currencyid').val('');
$('#currencyname').val('');
$('#Prowotemplate_qty').val('');
$('#Prowotemplate_unitofmeasureid').val('');
$('#uomcode').val('');
$('#Prowotemplate_serviceprice').val('');
$('#Prowotemplate_servicecurrencyid').val('');
$('#servicecurrencyname').val('');
$('#Prowotemplate_serviceqty').val('');
$('#Prowotemplate_serviceuomid').val('');
$('#serviceuomcode').val('');
$('#Prowotemplate_contractno').val('');
    $('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function editdata()
{jQuery.ajax({'url':'/smlive/index.php?r=prowotemplate/update','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{document.getElementById('messages').innerHTML='';if(data.status=='success')
{$('#createdialog div.divcreate').html(data.div);
$('#Prowotemplate_prowotemplateid').val(data.prowotemplateid);
$('#Prowotemplate_projecttypeid').val(data.projecttypeid);
$('#protypedescription').val(data.protypedescription);
$('#Prowotemplate_addressbookid').val(data.addressbookid);
$('#fullname').val(data.fullname);
$('#Prowotemplate_productid').val(data.productid);
$('#productname').val(data.productname);
$('#Prowotemplate_price').val(data.price);
$('#Prowotemplate_currencyid').val(data.currencyid);
$('#currencyname').val(data.currencyname);
$('#Prowotemplate_qty').val(data.qty);
$('#Prowotemplate_unitofmeasureid').val(data.unitofmeasureid);
$('#uomcode').val(data.uomcode);
$('#Prowotemplate_serviceprice').val(data.serviceprice);
$('#Prowotemplate_servicecurrencyid').val(data.servicecurrencyid);
$('#servicecurrencyname').val(data.servicecurrencyname);
$('#Prowotemplate_serviceqty').val(data.serviceqty);
$('#Prowotemplate_serviceuomid').val(data.serviceuomid);
$('#serviceuomcode').val(data.serviceuomcode);
$('#Prowotemplate_contractno').val(data.contractno);
if(data.recordstatus=='1')
{document.forms[1].elements[28].checked=true;}
else
{document.forms[1].elements[28].checked=false;}
$('#createdialog').dialog('open');}
else
{document.getElementById('messages').innerHTML = data.div;}},'cache':false});;return false;}
</script>
<script type="text/javascript">
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=prowotemplate/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=prowotemplate/help',
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
function printdata() {
	jQuery.ajax({
        'url': '/smlive/index.php?r=prowotemplate/print',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
//        'success': function(data) {
//            if (data.status == 'success') {
//				document.getElementById('divhelp').innerHTML = data.div;
//                $('#helpdialog').dialog('open');
//            } else {
//                document.getElementById('messages').innerHTML = data.div;
//            }
//        },
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
        'currency'=>$currency,
    'projecttype'=>$projecttype,
    'customer'=>$customer,
                  'unitofmeasure'=>$unitofmeasure,
    'product'=>$product,
                  'serviceuom'=>$this->serviceuom,
                  'servicecurrency'=>$this->servicecurrency)); ?>
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
<h1>Project Work Templates</h1>
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
$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>Yii::t('app','delete data')
));
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml::link($imgdown,array('/prowotemplate/download'),array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'title'=>Yii::t('app','download data')
));
//$imgprint=CHtml::image(Yii::app()->request->baseUrl.'/images/print.png');
//echo CHtml::link($imgprint,'#',array(
//   'style'=>'cursor: pointer; text-decoration: underline;',
//   'onclick'=>"{printdata()}",
//	'title'=>Yii::t('app','print data')
//));
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
                                       'action'=>'index.php?r=prowotemplate/upload',
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
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'prowotemplateid',
    ),
	array('name'=>'prowotemplateid', 'value'=>'$data->prowotemplateid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'projecttypeid', 'value'=>'($data->projecttype!==null)?$data->projecttype->description:""'),
	array('name'=>'addressbookid', 'value'=>'$data->customer->fullname'),
        'contractno',
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
        array(
      'name'=>'qty',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
        	array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
        array(
      'name'=>'price',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->price)',
     ),
	array('name'=>'currencyid', 'value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
        array(
      'name'=>'serviceqty',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->serviceqty)',
     ),
        	array('name'=>'serviceuomid', 'value'=>'($data->serviceuom!==null)?$data->serviceuom->uomcode:""'),
        array(
      'name'=>'serviceprice',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->serviceprice)',
     ),
	array('name'=>'servicecurrencyid', 'value'=>'($data->servicecurrency!==null)?$data->servicecurrency->currencyname:""'),
		array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->recordstatus'
    ),
	), 
)); ?>

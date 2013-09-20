<?php
$this->breadcrumbs=array(
	'Tikitrans',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('tikitrans/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messagediv').innerHTML = '';
                if (data.status == 'failure')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#yt7').val('Create');
					$('#Tikitrans_airwaybillno').val('');
					$('#Tikitrans_shipcompany').val('');
					$('#Tikitrans_rcvcompany').val('');
					$('#Tikitrans_shipaddress').val('');
					$('#Tikitrans_rcvaddress').val('');
					$('#Tikitrans_absstatusid').val('');
					$('#Tikitrans_shipcityid').val('');
					$('#shipcity_name').val('');
					$('#Tikitrans_rcvcityid').val('');
					$('#rcvcity_name').val('');
					$('#Tikitrans_shipprovinceid').val('');
					$('#shipprovincename').val('');
					$('#Tikitrans_rcvprovinceid').val('');
					$('#rcvprovince_name').val('');
					$('#Tikitrans_shipcountryid').val('');
					$('#shipcountryname').val('');
					$('#Tikitrans_rcvcountryid').val('');
					$('#rcvcountry_name').val('');
					$('#Tikitrans_shipzipcode').val('');
					$('#Tikitrans_rcvzipcode').val('');
					$('#Tikitrans_shipname').val('');
					$('#Tikitrans_rcvattention').val('');
					$('#Tikitrans_shiptelno').val('');
					$('#Tikitrans_rcvtelno').val('');
					$('#Tikitrans_descofship').val('');
					$('#Tikitrans_deliveryinst').val('');
					$('#Tikitrans_paymentmethodid').val('');
					$('#paymentmethod_name').val('');
					$('#Tikitrans_charges').val('');
					  $('#Tikitrans_recordstatus').checked='checked';
                    $('#createdialog div.divcreate form').submit(adddata);
                }
                else
                {
                    $('#createdialog div.divcreate').html(data.div);
                    setTimeout(\"$('#createdialog').dialog('close') \",3000);
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
			'url'=>array('tikitrans/update'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("tikitrans-grid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messagediv').innerHTML = '';
                if (data.status == 'failure')
                {
                    $('#createdialog div.divcreate').html(data.div);
					$('#yt7').val('Save');
					$('#Tikitrans_airwaybillno').val(data.airwaybillno);
					$('#Tikitrans_shipcompany').val(data.shipcompany);
					$('#Tikitrans_rcvcompany').val(data.rcvcompany);
					$('#Tikitrans_shipaddress').val(data.shipaddress);
					$('#Tikitrans_rcvaddress').val(data.rcvaddress);
					$('#Tikitrans_shipcityid').val(data.shipcityid);
					$('#shipcity_name').val(data.shipcityname);
					$('#Tikitrans_rcvcityid').val(data.rcvcityid);
					$('#rcvcity_name').val(data.rcvcityname);
					$('#Tikitrans_shipprovinceid').val(data.shipprovinceid);
					$('#shipprovince_name').val(data.shipprovincename);
					$('#Tikitrans_rcvprovinceid').val(data.rcvprovinceid);
					$('#rcvprovince_name').val(data.rcvprovincename);
					$('#Tikitrans_shipcountryid').val(data.shipcountryid);
					$('#shipcountry_name').val(data.shipcountryname);
					$('#Tikitrans_rcvcountryid').val(data.rcvcountryid);
					$('#rcvcountry_name').val(data.rcvcountryname);
					$('#Tikitrans_shipzipcode').val(data.shipzipcode);
					$('#Tikitrans_rcvzipcode').val(data.rcvzipcode);
					$('#Tikitrans_shipname').val(data.shipname);
					$('#Tikitrans_rcvattention').val(data.rcvattention);
					$('#Tikitrans_shiptelno').val(data.shiptelno);
					$('#Tikitrans_rcvtelno').val(data.rcvtelno);
					$('#Tikitrans_descofship').val(data.descofship);
					$('#Tikitrans_deliveryinst').val(data.deliveryinst);
					$('#Tikitrans_paymentmethodid').val(data.paymentmethodid);
					$('#paymentmethod_name').val(data.paymentname);
					$('#Tikitrans_charges').val(data.charges);
					if (data.recordstatus == '1')
					{
					  $('#Tikitrans_recordstatus').val(data.recordstatus);
					}
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog div.divcreate form').submit(editdata);
                }
                else
                {
                    $('#createdialog div.divcreate').html(data.div);
                    setTimeout(\"$('#createdialog').dialog('close') \",3000);
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
			'url'=>array('tikitrans/delete'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("tikitrans-grid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('tikitrans-grid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata()
{
    $.fn.yiiGridView.update('tikitrans-grid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'100%',
        'height'=>550,
    ),
));?>
<div id="divcreate"></div>
<?php echo $this->renderPartial('_form', array('model'=>$model,
  'shipcity'=>$shipcity,
  'shipcountry'=>$shipcountry,
  'shipprovince'=>$shipprovince,
  'rcvcity'=>$rcvcity,
  'rcvcountry'=>$rcvcountry,
  'rcvprovince'=>$rcvprovince,
  'paymentmethod'=>$paymentmethod)); ?>
<?php $this->endWidget();?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpdialog',
    'options'=>array(
        'title'=>'Help',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>470,
    ),
));?>
<?php echo $this->renderPartial('_help'); ?>
<?php $this->endWidget();?>
<h1>Tiki Transaction</h1>
<div id="toolbar">
<?php
$imgcreate=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($imgcreate,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata(); $('#createdialog').dialog('open');
}",
	'title'=>'create new data'
));
$imgedit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($imgedit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata(); $('#createdialog').dialog('open');
}",
	'title'=>'edit selected data'
));
$imgup=CHtml::image(Yii::app()->request->baseUrl.'/images/up.png');
echo CHtml::link($imgup,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata(); $('#createdialog').dialog('open');}",
   'title'=>'upload data'
));
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata(); $('#createdialog').dialog('open');}",
   'title'=>'download selected data'
));
$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>'refresh data'
));
$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>'change status / purge selected data'
));
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"$('#helpdialog').dialog('open');",
   'title'=>'find any help of this module'
));
?>
</div>

<?php
echo CHtml::beginForm('','post',array('id'=>'person-form'));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tikitrans-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'pagerCssClass'=>Yii::app()->request->baseUrl.'/css/pager.css',
	'pager'=>array(
	  'class'=>'CLinkPager',
	  'header'=>' Record/page '.CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('tikitrans-grid',{ data:{pageSize: $(this).val() }})",
	  ))
	),
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'airwaybillno', 'header'=>'ID','value'=>'$data->airwaybillno','htmlOptions'=>array('width'=>'1%')),
		'transdate',
		'shipcompany',
		'shipname',
		array('name'=>'shipcityid', 'header'=>'Ship City','value'=>'$data->shipcity->cityname'),
		array('name'=>'shipprovinceid', 'header'=>'Ship Province','value'=>'$data->shipprovince->provincename'),
		'charges',
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->recordstatus'
    ),
	),
)); echo CHtml::endForm();
?>
<div id="message"></div>

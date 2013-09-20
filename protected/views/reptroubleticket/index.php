<?php
$this->breadcrumbs=array(
	'Troubleticketes',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
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
        'url': '/smlive/index.php?r=reptroubleticket/getdowntime',
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
	window.open('/smlive/index.php?r=reptroubleticket/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
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
<h1>Report: Trouble Ticket</h1>
<div id="toolbar">
<ul>
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
</div>
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
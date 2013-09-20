<?php
$this->breadcrumbs=array(
	'repbaols',
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
        'url': '/smlive/index.php?r=repbaol/help',
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
	window.open('/smlive/index.php?r=repbaol/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('indatagrid', {
                    data: {
                        'Baoldetail[baolid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
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
<h1>Report: Berita Acara Online (BAOL)</h1><div id="toolbar">
<ul>
<?php
$imgdownload=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdownload,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{downloaddata()}",
   'title'=>Yii::t('app','refresh data')
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
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->Search(),
	'filter'=>$model,
    'selectionChanged'=>'showdetail',
    'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'baolid', 'visible'=>false,'header'=>'ID','value'=>'$data-baolid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'soheaderid', 'value'=>'($data->soheader!==null)?$data->soheader->contractno:""'),
	array('name'=>'baolno', 'value'=>'$data->baolno'),
	array(
      'name'=>'baoldate',
      'type'=>'raw',
         'value'=>'($data->baoldate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->baoldate)):""'
     ),
    array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appbaol",$data->recordstatus)')
  ),
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$baoldetail->search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array('name'=>'projectid', 'value'=>'($data->project!==null)?$data->project->projectno:""'),
		array(
      'name'=>'projectid',
      'type'=>'raw',
	  'header'=>'Online Date',
         'value'=>'($data->project!==null)?($data->project->onlinedate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->project->onlinedate)):"":""'
     ),
  ),
));
?>

<?php
$this->breadcrumbs=array(
	'Reportperdays',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
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
        'url': '/smlive/index.php?r=reportperday/help',
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
function approvedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('reportperday/repair'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")',
                'statusinid'=>"js:$('#shortinid').val()",
                'statusoutid'=>"js:$('#shortoutid').val()",
                'reason'=>"js:$('#reason').val()"),
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
<h1>Report Per Days</h1>
<div id="reportperday">
<?php
echo 'Status In';echo CHtml::hiddenField('shortinid');
echo CHtml::textField('shortin');
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'absstatusin_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Payroll Period'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$absstatus=new Absstatus('search');
	 $absstatus->unsetAttributes();  // clear any default values
	  if(isset($_GET['Absstatus']))
		$absstatus->attributes=$_GET['Absstatus'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'payrollperiod-grid',
      'dataProvider'=>$absstatus->Search(),
      'filter'=>$absstatus,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#absstatusin_dialog\").dialog(\"close\"); $(\"#shortin\").val(\"$data->shortstat\");$(\"#shortinid\").val(\"$data->absstatusid\");
		  "))',
          ),
	array('name'=>'absstatusid', 'visible'=>false,'header'=>'ID','value'=>'$data->absstatusid','htmlOptions'=>array('width'=>'1%')),
        'shortstat',
          'longstat',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#absstatusin_dialog").dialog("open"); return false;',
                       ));
    echo 'Status Out';echo CHtml::hiddenField('shortoutid');
echo CHtml::textField('shortout');
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'absstatusout_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Payroll Period'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$absstatus=new Absstatus('search');
	 $absstatus->unsetAttributes();  // clear any default values
	  if(isset($_GET['Absstatus']))
		$absstatus->attributes=$_GET['Absstatus'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'payrollperiod1-grid',
      'dataProvider'=>$absstatus->Search(),
      'filter'=>$absstatus,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#absstatusout_dialog\").dialog(\"close\"); $(\"#shortout\").val(\"$data->shortstat\");$(\"#shortoutid\").val(\"$data->absstatusid\");
		  "))',
          ),
	array('name'=>'absstatusid', 'visible'=>false,'header'=>'ID','value'=>'$data->absstatusid','htmlOptions'=>array('width'=>'1%')),
        'shortstat',
          'longstat',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#absstatusout_dialog").dialog("open"); return false;',
                       ));
    echo 'Reason';echo Chtml::textfield('reason');
$imgapp=CHtml::image(Yii::app()->request->baseUrl.'/images/save.png');
echo CHtml::link($imgapp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{approvedata()}",
	'title'=>Yii::t('app','approve data')
));
?>
<?php
$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>'refresh data'
));
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(1)}",
   'title'=>Yii::t('app','help')
));
?><div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows'=>2,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'reportperdayid', 'visible'=>false, 'header'=>'ID','value'=>'$data->reportperdayid','htmlOptions'=>array('width'=>'1%')),
		//'employeeid',
		'fullname',
		'oldnik',
		'fulldivision',
		'absdate',
		'hourin',
		'hourout',
		//'absscheduleid',
		'schedulename',
	array('name'=>'statusin','value'=>'$data->statusin'),
	array('name'=>'statusout','value'=>'$data->statusout'),
        'reason'
	),
)); 
?>
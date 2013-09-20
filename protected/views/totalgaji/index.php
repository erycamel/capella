<?php
$this->breadcrumbs=array(
	'Report Total Gaji',
);
?>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=payrollprocess/help',
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
<h1>Report: Total Gaji</h1>
<div id="toolbar">
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(1)}",
   'title'=>Yii::t('app','help')
));?></div>
<div id="formabs">
<form action="index.php?r=totalgaji/index" method="POST">
Payroll Period : <input type="hidden" name="payrollperiodid" id="payrollperiodid"  />
	  <input type="text" name="payrollperiodname" id="payrollperiodname" title="Enter Schedule name" readonly>
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'payrollperiod_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Payroll Period'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$payrollperiod=new Payrollperiod('search');
	 $payrollperiod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Payrollperiod']))
		$payrollperiod->attributes=$_GET['Payrollperiod'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'payrollperiod-grid',
      'dataProvider'=>$payrollperiod->Search(),
      'filter'=>$payrollperiod,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#payrollperiod_dialog\").dialog(\"close\"); $(\"#payrollperiodname\").val(\"$data->payrollperiodname\");$(\"#payrollperiodid\").val(\"$data->payrollperiodid\");
		  "))',
          ),
	array('name'=>'payrollperiodid', 'visible'=>false,'header'=>'ID','value'=>'$data->payrollperiodid','htmlOptions'=>array('width'=>'1%')),
        'payrollperiodname',
        array(
      'name'=>'startdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->startdate))'
     ),
        array(
      'name'=>'enddate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->enddate))'
     ),
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#payrollperiod_dialog").dialog("open"); return false;',
                       ))?>
          <button name="submit" type="submit">Submit</button>
</form>
</div>


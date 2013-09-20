<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'distchannel-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'distchannelid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'salesorgid'); ?>
		<?php echo $form->hiddenField($model,'salesorgid'); ?>
	  <input type="text" name="sched_name" id="salesorgcode" title="Enter Schedule name" readonly value="<?php echo (Salesorg::model()->findByPk($model->salesorgid)!==null)?Salesorg::model()->findByPk($model->salesorgid)->description:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'salesorg_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Sales Organization'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'salesorg-grid',
      'dataProvider'=>$salesorg->searchwstatus(),
      'filter'=>$salesorg,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_salesorg",
          "id" => "send_salesorg",
          "onClick" => "$(\"#salesorg_dialog\").dialog(\"close\"); $(\"#salesorgcode\").val(\"$data->description\"); $(\"#Distchannel_salesorgid\").val(\"$data->salesorgid\");
		  "))',
          ),
        'salesorgid',
        'salesorgcode',
        'description',
        array(
          'class'=>'CCheckBoxColumn',
          'name'=>'recordstatus',
          'selectableRows'=>'0',
          'header'=>'Record Status',
          'checked'=>'$data->recordstatus'
        ),
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#salesorg_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'salesorgid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'distchannelcode'); ?>
		<?php echo $form->textField($model,'distchannelcode',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'distchannelcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('distchannel/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
              document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
		<?php echo CHtml::ajaxSubmitButton('Cancel',
		array('distchannel/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
              document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
        </td>
      </tr>
    </table>
<?php $this->endWidget(); ?>
</div><!-- form -->
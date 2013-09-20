<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workflow-form',
	'enableAjaxValidation'=>false,
)); ?>
      <?php
    $imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));?>

<?php echo $form->hiddenField($model,'workflowid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'wfname'); ?>
		<?php echo $form->textField($model,'wfname',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'wfname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wfdesc'); ?>
		<?php echo $form->textField($model,'wfdesc',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'wfdesc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wfminstat'); ?>
		<?php echo $form->textField($model,'wfminstat'); ?>
		<?php echo $form->error($model,'wfminstat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wfmaxstat'); ?>
		<?php echo $form->textField($model,'wfmaxstat'); ?>
		<?php echo $form->error($model,'wfmaxstat'); ?>
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
		array('workflow/write'),
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
		array('workflow/cancelwrite'),
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
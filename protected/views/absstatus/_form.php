<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'absstatus-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
<?php echo $form->hiddenField($model,'absstatusid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'shortstat'); ?>
		<?php echo $form->textField($model,'shortstat',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'shortstat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'longstat'); ?>
		<?php echo $form->textField($model,'longstat',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'longstat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isin'); ?>
		<?php echo $form->checkBox($model,'isin'); ?>
		<?php echo $form->error($model,'isin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'priority'); ?>
		<?php echo $form->textField($model,'priority'); ?>
		<?php echo $form->error($model,'priority'); ?>
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
		array('absstatus/write'),
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
		array('absstatus/cancelwrite'),
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

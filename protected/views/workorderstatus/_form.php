<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workorderstatus-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
<?php echo $form->hiddenField($model,'workorderstatusid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'statusname'); ?>
		<?php echo $form->textField($model,'statusname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'statusname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<div class="row buttons">
<?php echo CHtml::ajaxSubmitButton('Save',
		array('workorderstatus/write'),
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
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
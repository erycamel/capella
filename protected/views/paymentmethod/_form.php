<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'paymentmethod-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'paymentmethodid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'paycode'); ?>
		<?php echo $form->textField($model,'paycode',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'paycode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paymentname'); ?>
		<?php echo $form->textField($model,'paymentname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'paymentname'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'paydays'); ?>
		<?php echo $form->textField($model,'paydays'); ?>
		<?php echo $form->error($model,'paydays'); ?>
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
		array('paymentmethod/write'),
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
		array('paymentmethod/cancelwrite'),
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
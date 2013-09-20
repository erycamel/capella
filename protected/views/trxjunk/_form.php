<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trxjunk-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'trxdate'); ?>
		<?php echo $form->textField($model,'trxdate'); ?>
		<?php echo $form->error($model,'trxdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'senderx'); ?>
		<?php echo $form->textArea($model,'senderx',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'senderx'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textdecoded'); ?>
		<?php echo $form->textArea($model,'textdecoded',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'textdecoded'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
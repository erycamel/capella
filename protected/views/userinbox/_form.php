<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userinbox-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'useraccessid'); ?>
		<?php echo $form->textField($model,'useraccessid'); ?>
		<?php echo $form->error($model,'useraccessid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'messages'); ?>
		<?php echo $form->textArea($model,'messages',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'messages'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->textField($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
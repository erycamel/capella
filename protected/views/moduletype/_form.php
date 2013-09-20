<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'moduletype-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'moduletypename'); ?>
		<?php echo $form->textField($model,'moduletypename',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'moduletypename'); ?>
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
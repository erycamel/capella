<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prodtranstype-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'prodtranscode'); ?>
		<?php echo $form->textField($model,'prodtranscode',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'prodtranscode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modulename'); ?>
		<?php echo $form->textField($model,'modulename',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'modulename'); ?>
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
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lockercheck-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lockerboxid'); ?>
		<?php echo $form->textField($model,'lockerboxid'); ?>
		<?php echo $form->error($model,'lockerboxid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lockerkeyid'); ?>
		<?php echo $form->textField($model,'lockerkeyid'); ?>
		<?php echo $form->error($model,'lockerkeyid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lockerstaffid'); ?>
		<?php echo $form->textField($model,'lockerstaffid'); ?>
		<?php echo $form->error($model,'lockerstaffid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'checkdate'); ?>
		<?php echo $form->textField($model,'checkdate'); ?>
		<?php echo $form->error($model,'checkdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'employeeid'); ?>
		<?php echo $form->textField($model,'employeeid'); ?>
		<?php echo $form->error($model,'employeeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fullname'); ?>
		<?php echo $form->textField($model,'fullname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'fullname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oldnik'); ?>
		<?php echo $form->textField($model,'oldnik',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'oldnik'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'newnik'); ?>
		<?php echo $form->textField($model,'newnik',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'newnik'); ?>
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
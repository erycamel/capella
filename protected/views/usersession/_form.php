<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usersession-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'useraccessid'); ?>
		<?php echo $form->textField($model,'useraccessid',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'useraccessid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menuaccessid'); ?>
		<?php echo $form->textField($model,'menuaccessid',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'menuaccessid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usertime'); ?>
		<?php echo $form->textField($model,'usertime'); ?>
		<?php echo $form->error($model,'usertime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sessioncode'); ?>
		<?php echo $form->textField($model,'sessioncode'); ?>
		<?php echo $form->error($model,'sessioncode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->textField($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ipaddress'); ?>
		<?php echo $form->textField($model,'ipaddress',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'ipaddress'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
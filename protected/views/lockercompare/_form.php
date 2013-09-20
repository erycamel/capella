<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lockercompare-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lockerkeyid'); ?>
		<?php echo $form->textField($model,'lockerkeyid'); ?>
		<?php echo $form->error($model,'lockerkeyid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'keynum'); ?>
		<?php echo $form->textField($model,'keynum',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'keynum'); ?>
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
		<?php echo $form->labelEx($model,'fulldivision'); ?>
		<?php echo $form->textField($model,'fulldivision',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'fulldivision'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'absscheduleid'); ?>
		<?php echo $form->textField($model,'absscheduleid'); ?>
		<?php echo $form->error($model,'absscheduleid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'schedulename'); ?>
		<?php echo $form->textField($model,'schedulename',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'schedulename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transdate'); ?>
		<?php echo $form->textField($model,'transdate'); ?>
		<?php echo $form->error($model,'transdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'takedate'); ?>
		<?php echo $form->textField($model,'takedate',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'takedate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'checkdate'); ?>
		<?php echo $form->textField($model,'checkdate',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'checkdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'returndate'); ?>
		<?php echo $form->textField($model,'returndate',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'returndate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
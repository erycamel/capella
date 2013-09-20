<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'lockercheckid'); ?>
		<?php echo $form->textField($model,'lockercheckid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lockerboxid'); ?>
		<?php echo $form->textField($model,'lockerboxid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lockerkeyid'); ?>
		<?php echo $form->textField($model,'lockerkeyid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lockerstaffid'); ?>
		<?php echo $form->textField($model,'lockerstaffid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'checkdate'); ?>
		<?php echo $form->textField($model,'checkdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employeeid'); ?>
		<?php echo $form->textField($model,'employeeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fullname'); ?>
		<?php echo $form->textField($model,'fullname',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oldnik'); ?>
		<?php echo $form->textField($model,'oldnik',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'newnik'); ?>
		<?php echo $form->textField($model,'newnik',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'recordstatus'); ?>
		<?php echo $form->textField($model,'recordstatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
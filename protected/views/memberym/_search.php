<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'memberymid'); ?>
		<?php echo $form->textField($model,'memberymid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'voucheragentid'); ?>
		<?php echo $form->textField($model,'voucheragentid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idym'); ?>
		<?php echo $form->textField($model,'idym',array('size'=>50,'maxlength'=>50)); ?>
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
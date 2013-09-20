<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'userinboxid'); ?>
		<?php echo $form->textField($model,'userinboxid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'useraccessid'); ?>
		<?php echo $form->textField($model,'useraccessid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'messages'); ?>
		<?php echo $form->textArea($model,'messages',array('rows'=>6, 'cols'=>50)); ?>
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
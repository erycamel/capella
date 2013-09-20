<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'moduletypeid'); ?>
		<?php echo $form->textField($model,'moduletypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'moduletypename'); ?>
		<?php echo $form->textField($model,'moduletypename',array('size'=>50,'maxlength'=>50)); ?>
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
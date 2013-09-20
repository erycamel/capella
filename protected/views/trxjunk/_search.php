<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'trxjunkid'); ?>
		<?php echo $form->textField($model,'trxjunkid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'trxdate'); ?>
		<?php echo $form->textField($model,'trxdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'senderx'); ?>
		<?php echo $form->textArea($model,'senderx',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'textdecoded'); ?>
		<?php echo $form->textArea($model,'textdecoded',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'usersessionid'); ?>
		<?php echo $form->textField($model,'usersessionid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'useraccessid'); ?>
		<?php echo $form->textField($model,'useraccessid',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'menuaccessid'); ?>
		<?php echo $form->textField($model,'menuaccessid',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usertime'); ?>
		<?php echo $form->textField($model,'usertime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sessioncode'); ?>
		<?php echo $form->textField($model,'sessioncode'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'recordstatus'); ?>
		<?php echo $form->textField($model,'recordstatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ipaddress'); ?>
		<?php echo $form->textField($model,'ipaddress',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
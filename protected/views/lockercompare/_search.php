<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'lockercompareid'); ?>
		<?php echo $form->textField($model,'lockercompareid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lockerkeyid'); ?>
		<?php echo $form->textField($model,'lockerkeyid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'keynum'); ?>
		<?php echo $form->textField($model,'keynum',array('size'=>10,'maxlength'=>10)); ?>
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
		<?php echo $form->label($model,'fulldivision'); ?>
		<?php echo $form->textField($model,'fulldivision',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'absscheduleid'); ?>
		<?php echo $form->textField($model,'absscheduleid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'schedulename'); ?>
		<?php echo $form->textField($model,'schedulename',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transdate'); ?>
		<?php echo $form->textField($model,'transdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'takedate'); ?>
		<?php echo $form->textField($model,'takedate',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'checkdate'); ?>
		<?php echo $form->textField($model,'checkdate',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'returndate'); ?>
		<?php echo $form->textField($model,'returndate',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
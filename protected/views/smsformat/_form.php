<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'smsformat-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpmodifdialog',
    'options'=>array(
        'title'=>'Help Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<?php echo $this->renderPartial('_helpmodif'); ?>
<?php $this->endWidget();?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"$('#helpmodifdialog').dialog('open');",
));  ?>

<?php echo $form->hiddenField($model,'smsformatid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'smsname'); ?>
		<?php echo $form->textField($model,'smsname',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'smsname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formatin'); ?>
		<?php echo $form->textField($model,'formatin',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'formatin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'execproc'); ?>
		<?php echo $form->textField($model,'execproc',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'execproc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formaterror'); ?>
		<?php echo $form->textField($model,'formaterror',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'formaterror'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formatout'); ?>
		<?php echo $form->textField($model,'formatout',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'formatout'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('',
		array('smsformat/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messagediv").innerHTML = data;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
	<div id="messagediv"></div>
</div><!-- form -->

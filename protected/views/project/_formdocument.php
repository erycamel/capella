<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projectdoc-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(10)}",
));  ?>
<?php echo $form->hiddenField($model,'projectdocumentid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	

	<div class="row">
            <?php echo $form->labelEx($model,'documentname'); ?>
		<?php echo $form->textArea($model,'documentname'); ?>
		<?php echo $form->error($model,'documentname'); ?>
    </div>   
	
	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writedocument'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("documentdatagrid");
			  $("#createdialog5").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
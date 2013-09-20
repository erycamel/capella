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
   'onclick'=>"{helpdata(6)}",
));  ?>
<?php echo $form->hiddenField($model,'projectpicid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	

        <div class="row">
            <?php echo $form->labelEx($model,'picname'); ?>
		<?php echo $form->textArea($model,'picname'); ?>
		<?php echo $form->error($model,'picname'); ?>
    </div>    
	
	<div class="row">
            <?php echo $form->labelEx($model,'picdept'); ?>
		<?php echo $form->textArea($model,'picdept'); ?>
		<?php echo $form->error($model,'picdept'); ?>
    </div>   
	
	<div class="row">
            <?php echo $form->labelEx($model,'picemail'); ?>
		<?php echo $form->textArea($model,'picemail'); ?>
		<?php echo $form->error($model,'picemail'); ?>
    </div>   
	
	<div class="row">
            <?php echo $form->labelEx($model,'pictelp'); ?>
		<?php echo $form->textArea($model,'pictelp'); ?>
		<?php echo $form->error($model,'pictelp'); ?>
    </div>   
	
	<div class="row">
            <?php echo $form->labelEx($model,'picfunction'); ?>
		<?php echo $form->textArea($model,'picfunction'); ?>
		<?php echo $form->error($model,'picfunction'); ?>
    </div>   

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writepic'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("picdatagrid");
			  $("#createdialog3").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
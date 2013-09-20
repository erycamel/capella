<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'absrule-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'taxwageprogressifid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'minvalue'); ?>
    <?php echo $form->textField($model,'minvalue'); ?>
		<?php echo $form->error($model,'minvalue'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'maxvalue'); ?>
    <?php echo $form->textField($model,'maxvalue'); ?>
		<?php echo $form->error($model,'maxvalue'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'valuepercent'); ?>
    <?php echo $form->textField($model,'valuepercent'); ?> %
		<?php echo $form->error($model,'valuepercent'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
    <?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>
    
	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('taxwageprogressif/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
              document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
		<?php echo CHtml::ajaxSubmitButton('Cancel',
		array('taxwageprogressif/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
              document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
        </td>
      </tr>
    </table>
<?php $this->endWidget(); ?>
</div><!-- form -->

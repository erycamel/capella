<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'snrodet-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'snrodid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'snroid'); ?>
    <?php echo $form->dropDownList($model,'snroid', CHtml::listData(Snro::model()->findAll(), 'snroid', 'description'),
      array('prompt' => 'Select a Specific Number Range Object')); ?>
		<?php echo $form->error($model,'snroid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'curdd'); ?>
		<?php echo $form->textField($model,'curdd'); ?>
		<?php echo $form->error($model,'curdd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'curmm'); ?>
		<?php echo $form->textField($model,'curmm'); ?>
		<?php echo $form->error($model,'curmm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'curyy'); ?>
		<?php echo $form->textField($model,'curyy'); ?>
		<?php echo $form->error($model,'curyy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'curvalue'); ?>
		<?php echo $form->textField($model,'curvalue'); ?>
		<?php echo $form->error($model,'curvalue'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('snrodet/write'),
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
		array('snrodet/cancelwrite'),
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
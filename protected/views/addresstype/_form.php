<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'addresstype-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'addresstypeid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'addresstypename'); ?>
		<?php echo $form->textField($model,'addresstypename',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'addresstypename'); ?>
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
		array('addresstype/write'),
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
		array('addresstype/cancelwrite'),
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
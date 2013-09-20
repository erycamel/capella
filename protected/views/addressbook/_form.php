<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'addressbook-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'addressbookid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fullname'); ?>
		<?php echo $form->textField($model,'fullname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'fullname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iscustomer'); ?>
		<?php echo $form->checkBox($model,'iscustomer'); ?>
		<?php echo $form->error($model,'iscustomer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isemployee'); ?>
		<?php echo $form->checkBox($model,'isemployee'); ?>
		<?php echo $form->error($model,'isemployee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isapplicant'); ?>
		<?php echo $form->checkBox($model,'isapplicant'); ?>
		<?php echo $form->error($model,'isapplicant'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isvendor'); ?>
		<?php echo $form->checkBox($model,'isvendor'); ?>
		<?php echo $form->error($model,'isvendor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isinsurance'); ?>
		<?php echo $form->checkBox($model,'isinsurance'); ?>
		<?php echo $form->error($model,'isinsurance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isbank'); ?>
		<?php echo $form->checkBox($model,'isbank'); ?>
		<?php echo $form->error($model,'isbank'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ishospital'); ?>
		<?php echo $form->checkBox($model,'ishospital'); ?>
		<?php echo $form->error($model,'ishospital'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'iscatering'); ?>
		<?php echo $form->checkBox($model,'iscatering'); ?>
		<?php echo $form->error($model,'iscatering'); ?>
	</div>

    	<div class="row">
		<?php echo $form->labelEx($model,'taxno'); ?>
		<?php echo $form->textField($model,'taxno',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'taxno'); ?>
	</div>

    	<div class="row">
		<?php echo $form->labelEx($model,'abno'); ?>
		<?php echo $form->textField($model,'abno',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'abno'); ?>
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
		array('addressbook/write'),
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
		array('addressbook/cancelwrite'),
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
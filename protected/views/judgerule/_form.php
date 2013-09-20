<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'judgerule-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'judgeruleid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'statin'); ?>
    <?php echo $form->dropDownList($model,'statin', CHtml::listData(Absstatus::model()->findAll(), 'absstatusid', 'shortstat'),
    array('prompt' => 'Select a Status')); ?>
		<?php echo $form->error($model,'statin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'statout'); ?>
    <?php echo $form->dropDownList($model,'statout', CHtml::listData(Absstatus::model()->findAll(), 'absstatusid', 'shortstat'),
    array('prompt' => 'Select a Status')); ?>
		<?php echo $form->error($model,'statout'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'statjudge'); ?>
		<?php echo $form->textField($model,'statjudge',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'statjudge'); ?>
	</div>
  
  <div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkbox($model,'recordstatus',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('judgerule/write'),
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
		array('judgerule/cancelwrite'),
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

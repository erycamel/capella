<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usergroup-form',
	'enableAjaxValidation'=>true,
)); ?>
<?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'troubleticketid'); ?>
	

	<?php echo $form->errorSummary($model); ?>
	
<table>
<tr>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'serviceno'); ?>
		<?php echo CHtml::dropDownList('serviceno','',
    CHtml::listData(Project::model()->findAllBySql('select distinct serviceno from project'),'serviceno','serviceno'),
 array( 
'prompt'=>'Service No',          //
 'value'=>'',
 ));?>
		<?php echo $form->error($model,'serviceno'); ?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'customername'); ?>
		<?php echo $form->textField($model,'customername',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'customername'); ?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'unitkerja'); ?>
		<?php echo $form->textField($model,'unitkerja',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'unitkerja'); ?>
	</div>
</td>
</tr>
<tr>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'phoneno'); ?>
		<?php echo $form->textField($model,'phoneno',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'phoneno'); ?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'mobilephoneno'); ?>
		<?php echo $form->textField($model,'mobilephoneno',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'mobilephoneno'); ?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'customeraddress'); ?>
		<?php echo $form->textField($model,'customeraddress',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'customeraddress'); ?>
	</div>
</td>
</tr>
<tr>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>5,'cols'=>10)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'useraccessid'); ?>
		<?php echo CHtml::dropDownList('useraccessid','',
    CHtml::listData(Useraccess::model()->findAll(),'useraccessid','username'),
 array( 
'prompt'=>'Assign To',          //
 'value'=>'',
 ));?>
		<?php echo $form->error($model,'useraccessid'); ?>
	</div>
</td>
</tr>
</table>
	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('troubleticket/write'),
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
		array('troubleticket/cancelwrite'),
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
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'repneraca-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->hiddenField($model,'repneracaid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'accountid'); ?>
		<?php echo $form->hiddenField($model,'accountid'); ?>
    <input type="text" name="accountname" id="accountname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'account_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'account_dialog-grid',
        'dataProvider'=>$account->searchwstatus(),
        'filter'=>$account,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#account_dialog\").dialog(\"close\");
          $(\"#accountname\").val(\"$data->accountname\");
          $(\"#Repneraca_accountid\").val(\"$data->accountid\");"))',
          ),
	array('name'=>'accountid', 'visible'=>false,
        'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
		  'accountcode',
          'accountname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#account_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'accountid'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'isdebet'); ?>
		<?php echo $form->checkBox($model,'isdebet'); ?>
		<?php echo $form->error($model,'isdebet'); ?>
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
		array('repneraca/write'),
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
		array('repneraca/cancelwrite'),
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
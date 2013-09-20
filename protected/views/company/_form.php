<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
      <?php
    $imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));?>
<?php echo $form->hiddenField($model,'companyid'); ?>
	
    <table>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'companyname'); ?>
		<?php echo $form->textField($model,'companyname',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'companyname'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>5, 'cols'=>30)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>
        </td>
                <td>
          <div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'zipcode'); ?>
		<?php echo $form->textField($model,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'zipcode'); ?>
	</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'faxno'); ?>
		<?php echo $form->textField($model,'faxno',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'faxno'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'phoneno'); ?>
		<?php echo $form->textField($model,'phoneno',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'phoneno'); ?>
	</div>
        </td>
		<td>
          <div class="row">
		<?php echo $form->labelEx($model,'webaddress'); ?>
		<?php echo $form->textField($model,'webaddress',array('size'=>20,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'webaddress'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>20,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
        </td>
      </tr>        
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'taxno'); ?>
		<?php echo $form->textField($model,'taxno',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'taxno'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'currencyid'); ?>
            <?php echo $form->hiddenField($model,'currencyid'); ?>
<input type="text" name="sched_name" id="currencyname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'currency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Currency'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'catering-grid',
      'dataProvider'=>$currency->Searchwstatus(),
      'filter'=>$currency,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\");
          $(\"#currencyname\").val(\"$data->currencyname\");
          $(\"#Company_currencyid\").val(\"$data->currencyid\");
		  "))',
          ),
	array('name'=>'currencyid', 'visible'=>false,
        'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
        'currencyname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#currency_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'currencyid'); ?>
	</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>
        </td>
      </tr>
    </table>     
    <table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('company/write'),
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
		array('company/cancelwrite'),
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

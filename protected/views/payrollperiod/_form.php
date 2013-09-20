<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payrollperiod-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'payrollperiodid'); ?>
	

    	<div class="row">
		<?php echo $form->labelEx($model,'payrollperiodname'); ?>
		<?php echo $form->textField($model,'payrollperiodname',array('maxlength'=>50)); ?>
		<?php echo $form->error($model,'payrollperiodname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parentperiodid'); ?>
<?php echo $form->hiddenField($model,'parentperiodid'); ?>
                  <input type="text" name="parentperiod_name" id="parentperiod_name" readonly value="<?php echo (Payrollperiod::model()->findByPk($model->parentperiodid)!==null)?Payrollperiod::model()->findByPk($model->parentperiodid)->payrollperiodname:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'parentperiod_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Employee'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'parentperiod-grid',
                    'dataProvider'=>$parentpayrollperiod->Search(),
                    'filter'=>$parentpayrollperiod,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_parentperiod",
                        "id" => "send_parentperiod",
                        "onClick" => "$(\"#parentperiod_dialog\").dialog(\"close\"); $(\"#parentperiod_name\").val(\"$data->payrollperiodname\"); $(\"#Payrollperiod_parentperiodid\").val(\"$data->payrollperiodid\");"))',
                        ),
	array('name'=>'payrollperiodid', 'visible'=>false,'value'=>'$data->payrollperiodid','htmlOptions'=>array('width'=>'1%')),
                      'payrollperiodname',
                        'startdate',
                        'enddate'
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#parentperiod_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'parentperiodid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'startdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
		<?php echo $form->error($model,'jamsostekdate'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'enddate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'enddate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
		<?php echo $form->error($model,'jamsostekdate'); ?>
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
		array('payrollperiod/write'),
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
		array('payrollperiod/cancelwrite'),
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
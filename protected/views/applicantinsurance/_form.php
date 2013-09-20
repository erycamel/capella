<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'applicantinsurance-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'employeeinsuranceid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'employeeid'); ?>
<?php echo $form->hiddenField($model,'employeeid'); ?>
                  <input type="text" name="employee_name" id="employee_name" readonly value="<?php echo (Applicant::model()->findByPk($model->employeeid)!==null)?Applicant::model()->findByPk($model->employeeid)->fullname:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'employee_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Employee'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'employee-grid',
                    'dataProvider'=>$applicant->Searchwstatus(),
                    'filter'=>$applicant,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_employee",
                        "id" => "send_employee",
                        "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#employee_name\").val(\"$data->fullname\"); $(\"#Applicantinsurance_employeeid\").val(\"$data->employeeid\");"))',
                        ),
                      'employeeid',
                      'fullname',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#employee_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'employeeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insuranceid'); ?>
<?php echo $form->hiddenField($model,'insuranceid'); ?>
                    <input type="text" name="insurance_name" id="insurance_name" readonly value="<?php echo (Insurance::model()->findByPk($model->insuranceid)!==null)?Insurance::model()->findByPk($model->insuranceid)->fullname:''; ?>">
                    <?php
                      $this->beginWidget('zii.widgets.jui.CJuiDialog',
                       array(   'id'=>'insurance_dialog',
                                // additional javascript options for the dialog plugin
                                'options'=>array(
                                                'title'=>Yii::t('app','Insurance'),
                                                'width'=>'auto',
                                                'autoOpen'=>false,
                                                'modal'=>true,
                                                ),
                                        ));
                    $this->widget('zii.widgets.grid.CGridView', array(
                      'id'=>'insurance-grid',
                      'dataProvider'=>$insurance->Searchwstatus(),
                      'filter'=>$insurance,
                      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                      'columns'=>array(
                        array(
                          'header'=>'',
                          'type'=>'raw',
                        /* Here is The Button that will send the Data to The MAIN FORM */
                          'value'=>'CHtml::Button("+",
                          array("name" => "send_insurance",
                          "id" => "send_insurance",
                          "onClick" => "$(\"#insurance_dialog\").dialog(\"close\"); $(\"#insurance_name\").val(\"$data->fullname\"); $(\"#Applicantinsurance_insuranceid\").val(\"$data->addressbookid\");"))',
                          ),
                        'addressbookid',
                        'fullname',
                        array(
                          'class'=>'CCheckBoxColumn',
                          'name'=>'recordstatus',
                          'selectableRows'=>'0',
                          'header'=>'Record Status',
                          'checked'=>'$data->recordstatus'
                        ),
                        ),
                    ));
                    $this->endWidget('zii.widgets.jui.CJuiDialog');
                    echo CHtml::Button('...',
                                          array('onclick'=>'$("#insurance_dialog").dialog("open"); return false;',
                                       ));?>		<?php echo $form->error($model,'insuranceid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'insuranceno'); ?>
		<?php echo $form->textField($model,'insuranceno',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'insuranceno'); ?>
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
		array('applicantinsurance/write'),
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
		array('applicantinsurance/cancelwrite'),
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

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employeeidentity-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'employeeidentityid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'employeeid'); ?>
<?php echo $form->hiddenField($model,'employeeid'); ?>
                  <input type="text" name="employee_name" id="employee_name" readonly value="<?php echo (Employee::model()->findByPk($model->employeeid)!==null)?Employee::model()->findByPk($model->employeeid)->fullname:''; ?>">
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
                    'dataProvider'=>$employee->Searchwstatus(),
                    'filter'=>$employee,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_employee",
                        "id" => "send_employee",
                        "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#employee_name\").val(\"$data->fullname\"); $(\"#Employeeidentity_employeeid\").val(\"$data->employeeid\");"))',
                        ),
	array('name'=>'employeeid', 'visible'=>false,'value'=>'$data->employeeid','htmlOptions'=>array('width'=>'1%')),
                      'fullname',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#employee_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'employeeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identitytypeid'); ?>
<?php echo $form->hiddenField($model,'identitytypeid'); ?>
                  <input type="text" name="identitytype_name" id="identitytype_name" readonly value="<?php echo (Identitytype::model()->findByPk($model->identitytypeid)!==null)?Identitytype::model()->findByPk($model->identitytypeid)->identitytypename:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'identitytype_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Identity Type'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'identitytype-grid',
                    'dataProvider'=>$identitytype->Searchwstatus(),
                    'filter'=>$identitytype,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_identitytype",
                        "id" => "send_identitytype",
                        "onClick" => "$(\"#identitytype_dialog\").dialog(\"close\"); $(\"#identitytype_name\").val(\"$data->identitytypename\"); $(\"#Employeeidentity_identitytypeid\").val(\"$data->identitytypeid\");"))',
                        ),
	array('name'=>'identitytypeid', 'visible'=>false,'value'=>'$data->identitytypeid','htmlOptions'=>array('width'=>'1%')),
                      'identitytypename',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#identitytype_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'identitytypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identityname'); ?>
		<?php echo $form->textField($model,'identityname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'identityname'); ?>
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
		array('employeeidentity/write'),
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
		array('employeeidentity/cancelwrite'),
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
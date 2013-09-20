<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projectemp-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(6)}",
));  ?>
<?php echo $form->hiddenField($model,'projectempid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	

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
                        "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#employee_name\").val(\"$data->fullname\"); $(\"#Projectemp_employeeid\").val(\"$data->employeeid\");"))',
                        ),
                      'employeeid',
                      'fullname',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#employee_dialog").dialog("open"); return false;',
                                     ));?>
            <?php echo $form->error($model,'employeeid'); ?>
        </div>

    <div class="row">
          <?php echo $form->labelEx($model,'workdate'); ?>
          <?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'workdate',
              'model'=>$model,
              'mode'=>'datetime',
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true,
                 'timeFormat'=>'hh:mm'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'30',
              ),
          ));?>
          <?php echo $form->error($model,'workdate'); ?>
        </div>

    <div class="row">
          <?php echo $form->labelEx($model,'workdateend'); ?>
          <?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'workdateend',
              'model'=>$model,
              'mode'=>'datetime',
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true,
                 'timeFormat'=>'hh:mm'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'30',
              ),
          ));?>
          <?php echo $form->error($model,'workdateend'); ?>
        </div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writeemployee'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("employeedatagrid");
			  $("#createdialog4").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->

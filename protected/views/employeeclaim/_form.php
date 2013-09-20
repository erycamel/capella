<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employeeclaim-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'employeeclaimid'); ?>
	

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
                        "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#employee_name\").val(\"$data->fullname\"); $(\"#Employeeclaim_employeeid\").val(\"$data->employeeid\");"))',
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
		<?php echo $form->labelEx($model,'claimenterdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'claimenterdate',
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
		<?php echo $form->error($model,'claimenterdate'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'claimexitdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'claimexitdate',
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
		<?php echo $form->error($model,'claimexitdate'); ?>
	</div>

    	<div class="row">
		<?php echo $form->labelEx($model,'claimprice'); ?>
		<?php echo $form->textField($model,'claimprice',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'claimprice'); ?>
	</div>
	
		<div class="row">
		<?php echo $form->labelEx($model,'claimappdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'claimappdate',
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
		<?php echo $form->error($model,'claimappdate'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'claimappprice'); ?>
		<?php echo $form->textField($model,'claimappprice',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'claimappprice'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'reason'); ?>
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
		array('employeeclaim/write'),
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
		array('employeeclaim/cancelwrite'),
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
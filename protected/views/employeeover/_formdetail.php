<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employeeoverdet-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'employeeoverdetid'); ?>
<?php echo $form->hiddenField($model,'employeeoverid'); ?>
	

    <div class="row">
		<?php echo $form->labelEx($model,'employeeid'); ?>
<?php echo $form->hiddenField($model,'employeeid'); ?>
	  <input type="text" name="account_name" id="fullname" title="Account name" readonly value="<?php
echo (Employee::model()->findByPk($model->employeeid)!==null)?Employee::model()->findByPk($model->employeeid)->fullname:''; ?>">
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
$employee=new Employee('searchwstatus');
	  $employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$employee->attributes=$_GET['Employee'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'account-grid',
      'dataProvider'=>$employee->Searchwstatus(),
      'filter'=>$employee,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->fullname\");
          $(\"#Employeeoverdet_employeeid\").val(\"$data->employeeid\");
		  "))',
          ),
	array('name'=>'employeeid', 'visible'=>false,'value'=>'$data->employeeid','htmlOptions'=>array('width'=>'1%')),
        'fullname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#employee_dialog").dialog("open"); return false;',
                       ))?>		
		<?php echo $form->error($model,'accountid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'overtime'); ?>
		<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'overtime',
              'model'=>$model,
            'mode'=>'time',
              // additional javascript options for the date picker plugin
              'options'=>array(),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'overtimeend'); ?>
		<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'overtimeend',
              'model'=>$model,
            'mode'=>'time',
              // additional javascript options for the date picker plugin
              'options'=>array(),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('employeeover/writedetail'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("detaildatagrid");
			  $("#createdialog1").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employeeonleave-form',
	'enableAjaxValidation'=>false,
)); ?>
  <?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
<?php echo $form->hiddenField($model,'employeeonleaveid'); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'employeeid'); ?>
<?php echo $form->hiddenField($model,'employeeid'); ?>
          <input type="text" name="fullname" id="fullname" readonly value="<?php echo (Employee::model()->findByPk($model->employeeid)!==null)?Employee::model()->findByPk($model->employeeid)->fullname:'';?>">
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
                "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->fullname\"); $(\"#Employeeonleave_employeeid\").val(\"$data->employeeid\");"))',
                ),
	array('name'=>'employeeid', 'visible'=>false,'value'=>'$data->employeeid','htmlOptions'=>array('width'=>'1%')),
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
		<?php echo $form->labelEx($model,'onleaveid'); ?>
<?php echo $form->hiddenField($model,'onleaveid'); ?>
          <input type="text" name="onleavename" id="onleavename" readonly value="<?php
echo (Onleavetype::model()->findByPk($model->onleaveid)!==null)?Onleavetype::model()->findByPk($model->onleaveid)->onleavename:'';?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'onleavetype_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Onleave Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'onleavetype-grid',
            'dataProvider'=>$onleavetype->Searchwstatus(),
            'filter'=>$onleavetype,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_employee",
                "id" => "send_employee",
                "onClick" => "$(\"#onleavetype_dialog\").dialog(\"close\"); $(\"#onleavename\").val(\"$data->onleavename\"); $(\"#Employeeonleave_onleaveid\").val(\"$data->onleavetypeid\");"))',
                ),
	array('name'=>'onleavetypeid', 'visible'=>false,
        'value'=>'$data->onleavetypeid','htmlOptions'=>array('width'=>'1%')),
              'onleavename',
                'cutimax',
                'cutistart'
              ),
          ));
          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#onleavetype_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'onleaveid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'periodefrom'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'periodefrom',
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
		<?php echo $form->error($model,'periodefrom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'periodeto'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'periodeto',
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
		<?php echo $form->error($model,'periodeto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastvalue'); ?>
		<?php echo $form->textField($model,'lastvalue'); ?>
		<?php echo $form->error($model,'lastvalue'); ?>
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
		array('employeeonleave/write'),
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
		array('employeeonleave/cancelwrite'),
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
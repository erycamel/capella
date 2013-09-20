<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sicktrans-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
<?php echo $form->hiddenField($model,'sicktransid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

    <table>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'sickdate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'sickdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
		<?php echo $form->error($model,'sickdate'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'employeeid'); ?>
		<?php echo $form->hiddenField($model,'employeeid'); ?>
    <input type="text" name="stat_name" id="fullname" readonly value="
        <?php echo (Employee::model()->findByPk($model->employeeid)!==null)?Employee::model()->findByPk($model->employeeid)->fullname:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'employee_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Employee'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'employee-grid',
        'dataProvider'=>$employee->searchwstatus(),
        'filter'=>$employee,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->fullname\"); $(\"#Sicktrans_employeeid\").val(\"$data->employeeid\");"))',
          ),
	array('name'=>'employeeid', 'visible'=>false,'value'=>'$data->employeeid','htmlOptions'=>array('width'=>'1%')),
          'fullname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#employee_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'employeeid'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'hospitalid'); ?>
		<?php echo $form->hiddenField($model,'hospitalid'); ?>
    <input type="text" name="stat_name" id="hospitalname" readonly value="<?php echo (Hospital::model()->findByPk($model->hospitalid)!==null)?Hospital::model()->findByPk($model->hospitalid)->fullname:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'hospital_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Hospital'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'hospital-grid',
        'dataProvider'=>$hospital->searchwstatus(),
        'filter'=>$hospital,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#hospital_dialog\").dialog(\"close\"); $(\"#hospitalname\").val(\"$data->fullname\"); $(\"#Sicktrans_hospitalid\").val(\"$data->addressbookid\");"))',
          ),
	array('name'=>'addressbookid', 'visible'=>false,'value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
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
                          array('onclick'=>'$("#hospital_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'hospitalid'); ?>
	</div>
        </td>               
      </tr>
      <tr>
         <td>
          <div class="row">
		<?php echo $form->labelEx($model,'doctorname'); ?>
		<?php echo $form->textField($model,'doctorname',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'doctorname'); ?>
	</div>
        </td><td>
          <div class="row">
		<?php echo $form->labelEx($model,'takedatefrom'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'takedatefrom',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
		<?php echo $form->error($model,'takedatefrom'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'takedateto'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'takedateto',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
		<?php echo $form->error($model,'takedateto'); ?>
	</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'diagnosa'); ?>
		<?php echo $form->textField($model,'diagnosa',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'diagnosa'); ?>
	</div>
        </td>
      </tr>
    </table>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('sicktrans/write'),
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
		array('sicktrans/cancelwrite'),
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
	<div id="messagediv"></div>
</div><!-- form -->

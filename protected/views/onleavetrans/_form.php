<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'onleavetrans-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'onleavetransid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'onleavedate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'onleavedate',
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
		<?php echo $form->error($model,'onleavedate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'employeeid'); ?>
		<?php echo $form->hiddenField($model,'employeeid'); ?>
    <input type="text" name="stat_name" id="fullname" readonly value="<?php echo (Employee::model()->findByPk($model->employeeid)!==null)?Employee::model()->findByPk($model->employeeid)->fullname:''; ?>">
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
          "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->fullname\"); $(\"#Onleavetrans_employeeid\").val(\"$data->employeeid\");"))',
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

	<div class="row">
		<?php echo $form->labelEx($model,'onleavetypeid'); ?>
		<?php echo $form->hiddenField($model,'onleavetypeid'); ?>
    <input type="text" name="stat_name" id="onleavename" readonly value="<?php echo (Onleavetype::model()->findByPk($model->onleavetypeid)!==null)?Onleavetype::model()->findByPk($model->onleavetypeid)->onleavename:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'onleave_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Onleave Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'onleave-grid',
        'dataProvider'=>$onleavetype->searchwstatus(),
        'filter'=>$onleavetype,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#onleave_dialog\").dialog(\"close\"); $(\"#onleavename\").val(\"$data->onleavename\"); $(\"#Onleavetrans_onleavetypeid\").val(\"$data->onleavetypeid\");"))',
          ),
	array('name'=>'onleavetypeid', 'visible'=>false,'value'=>'$data->onleavetypeid','htmlOptions'=>array('width'=>'1%')),
          'onleavename',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#onleave_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'onleavetypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datefrom'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'datefrom',
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
		<?php echo $form->error($model,'datefrom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dateto'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'dateto',
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
		<?php echo $form->error($model,'dateto'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('onleavetrans/write'),
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
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employeespletter-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'employeespletterid'); ?>
	

    <div class="row">
		<?php echo $form->labelEx($model,'transdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'transdate',
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
		<?php echo $form->error($model,'transdate'); ?>
	</div>

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
                        "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#employee_name\").val(\"$data->fullname\"); $(\"#Employeespletter_employeeid\").val(\"$data->employeeid\");"))',
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
		<?php echo $form->labelEx($model,'splettertypeid'); ?>
<?php echo $form->hiddenField($model,'splettertypeid'); ?>
                    <input type="text" name="splettername" id="splettername" readonly value="<?php echo (Splettertype::model()->findByPk($model->splettertypeid)!==null)?Splettertype::model()->findByPk($model->splettertypeid)->splettername:''; ?>">
                    <?php
                      $this->beginWidget('zii.widgets.jui.CJuiDialog',
                       array(   'id'=>'splettertype_dialog',
                                // additional javascript options for the dialog plugin
                                'options'=>array(
                                                'title'=>Yii::t('app','Splettertype'),
                                                'width'=>'auto',
                                                'autoOpen'=>false,
                                                'modal'=>true,
                                                ),
                                        ));

                    $this->widget('zii.widgets.grid.CGridView', array(
                      'id'=>'splettertype-grid',
                      'dataProvider'=>$splettertype->Searchwstatus(),
                      'filter'=>$splettertype,
                      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                      'columns'=>array(
                        array(
                          'header'=>'',
                          'type'=>'raw',
                        /* Here is The Button that will send the Data to The MAIN FORM */
                          'value'=>'CHtml::Button("+",
                          array("name" => "send_splettertype",
                          "id" => "send_splettertype",
                          "onClick" => "$(\"#splettertype_dialog\").dialog(\"close\"); $(\"#splettername\").val(\"$data->splettername\"); $(\"#Employeespletter_splettertypeid\").val(\"$data->splettertypeid\");
						  generatedata();
						  "))',
                          ),
	array('name'=>'splettertypeid', 'visible'=>false,'value'=>'$data->splettertypeid','htmlOptions'=>array('width'=>'1%')),
                        'splettername',
                        ),
                    ));

                    $this->endWidget('zii.widgets.jui.CJuiDialog');
                    echo CHtml::Button('...',
                                          array('onclick'=>'$("#splettertype_dialog").dialog("open"); return false;',
                                       ));?>		<?php echo $form->error($model,'splettertypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textArea($model,'reason',array('col'=>50,'row'=>50)); ?>
		<?php echo $form->error($model,'reason'); ?>
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
		<?php echo $form->error($model,'enddate'); ?>
	</div>
  
  	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkbox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('employeespletter/write'),
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
		array('employeespletter/cancelwrite'),
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
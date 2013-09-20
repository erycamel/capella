<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'absrule-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'wfstatusid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

  <div class="row">
		<?php echo $form->labelEx($model,'workflowid'); ?>
<?php echo $form->hiddenField($model,'workflowid'); ?>
                  <input type="text" name="wfname" id="wfname" readonly >
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'workflow_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Workflow'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));
$workflow=new Workflow('search');
$workflow->unsetAttributes();  // clear any default values
	  if(isset($_GET['Workflow']))
		$workflow->attributes=$_GET['Workflow'];
                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'workflow-grid',
                    'dataProvider'=>$workflow->search(),
                    'filter'=>$workflow,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_workflow",
                        "id" => "send_workflow",
                        "onClick" => "$(\"#workflow_dialog\").dialog(\"close\"); $(\"#wfname\").val(\"$data->wfname\"); $(\"#Wfstatus_workflowid\").val(\"$data->workflowid\");"))',
                        ),
	array('name'=>'workflowid', 'visible'=>false,'value'=>'$data->workflowid','htmlOptions'=>array('width'=>'1%')),
                      'wfname',
					  'wfdesc',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#workflow_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'workflowid'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'wfstat'); ?>
		<?php echo $form->textField($model,'wfstat'); ?>
		<?php echo $form->error($model,'wfstat'); ?>
	</div>
  
  	<div class="row">
		<?php echo $form->labelEx($model,'wfstatusname'); ?>
		<?php echo $form->textField($model,'wfstatusname'); ?>
		<?php echo $form->error($model,'wfstatusname'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('wfstatus/write'),
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
		array('wfstatus/cancelwrite'),
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

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orgstructure-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'orgstructureid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'structurename'); ?>
		<?php echo $form->textField($model,'structurename',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'structurename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parentid'); ?>
	  <?php echo $form->hiddenField($model,'parentid'); ?>
	  <input type="text" name="sched_name" id="parentstructurename" title="Enter Schedule name" readonly value="<?php echo (Orgstructure::model()->findByPk($model->parentid)!==null)?Orgstructure::model()->findByPk($model->parentid)->structurename:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'absschedule_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Organization Structure'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'absschedule-grid',
      'dataProvider'=>$parent->Searchwstatus(),
      'filter'=>$parent,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#absschedule_dialog\").dialog(\"close\"); $(\"#parentstructurename\").val(\"$data->structurename\"); $(\"#Orgstructure_parentid\").val(\"$data->orgstructureid\");
		  "))',
          ),
	array('name'=>'orgstructureid', 'visible'=>false,'value'=>'$data->orgstructureid','htmlOptions'=>array('width'=>'1%')),
        'structurename',
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
                          array('onclick'=>'$("#absschedule_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'parentid'); ?>
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
		array('orgstructure/write'),
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
		array('orgstructure/cancelwrite'),
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
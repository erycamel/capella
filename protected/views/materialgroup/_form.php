<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'materialgroup-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'materialgroupid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'materialtypeid'); ?>
		<?php echo $form->hiddenField($model,'materialtypeid'); ?>
	  <input type="text" name="sched_name" id="description" title="Enter Schedule name" readonly value="<?php echo (Materialtype::model()->findByPk($model->materialtypeid)!==null)?Materialtype::model()->findByPk($model->materialtypeid)->description:'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'materialtype_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'materialtype-grid',
      'dataProvider'=>$materialtype->Searchwstatus(),
      'filter'=>$materialtype,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#materialtype_dialog\").dialog(\"close\"); $(\"#description\").val(\"$data->description\"); $(\"#Materialgroup_materialtypeid\").val(\"$data->materialtypeid\");
		  "))',
          ),
	array('name'=>'materialtypeid', 'visible'=>false,'value'=>'$data->materialtypeid','htmlOptions'=>array('width'=>'1%')),
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#materialtype_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'materialtypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'materialgroupcode'); ?>
		<?php echo $form->textField($model,'materialgroupcode',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'materialgroupcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parentmatgroupid'); ?>
		<?php echo $form->hiddenField($model,'parentmatgroupid'); ?>
	  <input type="text" name="sched_name" id="parentmatgroupcode" title="Enter Schedule name" readonly value="<?php echo (Materialgroup::model()->findByPk($model->parentmatgroupid)!==null)?Materialgroup::model()->findByPk($model->parentmatgroupid)->materialgroupcode:'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'absschedule_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'absschedule-grid',
      'dataProvider'=>$parentmatgroup->Searchwstatus(),
      'filter'=>$parentmatgroup,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#absschedule_dialog\").dialog(\"close\"); $(\"#parentmatgroupcode\").val(\"$data->materialgroupcode\"); $(\"#Materialgroup_parentmatgroupid\").val(\"$data->materialgroupid\");
		  "))',
          ),
        'materialgroupid',
        'materialgroupcode',
        'description',
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
		<?php echo $form->error($model,'parentmatgroupid'); ?>
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
		array('materialgroup/write'),
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
		array('materialgroup/cancelwrite'),
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
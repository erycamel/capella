<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sloc-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'slocid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'plantid'); ?>
		<?php echo $form->hiddenField($model,'plantid'); ?>
	  <input type="text" name="sched_name" id="plant_code" title="Enter Schedule name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'plant_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Plant'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'plant-grid',
      'dataProvider'=>$plant->searchwstatus(),
      'filter'=>$plant,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_plant",
          "id" => "send_plant",
          "onClick" => "$(\"#plant_dialog\").dialog(\"close\"); $(\"#plant_code\").val(\"$data->plantcode\"); $(\"#Sloc_plantid\").val(\"$data->plantid\");
		  "))',
          ),
        'plantid',
        'plantcode',
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("plant-grid");$("#plant_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'plantid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sloccode'); ?>
		<?php echo $form->textField($model,'sloccode',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'sloccode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('sloc/write'),
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
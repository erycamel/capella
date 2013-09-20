<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prosubcategory-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'prosubcategoryid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'procategoryid'); ?>
    <?php echo $form->hiddenField($model,'procategoryid'); ?>
	  <input type="text" name="sched_name" id="procategoryname" title="Enter Schedule name" readonly value="<?php
echo (Procategory::model()->findByPk($model->procategoryid)!==null)?Procategory::model()->findByPk($model->procategoryid)->procategoryname :'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'catering_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Procategory'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'catering-grid',
      'dataProvider'=>$procategory->Searchwstatus(),
      'filter'=>$procategory,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#catering_dialog\").dialog(\"close\"); $(\"#procategoryname\").val(\"$data->procategoryname\"); $(\"#Prosubcategory_procategoryid\").val(\"$data->procategoryid\");
		  "))',
          ),
        'procategoryid',
        'procategoryname',
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
                          array('onclick'=>'$("#catering_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'procategoryid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prosubcategoryname'); ?>
		<?php echo $form->textField($model,'prosubcategoryname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'prosubcategoryname'); ?>
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
		array('prosubcategory/write'),
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
		array('prosubcategory/cancelwrite'),
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

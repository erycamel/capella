<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'educationmajor-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'educationmajorid'); ?>
	
	<div class="row">
	<?php echo $form->labelEx($model,'educationid'); ?>
	<?php echo $form->hiddenField($model,'educationid'); ?>
	  <input type="text" name="sched_name" id="educationname" title="Enter Schedule name" readonly value="<?php echo (Education::model()->findByPk($model->educationid)!==null)?Education::model()->findByPk($model->educationid)->educationname:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'education_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Education'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'catering-grid',
      'dataProvider'=>$education->Searchwstatus(),
      'filter'=>$education,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#education_dialog\").dialog(\"close\"); $(\"#educationname\").val(\"$data->educationname\"); $(\"#Educationmajor_educationid\").val(\"$data->educationid\");
		  "))',
          ),
	array('name'=>'educationid', 'visible'=>false,'value'=>'$data->educationid','htmlOptions'=>array('width'=>'1%')),
        'educationname',
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
                          array('onclick'=>'$("#education_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'educationid'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'educationmajorname'); ?>
		<?php echo $form->textField($model,'educationmajorname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'educationmajorname'); ?>
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
		array('educationmajor/write'),
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
		array('educationmajor/cancelwrite'),
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
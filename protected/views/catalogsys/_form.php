<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalogsys-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'catalogsysid'); ?>

<?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'languageid'); ?>
		<?php echo $form->hiddenField($model,'languageid'); ?>
	  <input type="text" name="languagename" id="languagename" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'absschedule_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Language'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'absschedule-grid',
      'dataProvider'=>$language->Searchwstatus(),
      'filter'=>$language,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#absschedule_dialog\").dialog(\"close\"); $(\"#languagename\").val(\"$data->languagename\"); $(\"#Catalogsys_languageid\").val(\"$data->languageid\");
		  "))',
          ),
        array('name'=>'languageid', 'visible'=>false,
        'value'=>'$data->languageid','htmlOptions'=>array('width'=>'1%')),
        'languagename',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#absschedule_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'languageid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'catalogname'); ?>
		<?php echo $form->textField($model,'catalogname',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'catalogname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'catalogval'); ?>
		<?php echo $form->textArea($model,'catalogval',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'catalogval'); ?>
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
		array('catalogsys/write'),
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
		array('catalogsys/cancelwrite'),
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
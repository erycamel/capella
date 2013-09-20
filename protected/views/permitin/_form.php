<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'permitin-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'permitinid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'permitinname'); ?>
		<?php echo $form->textField($model,'permitinname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'permitinname'); ?>
	</div>

		<?php echo $form->labelEx($model,'snroid'); ?>
	<?php echo $form->hiddenField($model,'snroid'); ?>
    <input type="text" name="stat_name" id="description" readonly value="<?php echo (Snro::model()->findByPk($model->snroid)!==null)?Snro::model()->findByPk($model->snroid)->description:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'snro_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Absence Status'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'absstatus-grid',
        'dataProvider'=>$snro->searchwstatus(),
        'filter'=>$snro,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#snro_dialog\").dialog(\"close\"); $(\"#description\").val(\"$data->description\"); $(\"#Permitin_snroid\").val(\"$data->snroid\");"))',
          ),
	array('name'=>'snroid', 'visible'=>false,'value'=>'$data->snroid','htmlOptions'=>array('width'=>'1%')),
          'description',
          'formatdoc',
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
                          array('onclick'=>'$("#snro_dialog").dialog("open"); return false;',
                       ))
    ?>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('permitin/write'),
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
		array('permitin/cancelwrite'),
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

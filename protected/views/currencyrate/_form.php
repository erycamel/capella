<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'currencyrate-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'currencyrateid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'currencyid'); ?>
		<?php echo $form->hiddenField($model,'currencyid'); ?>
    <input type="text" name="stat_name" id="currencyname" readonly value="<?php echo (Currency::model()->findByPk($model->currencyid)!==null)?Currency::model()->findByPk($model->currencyid)->currencyname:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'absstatus_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Currency'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'absstatus-grid',
        'dataProvider'=>$currency->searchwstatus(),
        'filter'=>$currency,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#absstatus_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); $(\"#Currencyrate_currencyid\").val(\"$data->currencyid\");"))',
          ),
	array('name'=>'currencyid', 'visible'=>false,'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
          'currencyname',
          'symbol',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#absstatus_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'currencyid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ratedate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'ratedate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
		<?php echo $form->error($model,'ratedate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ratevalue'); ?>
		<?php echo $form->textField($model,'ratevalue'); ?>
		<?php echo $form->error($model,'ratevalue'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('currencyrate/write'),
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
		array('currencyrate/cancelwrite'),
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

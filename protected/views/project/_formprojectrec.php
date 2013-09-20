<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projectrec-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(6)}",
));  ?>
<?php echo $form->hiddenField($model,'projectrecid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	

    <table>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'recdatestart'); ?>
<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'recdatestart',
              'model'=>$model,
    'mode'=>'datetime',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'30',
              ),
          ));?>		<?php echo $form->error($model,'recdatestart'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'recdateend'); ?>
<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'recdateend',
              'model'=>$model,
    'mode'=>'datetime',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'30',
              ),
          ));?>	<?php echo $form->error($model,'recdateend'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'durasi'); ?>
		<?php echo $form->textField($model,'durasi'); ?>
		<?php echo $form->error($model,'durasi'); ?>
	</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'disturb'); ?>
		<?php echo $form->textField($model,'disturb'); ?>
		<?php echo $form->error($model,'disturb'); ?>
	</div>
        </td>
        <td>
           <div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location'); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textField($model,'note'); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>
        </td>
      </tr>
    </table>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writeprojecrec'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("projectrecdatagrid");
			  $("#createdialog6").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
    <?php $this->endWidget(); ?>
	<?php
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs' => array(
        'Detail' => array('content' => $this->renderPartial('indexprorecdetail',
			array('prorecdetail'=>$prorecdetail),true)),
		'Category' => array('content' => $this->renderPartial('indexproreccategory',
			array('proreccategory'=>$proreccategory,'prosubcategory'=>$prosubcategory),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->

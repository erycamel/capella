<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prorecdetail-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(6)}",
));  ?>
<?php echo $form->hiddenField($model,'prorecdetailid'); ?>
<?php echo $form->hiddenField($model,'projectrecid'); ?>
	

        <div class="row">
          <?php echo $form->labelEx($model,'prorechour'); ?>
          <?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'prorechour',
              'model'=>$model,
              'mode'=>'time',
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true,
                 'timeFormat'=>'hh:mm'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'30',
              ),
          ));?>
          <?php echo $form->error($model,'prorechour'); ?>
        </div>

            <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writeprorecdetail'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("proreccategorydatagrid");
			  $("#createdialog5").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->

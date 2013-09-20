<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workorderstaff-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpmodifdialog',
    'options'=>array(
        'title'=>'Help Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<?php echo $this->renderPartial('_helpmodif'); ?>
<?php $this->endWidget();?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"$('#helpmodifdialog').dialog('open');",
));  ?>

<?php echo $form->hiddenField($model,'workorderstaffid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'useraccessid'); ?>
		<?php echo $form->hiddenField($model,'useraccessid'); ?>
    <input type="text" name="stat_name" id="username" readonly value="<?php echo Useraccess::model()->findByPk($model->useraccessid)->realname ?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'absstatus_dialog',
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
        'dataProvider'=>$useraccess->searchwstatus(),
        'filter'=>$useraccess,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#absstatus_dialog\").dialog(\"close\"); $(\"#username\").val(\"$data->realname\"); $(\"#Workorderstaff_useraccessid\").val(\"$data->useraccessid\");"))',
          ),
          'useraccessid',
          'username',
          'realname',
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
                          array('onclick'=>'$("#absstatus_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'useraccessid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('workorderstaff/write'),
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
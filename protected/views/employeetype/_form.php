<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employeetype-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'employeetypeid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'employeetypename'); ?>
		<?php echo $form->textField($model,'employeetypename',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'employeetypename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'snroid'); ?>
    <?php echo $form->hiddenField($model,'snroid'); ?>
    <input type="text" name="snro_name" id="snro_name" readonly>
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'snro_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Specific Number Range Object'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'snro-grid',
      'dataProvider'=>$snro->Searchwstatus(),
      'filter'=>$snro,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_snro",
          "id" => "send_snro",
          "onClick" => "$(\"#snro_dialog\").dialog(\"close\"); $(\"#snro_name\").val(\"$data->description\"); $(\"#Employeetype_snroid\").val(\"$data->snroid\");"))',
          ),
	array('name'=>'snroid', 'visible'=>false,'value'=>'$data->snroid','htmlOptions'=>array('width'=>'1%')),
        'description',
        'formatdoc',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#snro_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'snroid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sicksnroid'); ?>
    <?php echo $form->hiddenField($model,'sicksnroid'); ?>
    <input type="text" name="sicksnro_name" id="sicksnro_name" readonly>
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'sicksnro_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Specific Number Range Object'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'sicksnro-grid',
      'dataProvider'=>$snro->Searchwstatus(),
      'filter'=>$snro,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_sicksnro",
          "id" => "send_sicksnro",
          "onClick" => "$(\"#sicksnro_dialog\").dialog(\"close\"); $(\"#sicksnro_name\").val(\"$data->description\"); $(\"#Employeetype_sicksnroid\").val(\"$data->snroid\");"))',
          ),
	array('name'=>'snroid', 'visible'=>false,'value'=>'$data->snroid','htmlOptions'=>array('width'=>'1%')),
        'description',
        'formatdoc',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#sicksnro_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'sicksnroid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sickstatusid'); ?>
    <?php echo $form->hiddenField($model,'sickstatusid'); ?>
    <input type="text" name="sickstatus_name" id="sickstatus_name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'sickstatus_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Status'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'sickstatus-grid',
      'dataProvider'=>$sickstatus->Searchwstatus(),
      'filter'=>$sickstatus,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_sickstatus",
          "id" => "send_sickstatus",
          "onClick" => "$(\"#sickstatus_dialog\").dialog(\"close\"); $(\"#sickstatus_name\").val(\"$data->shortstat\"); $(\"#Employeetype_sickstatusid\").val(\"$data->absstatusid\");"))',
          ),
	array('name'=>'absstatusid', 'visible'=>false,'value'=>'$data->absstatusid','htmlOptions'=>array('width'=>'1%')),
        'shortstat',
        'longstat',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#sickstatus_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'sickstatusid'); ?>
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
		array('employeetype/write'),
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
		array('employeetype/cancelwrite'),
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
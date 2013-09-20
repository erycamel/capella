<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'groupmenu-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'groupmenuid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'groupaccessid'); ?>
		<?php echo $form->hiddenField($model,'groupaccessid'); ?>
	  <input type="text" name="groupname" id="groupname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'groupaccess_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Group Access'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'groupaccess-grid',
      'dataProvider'=>$groupaccess->Searchwstatus(),
      'filter'=>$groupaccess,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#groupaccess_dialog\").dialog(\"close\"); $(\"#groupname\").val(\"$data->groupname\"); $(\"#Groupmenu_groupaccessid\").val(\"$data->groupaccessid\");
		  "))',
          ),
	array('name'=>'groupaccessid', 'visible'=>false,'value'=>'$data->groupaccessid','htmlOptions'=>array('width'=>'1%')),
        'groupname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#groupaccess_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'groupaccessid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menuaccessid'); ?>
		<?php echo $form->hiddenField($model,'menuaccessid'); ?>
	  <input type="text" name="menuname" id="menuname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'menuaccess_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Menu Access'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'menuaccess-grid',
      'dataProvider'=>$menuaccess->Searchwstatus(),
      'filter'=>$menuaccess,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#menuaccess_dialog\").dialog(\"close\"); $(\"#menuname\").val(\"$data->description\"); $(\"#Groupmenu_menuaccessid\").val(\"$data->menuaccessid\");
		  "))',
          ),
	array('name'=>'menuaccessid', 'visible'=>false,'value'=>'$data->menuaccessid','htmlOptions'=>array('width'=>'1%')),
        'menuname',
          'menucode',
          'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#menuaccess_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'menuaccessid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isread'); ?>
		<?php echo $form->checkBox($model,'isread'); ?>
		<?php echo $form->error($model,'isread'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iswrite'); ?>
		<?php echo $form->checkBox($model,'iswrite'); ?>
		<?php echo $form->error($model,'iswrite'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ispost'); ?>
		<?php echo $form->checkBox($model,'ispost'); ?>
		<?php echo $form->error($model,'ispost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isreject'); ?>
		<?php echo $form->checkBox($model,'isreject'); ?>
		<?php echo $form->error($model,'isreject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isupload'); ?>
		<?php echo $form->checkBox($model,'isupload'); ?>
		<?php echo $form->error($model,'isupload'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isdownload'); ?>
		<?php echo $form->checkBox($model,'isdownload'); ?>
		<?php echo $form->error($model,'isdownload'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('groupmenu/write'),
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
		array('groupmenu/cancelwrite'),
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

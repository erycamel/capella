<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assphonegroup-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'assphonegroupid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'phonegroupid'); ?>
		<?php echo $form->hiddenField($model,'phonegroupid'); ?>
    <input type="text" name="stat_name" id="groupname" readonly value="<?php echo Phonegroup::model()->findByPk($model->phonegroupid)->groupname ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'phonegroup_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Phone Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'absstatus-grid',
        'dataProvider'=>$phonegroup->searchwstatus(),
        'filter'=>$phonegroup,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#phonegroup_dialog\").dialog(\"close\"); $(\"#groupname\").val(\"$data->groupname\"); $(\"#Assphonegroup_phonegroupid\").val(\"$data->phonegroupid\");"))',
          ),
          'phonegroupid',
          'groupname',
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
                          array('onclick'=>'$("#phonegroup_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'phonegroupid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'voucheragentid'); ?>
		<?php echo $form->hiddenField($model,'voucheragentid'); ?>
    <input type="text" name="stat_name" id="fullname" readonly value="<?php echo Voucheragent::model()->findByPk($model->voucheragentid)->addressbook->fullname ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'voucheragent_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Voucher Agent'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'absstatus-grid',
        'dataProvider'=>$voucheragent->searchwstatus(),
        'filter'=>$voucheragent,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#voucheragent_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->addressbookid\"); $(\"#Assphonegroup_voucheragentid\").val(\"$data->voucheragentid\");"))',
          ),
          'voucheragentid',
		  array('name'=>'addressbookid', 'value'=>'$data->addressbook->fullname'),
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
                          array('onclick'=>'$("#voucheragent_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'voucheragentid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('assphonegroup/write'),
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

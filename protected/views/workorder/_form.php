<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workorder-form',
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

<?php echo $form->hiddenField($model,'workorderid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'productid'); ?>
		<?php echo $form->hiddenField($model,'productid'); ?>
	  <input type="text" name="sched_name" id="productname" title="Enter Schedule name" readonly value="<?php echo Product::model()->findByPk($model->productid)->productname ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Absence Schedules'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$product->Searchwstatus(),
      'filter'=>$product,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Workorderstaff_productid\").val(\"$data->productid\");
		  "))',
          ),
        'productid',
        'productname',
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
                          array('onclick'=>'$("#product_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'productid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'workstartdate'); ?>
		<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'workstartdate',
                                'mode'=>'datetime',
								'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'timeFormat'=>'hh:mm:ss',
				  'changeYear'=>true,
				  'changeMonth'=>true
              )
                    ));
                ?>
		<?php echo $form->error($model,'workstartdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'worktargetdate'); ?>
		<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'worktargetdate',
                                'mode'=>'datetime',
								'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'timeFormat'=>'hh:mm:ss',
				  'changeYear'=>true,
				  'changeMonth'=>true
              )
                    ));
                ?>
		<?php echo $form->error($model,'worktargetdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'workorderstaffid'); ?>
		<?php echo $form->hiddenField($model,'workorderstaffid'); ?>
	  <input type="text" name="sched_name" id="useraccessid" title="Enter Schedule name" readonly value="<?php echo Workorderstaff::model()->findByPk($model->workorderstaffid)->useraccessid ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'workorderstaff_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Absence Schedules'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'workorderstaff-grid',
      'dataProvider'=>$workorderstaff->Searchwstatus(),
      'filter'=>$workorderstaff,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#workorderstaff_dialog\").dialog(\"close\"); $(\"#useraccessid\").val(\"$data->useraccessid\"); $(\"#Workorder_workorderstaffid\").val(\"$data->workorderstaffid\");
		  "))',
          ),
        'workorderstaffid',
		'useraccessid',
        'useraccess.username',
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
                          array('onclick'=>'$("#workorderstaff_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'workorderstaffid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'workorderstatusid'); ?>
		<?php echo $form->textArea($model,'workorderstatusid',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'workorderstatusid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'eventrequestid'); ?>
		<?php echo $form->hiddenField($model,'eventrequestid'); ?>
	  <input type="text" name="sched_name" id="eventtitle" title="Enter Schedule name" readonly value="<?php echo Eventrequest::model()->findByPk($model->eventrequestid)->eventtitle ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'eventrequest_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Absence Schedules'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$eventrequest->search(),
      'filter'=>$eventrequest,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#eventrequest_dialog\").dialog(\"close\"); $(\"#eventtitle\").val(\"$data->eventtitle\"); $(\"#Workorderstaff_productid\").val(\"$data->productid\");
		  "))',
          ),
        'eventrequestid',
        'eventtitle',
        'description',
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
                          array('onclick'=>'$("#eventrequest_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'eventrequestid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('workorder/write'),
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
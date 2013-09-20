<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workorder-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'workorderid'); ?>
	

	<?php echo $form->errorSummary($model); ?>
	<table>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'productid'); ?>
		<?php echo $form->hiddenField($model,'productid'); ?>
	  <input type="text" name="sched_name" id="productname" title="Enter Schedule name" readonly value="<?php echo Product::model()->findByPk($model->productid)->productname ?>">
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'workstartdate'); ?>
		<?php echo $form->hiddenField($model,'workstartdate'); ?>
	  <input type="text" name="sched_name" id="workstartdate" title="Enter Schedule name"
			 readonly value="<?php echo $model->workstartdate ?>">
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'worktargetdate'); ?>
	  		<?php echo $form->hiddenField($model,'worktargetdate'); ?>
	  <input type="text" name="sched_name" id="worktargetdate" title="Enter Schedule name"
			 readonly value="<?php echo $model->worktargetdate ?>">
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'workorderstaffid'); ?>
		<?php echo $form->hiddenField($model,'workorderstaffid'); ?>
	  <input type="text" name="sched_name" id="useraccessid" readonly >
	</div>
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->hiddenField($model,'description'); ?>
	  <textarea type="text" name="sched_name" id="description" title="Enter Schedule name"
				readonly cols="20" rows="5" ><?php echo $model->description ?></textarea>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo Yii::t('app','last status');?><br/>
	  <textarea type="text" name="sched_name" id="laststatus" title="Enter Schedule name"
			   readonly ><?php echo Workorderstatus::model()->findbypk($model->workorderstatusid)->statusname ?></textarea>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'workorderstatusid'); ?>
	  <?php echo $form->hiddenField($model,'workorderstatusid'); ?>
	  <input type="text" name="newstatus" id="newstatus" title="Enter Schedule name" readonly>
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'workorderstatus_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$workorderstatus = new Workorderstatus('searchwstatus');
	  $workorderstatus->unsetAttributes();  // clear any default values
	  if(isset($_GET['Workorderstatus']))
		$workorderstatus->attributes=$_GET['Workorderstatus'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$workorderstatus->Searchwstatus(),
      'filter'=>$workorderstatus,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#workorderstatus_dialog\").dialog(\"close\"); $(\"#newstatus\").val(\"$data->statusname\"); $(\"#MyWorkorder_workorderstatusid\").val(\"$data->workorderstatusid\");
		  "))',
          ),
        'workorderstatusid',
        'statusname',
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
                          array('onclick'=>'$("#workorderstatus_dialog").dialog("open"); return false;',
                       ))?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'eventrequestid'); ?>
		<?php echo $form->hiddenField($model,'eventrequestid'); ?>
	  <input type="text" name="sched_name" id="eventtitle" title="Enter Schedule name" readonly value="<?php echo Eventrequest::model()->findByPk($model->eventrequestid)->eventtitle ?>">
	</div>
		</td>
	  </tr>
	</table>
	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->hiddenField($model,'recordstatus'); ?>
	  <input type="checkbox" name="sched_name" id="recordstatus" title="Enter Schedule name"
			 readonly value="<?php echo $model->recordstatus ?>">
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('myworkorder/write'),
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
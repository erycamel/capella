<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projectdoc-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(12)}",
));  ?>
<?php echo $form->hiddenField($model,'projectnetworkid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	

	<table>
	<tr>
		<td>
		<div class="row">
            <?php echo $form->labelEx($model,'application'); ?>
		<?php echo $form->textField($model,'application'); ?>
		<?php echo $form->error($model,'application'); ?>
    </div>   
		</td>
		<td>
		<div class="row">
            <?php echo $form->labelEx($model,'technology'); ?>
		<?php echo $form->textArea($model,'technology',array('cols'=>20,'rows'=>5)); ?>
		<?php echo $form->error($model,'technology'); ?>
    </div> 
		</td>
		<td>
		<div class="row">
            <?php echo $form->labelEx($model,'upstream'); ?>
		<?php echo $form->textField($model,'upstream'); ?>
		<?php echo $form->error($model,'upstream'); ?>
    </div> 
		</td>
	</tr>
	<tr>
	<td>
	<div class="row">
            <?php echo $form->labelEx($model,'downstream'); ?>
		<?php echo $form->textField($model,'downstream'); ?>
		<?php echo $form->error($model,'downstream'); ?>
    </div> 
	</td>
	<td>
	<div class="row">
            <?php echo $form->labelEx($model,'accessmethodid'); ?>
	<?php echo $form->hiddenField($model,'accessmethodid'); ?>
    <input type="text" name="accessmethodname" id="accessmethodname" readonly value="<?php
echo (Accessmethod::model()->findByPk($model->accessmethodid)!==null)?Accessmethod::model()->findByPk($model->accessmethodid)->accessmethodname :'';?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'accessmethod_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Destination City'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$accessmethod= new Accessmethod('searchwstatus');
	  $accessmethod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Accessmethod']))
		$accessmethod->attributes=$_GET['Accessmethod'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'accessmethod-grid',
        'dataProvider'=>$accessmethod->searchwstatus(),
        'filter'=>$accessmethod,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#accessmethod_dialog\").dialog(\"close\"); $(\"#accessmethodname\").val(\"$data->accessmethodname\");
          $(\"#Projectnetwork_accessmethodid\").val(\"$data->accessmethodid\");"))',
          ),
          array('name'=>'accessmethodid', 'visible'=>false, 'value'=>'$data->accessmethodid'),
          'accessmethodname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#accessmethod_dialog").dialog("open"); return false;',
                       ))?>
	</div>
	</td>
	<td>
	<div class="row">
            <?php echo $form->labelEx($model,'originipaddress'); ?>
		<?php echo $form->textField($model,'originipaddress'); ?>
		<?php echo $form->error($model,'originipaddress'); ?>
    </div> 
	</td>
	</tr>
	<tr>
	<td>
	<div class="row">
            <?php echo $form->labelEx($model,'destipaddress'); ?>
		<?php echo $form->textField($model,'destipaddress'); ?>
		<?php echo $form->error($model,'destipaddress'); ?>
    </div> 
	</td>
	<td>
	<div class="row">
            <?php echo $form->labelEx($model,'originnetmask'); ?>
		<?php echo $form->textField($model,'originnetmask'); ?>
		<?php echo $form->error($model,'originnetmask'); ?>
    </div> 
	</td>
	<td>
	<div class="row">
            <?php echo $form->labelEx($model,'destnetmask'); ?>
		<?php echo $form->textField($model,'destnetmask'); ?>
		<?php echo $form->error($model,'destnetmask'); ?>
    </div> 
	</td>
	</tr>
	</table>	
	
	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writenetwork'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("networkdatagrid");
			  $("#createdialog6").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
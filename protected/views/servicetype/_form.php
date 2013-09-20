<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'servicetype-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'servicetypeid'); ?>
	

		<div class="row">
		<?php echo $form->labelEx($model,'servicetypename'); ?>
		<?php echo $form->textField($model,'servicetypename',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'servicetypename'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'sosnroid'); ?>
<?php echo $form->hiddenField($model,'sosnroid'); ?>
	  <input type="text" name="sched_name" id="sosnroname" title="Enter Schedule name" readonly value="<?php 
echo (Snro::model()->findByPk($model->sosnroid)!==null)?Snro::model()->findByPk($model->sosnroid)->formatdoc:'';
?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'sosnro_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Specific Number Range Object'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$sosnro=new Snro('searchwstatus');
	  $sosnro->unsetAttributes();  // clear any default values
	  if(isset($_GET['Snro']))
		$sosnro->attributes=$_GET['Snro'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$sosnro->Searchwstatus(),
      'filter'=>$sosnro,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#sosnro_dialog\").dialog(\"close\"); $(\"#sosnroname\").val(\"$data->formatdoc\"); $(\"#Servicetype_sosnroid\").val(\"$data->snroid\");
		  "))',
          ),
	array('name'=>'snroid', 'visible'=>false,'value'=>'$data->snroid','htmlOptions'=>array('width'=>'1%')),
        'formatdoc',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#sosnro_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'sosnroid'); ?>
	</div>

<div class="row">
		<?php echo $form->labelEx($model,'srfsnroid'); ?>
<?php echo $form->hiddenField($model,'srfsnroid'); ?>
	  <input type="text" name="srfsnroname" id="srfsnroname" title="Enter Schedule name" readonly value="<?php 
echo (Snro::model()->findByPk($model->srfsnroid)!==null)?Snro::model()->findByPk($model->srfsnroid)->formatdoc:'';
?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'srfsnro_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Specific Number Range Object'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$sosnro=new Snro('searchwstatus');
	  $sosnro->unsetAttributes();  // clear any default values
	  if(isset($_GET['Snro']))
		$sosnro->attributes=$_GET['Snro'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'srfsnro-grid',
      'dataProvider'=>$sosnro->Searchwstatus(),
      'filter'=>$sosnro,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#srfsnro_dialog\").dialog(\"close\"); $(\"#srfsnroname\").val(\"$data->formatdoc\"); $(\"#Servicetype_srfsnroid\").val(\"$data->snroid\");
		  "))',
          ),
	array('name'=>'snroid', 'visible'=>false,'value'=>'$data->snroid','htmlOptions'=>array('width'=>'1%')),
        'formatdoc',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#srfsnro_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'sosnroid'); ?>
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
		array('servicetype/write'),
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
		array('servicetype/cancelwrite'),
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

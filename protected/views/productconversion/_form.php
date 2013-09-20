<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productconversion-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)};",
));  ?>

<?php echo $form->hiddenField($model,'productconversionid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'productid'); ?>
<?php echo $form->hiddenField($model,'productid'); ?>
	  <input type="text" name="sched_name" id="productname" title="Enter Schedule name" readonly value="<?php echo (Product::model()->findByPk($model->productid)!==null)?Product::model()->findByPk($model->productid)->productname:'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Master'),
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
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Productconversion_productid\").val(\"$data->productid\");
		  "))',
          ),
	array('name'=>'productid', 'visible'=>false,'value'=>'$data->productid','htmlOptions'=>array('width'=>'1%')),
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
		<?php echo $form->labelEx($model,'fromvalue'); ?>
		<?php echo $form->textField($model,'fromvalue',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fromvalue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fromuom'); ?>
<?php echo $form->hiddenField($model,'fromuom'); ?>
	  <input type="text" name="sched_name" id="fromuomcode" title="Enter Schedule name" readonly value="<?php echo (Unitofmeasure::model()->findByPk($model->fromuom)!==null)?Unitofmeasure::model()->findByPk($model->fromuom)->uomcode:'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'fromuom_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Unit of Measure'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'fromuom-grid',
      'dataProvider'=>$fromuom->Searchwstatus(),
      'filter'=>$fromuom,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_fromuom",
          "id" => "send_fromuom",
          "onClick" => "$(\"#fromuom_dialog\").dialog(\"close\"); $(\"#fromuomcode\").val(\"$data->uomcode\"); $(\"#Productconversion_fromuom\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
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
                          array('onclick'=>'$("#fromuom_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'fromuom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tovalue'); ?>
		<?php echo $form->textField($model,'tovalue'); ?>
		<?php echo $form->error($model,'tovalue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'touom'); ?>
<?php echo $form->hiddenField($model,'touom'); ?>
	  <input type="text" name="sched_name" id="touomcode" title="Enter Schedule name" readonly value="<?php echo (Unitofmeasure::model()->findByPk($model->touom)!==null)?Unitofmeasure::model()->findByPk($model->touom)->uomcode:'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'touom_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Unit of Measure'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'touom-grid',
      'dataProvider'=>$touom->Searchwstatus(),
      'filter'=>$touom,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_touom",
          "id" => "send_touom",
          "onClick" => "$(\"#touom_dialog\").dialog(\"close\"); $(\"#touomcode\").val(\"$data->uomcode\"); $(\"#Productconversion_touom\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
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
                          array('onclick'=>'$("#touom_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'touom'); ?>	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('productconversion/write'),
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
		array('productconversion/cancelwrite'),
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
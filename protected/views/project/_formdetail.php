<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projectbom-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'projectbomid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	

         <div class="row">
            <?php echo $form->labelEx($model,'productid'); ?>
            <?php echo $form->hiddenField($model,'productid'); ?>
                  <input type="text" name="employee_name" id="productname" readonly value="<?php echo (Product::model()->findByPk($model->productid)!==null)?Product::model()->findByPk($model->productid)->productname:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'product_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Employee'),
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
                        array("name" => "send_employee",
                        "id" => "send_employee",
                        "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Projectbom_productid\").val(\"$data->productid\");"))',
                        ),
                      'productid',
                      'productname',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#product_dialog").dialog("open"); return false;',
                                     ));?>
            <?php echo $form->error($model,'productid'); ?>
        </div>

    <div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>

    <div class="row">
            <?php echo $form->labelEx($model,'unitofmeasureid'); ?>
            <?php echo $form->hiddenField($model,'unitofmeasureid'); ?>
                  <input type="text" name="employee_name" id="uomcode" readonly value="<?php echo (Unitofmeasure::model()->findByPk($model->unitofmeasureid)!==null)?Unitofmeasure::model()->findByPk($model->unitofmeasureid)->uomcode:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'uom_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Employee'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'uom-grid',
                    'dataProvider'=>$unitofmeasure->Searchwstatus(),
                    'filter'=>$unitofmeasure,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_employee",
                        "id" => "send_employee",
                        "onClick" => "$(\"#uom_dialog\").dialog(\"close\"); $(\"#uomcode\").val(\"$data->uomcode\"); $(\"#Projectbom_unitofmeasureid\").val(\"$data->unitofmeasureid\");"))',
                        ),
                      'unitofmeasureid',
                      'uomcode',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#uom_dialog").dialog("open"); return false;',
                                     ));?>
            <?php echo $form->error($model,'unitofmeasureid'); ?>
        </div>

    <div class="row">
		<?php echo $form->labelEx($model,'serviceqty'); ?>
		<?php echo $form->textField($model,'serviceqty'); ?>
		<?php echo $form->error($model,'serviceqty'); ?>
	</div>

    <div class="row">
            <?php echo $form->labelEx($model,'serviceuomid'); ?>
            <?php echo $form->hiddenField($model,'serviceuomid'); ?>
                  <input type="text" name="employee_name" id="serviceuomcode" readonly value="
<?php echo (Unitofmeasure::model()->findByPk($model->serviceuomid)!==null)?Unitofmeasure::model()->findByPk($model->serviceuomid)->uomcode:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'serviceuom_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Employee'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'serviceuom-grid',
                    'dataProvider'=>$unitofmeasure->Searchwstatus(),
                    'filter'=>$unitofmeasure,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_employee",
                        "id" => "send_employee",
                        "onClick" => "$(\"#serviceuom_dialog\").dialog(\"close\"); $(\"#serviceuomcode\").val(\"$data->uomcode\"); $(\"#Projectbom_serviceuomid\").val(\"$data->unitofmeasureid\");"))',
                        ),
                      'unitofmeasureid',
                      'uomcode',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#serviceuom_dialog").dialog("open"); return false;',
                                     ));?>
            <?php echo $form->error($model,'serviceuomid'); ?>
        </div>

    <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writedetail'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("detaildatagrid");
			  $("#createdialog1").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->

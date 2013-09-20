<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'proreccategory-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(6)}",
));  ?>
<?php echo $form->hiddenField($model,'proreccategoryid'); ?>
<?php echo $form->hiddenField($model,'projectrecid'); ?>
	

        <div class="row">
            <?php echo $form->labelEx($model,'prosubcategoryid'); ?>
            <?php echo $form->hiddenField($model,'prosubcategoryid'); ?>
                  <input type="text" name="prosubcategoryname" id="prosubcategoryname" readonly value="
<?php echo (Prosubcategory::model()->findByPk($model->prosubcategoryid)!==null)?Prosubcategory::model()->findByPk($model->prosubcategoryid)->prosubcategoryname:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'prosubcategory_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Employee'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'prosubcategory-grid',
                    'dataProvider'=>$prosubcategory->Searchwstatus(),
                    'filter'=>$prosubcategory,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_proreccategory",
                        "id" => "send_proreccategory",
                        "onClick" => "$(\"#prosubcategory_dialog\").dialog(\"close\");
                        $(\"#prosubcategoryname\").val(\"$data->prosubcategoryname\");
                        $(\"#Proreccategory_prosubcategoryid\").val(\"$data->prosubcategoryid\");"))',
                        ),
                      'prosubcategoryid',
	array('name'=>'procategoryid','value'=>'($data->procategory!==null)?$data->procategory->procategoryname:""'),
                      'prosubcategoryname',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#proreccategory_dialog").dialog("open"); return false;',
                                     ));?>
            <?php echo $form->error($model,'proreccategoryid'); ?>
        </div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writeproreccategory'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("proreccategorydatagrid");
			  $("#createdialog7").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->

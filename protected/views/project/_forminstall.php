<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'proinstalltype-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(6)}",
));  ?>
<?php echo $form->hiddenField($model,'proinstalltypeid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	

        <div class="row">
            <?php echo $form->labelEx($model,'installtypeid'); ?>
            <?php echo $form->hiddenField($model,'installtypeid'); ?>
                  <input type="text" name="installtypename" id="installtype_name" readonly value="
<?php echo (Installtype::model()->findByPk($model->installtypeid)!==null)?Installtype::model()->findByPk($model->installtypeid)->installtypename:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'installtype_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Employee'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'installtype-grid',
                    'dataProvider'=>$installtype->Searchwstatus(),
                    'filter'=>$installtype,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_installtype",
                        "id" => "send_installtype",
                        "onClick" => "$(\"#installtype_dialog\").dialog(\"close\"); $(\"#installtype_name\").val(\"$data->installtypename\"); $(\"#Proinstalltype_installtypeid\").val(\"$data->installtypeid\");"))',
                        ),
                      'installtypeid',
                      'installtypename',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#installtype_dialog").dialog("open"); return false;',
                                     ));?>
            <?php echo $form->error($model,'installtypeid'); ?>
        </div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writeinstall'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("installtypedatagrid");
			  $("#createdialog5").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->

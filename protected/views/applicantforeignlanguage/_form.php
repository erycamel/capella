<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'applicantforeignlanguage-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'employeeforeignlanguageid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'employeeid'); ?>
<?php echo $form->hiddenField($model,'employeeid'); ?>
                  <input type="text" name="employee_name" id="employee_name" readonly value="<?php echo (Applicant::model()->findByPk($model->employeeid)!==null)?Applicant::model()->findByPk($model->employeeid)->fullname:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'employee_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Employee'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'employee-grid',
                    'dataProvider'=>$applicant->Searchwstatus(),
                    'filter'=>$applicant,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_employee",
                        "id" => "send_employee",
                        "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#employee_name\").val(\"$data->fullname\"); $(\"#Applicantforeignlanguage_employeeid\").val(\"$data->employeeid\");"))',
                        ),
                      'employeeid',
                      'fullname',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#employee_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'employeeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'languageid'); ?>
<?php echo $form->hiddenField($model,'languageid'); ?>
                  <input type="text" name="language_name" id="language_name" readonly value="<?php echo (language::model()->findByPk($model->languageid)!==null)?language::model()->findByPk($model->languageid)->languagename:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'language_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Language'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'language-grid',
                    'dataProvider'=>$language->Searchwstatus(),
                    'filter'=>$language,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_language",
                        "id" => "send_language",
                        "onClick" => "$(\"#language_dialog\").dialog(\"close\"); $(\"#language_name\").val(\"$data->languagename\"); $(\"#Applicantforeignlanguage_languageid\").val(\"$data->languageid\");"))',
                        ),
                      'languageid',
                      'languagename',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#language_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'languageid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'languagevalueid'); ?>
<?php echo $form->hiddenField($model,'languagevalueid'); ?>
                  <input type="text" name="languagevalue_name" id="languagevalue_name" readonly value="<?php echo (languagevalue::model()->findByPk($model->languagevalueid)!==null)?languagevalue::model()->findByPk($model->languagevalueid)->languagevaluename:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'languagevalue_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Language Value'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'languagevalue-grid',
                    'dataProvider'=>$languagevalue->Searchwstatus(),
                    'filter'=>$languagevalue,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_languagevalue",
                        "id" => "send_languagevalue",
                        "onClick" => "$(\"#languagevalue_dialog\").dialog(\"close\"); $(\"#languagevalue_name\").val(\"$data->languagevaluename\"); $(\"#Applicantforeignlanguage_languagevalueid\").val(\"$data->languagevalueid\");"))',
                        ),
                      'languagevalueid',
                      'languagevaluename',
                      ),
                  ));

                  $this->endWidget('zii.widgets.jui.CJuiDialog');
                  echo CHtml::Button('...',
                                        array('onclick'=>'$("#languagevalue_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'languagevalueid'); ?>
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
		array('applicantforeignlanguage/write'),
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
		array('applicantforeignlanguage/cancelwrite'),
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

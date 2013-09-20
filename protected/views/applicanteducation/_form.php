<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'applicanteducation-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'employeeeducationid'); ?>
	

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
            'dataProvider'=>$employee->Searchwstatus(),
            'filter'=>$employee,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_employee",
                "id" => "send_employee",
                "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#employee_name\").val(\"$data->fullname\"); $(\"#Applicanteducation_employeeid\").val(\"$data->employeeid\");"))',
                ),
              'employeeid',
              'fullname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#employee_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'employeeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'educationid'); ?>
    <?php echo $form->hiddenField($model,'educationid'); ?>
    <input type="text" name="education_name" id="education_name" readonly value="<?php echo (Education::model()->findByPk($model->educationid)!==null)?Education::model()->findByPk($model->educationid)->educationname:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'education_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Education'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'education-grid',
            'dataProvider'=>$education->Searchwstatus(),
            'filter'=>$education,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_education",
                "id" => "send_education",
                "onClick" => "$(\"#education_dialog\").dialog(\"close\"); $(\"#education_name\").val(\"$data->educationname\"); $(\"#Applicanteducation_educationid\").val(\"$data->educationid\");"))',
                ),
              'educationid',
              'educationname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#education_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'educationid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'schoolname'); ?>
		<?php echo $form->textField($model,'schoolname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'schoolname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cityid'); ?>
    <?php echo $form->hiddenField($model,'cityid'); ?>
    <input type="text" name="city_name" id="city_name" readonly value="<?php echo (City::model()->findByPk($model->cityid)!==null)?City::model()->findByPk($model->cityid)->cityname:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'city_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','City'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'city-grid',
            'dataProvider'=>$city->Searchwstatus(),
            'filter'=>$city,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_city",
                "id" => "send_city",
                "onClick" => "$(\"#city_dialog\").dialog(\"close\"); $(\"#city_name\").val(\"$data->cityname\"); $(\"#Applicanteducation_cityid\").val(\"$data->cityid\");"))',
                ),
              'cityid',
              'cityname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#city_dialog").dialog("open"); return false;',
                             ));?>
    <?php echo $form->error($model,'cityid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'yeargraduate'); ?>
    <?php $this->Widget('CMaskedTextField',array(
      'attribute'=>'yeargraduate','model'=>$model,'mask'=>'9999','htmlOptions'=>array(
        'style'=>'width:60px;'
    ),
    )); ?>
		<?php echo $form->error($model,'yeargraduate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isdiploma'); ?>
		<?php echo $form->checkBox($model,'isdiploma'); ?>
		<?php echo $form->error($model,'isdiploma'); ?>
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
		array('applicanteducation/write'),
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
		array('applicanteducation/cancelwrite'),
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

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'applicantfamily-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'employeefamilyid'); ?>
	

  <table>
    <tr>
      <td>
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
                        "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#employee_name\").val(\"$data->fullname\"); $(\"#Applicantfamily_employeeid\").val(\"$data->employeeid\");"))',
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
      </td>
      <td>
          <div class="row">
              <?php echo $form->labelEx($model,'familyrelationid'); ?>
              <?php echo $form->hiddenField($model,'familyrelationid'); ?>
                    <input type="text" name="familyrelation_name" id="familyrelation_name" readonly value="<?php echo (Familyrelation::model()->findByPk($model->familyrelationid)!==null)?Familyrelation::model()->findByPk($model->familyrelationid)->familyrelationname:''; ?>">
                    <?php
                      $this->beginWidget('zii.widgets.jui.CJuiDialog',
                       array(   'id'=>'familyrelation_dialog',
                                // additional javascript options for the dialog plugin
                                'options'=>array(
                                                'title'=>Yii::t('app','Family Relation'),
                                                'width'=>'auto',
                                                'autoOpen'=>false,
                                                'modal'=>true,
                                                ),
                                        ));

                    $this->widget('zii.widgets.grid.CGridView', array(
                      'id'=>'familyrelation-grid',
                      'dataProvider'=>$familyrelation->Searchwstatus(),
                      'filter'=>$familyrelation,
                      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                      'columns'=>array(
                        array(
                          'header'=>'',
                          'type'=>'raw',
                        /* Here is The Button that will send the Data to The MAIN FORM */
                          'value'=>'CHtml::Button("+",
                          array("name" => "send_familyrelation",
                          "id" => "send_familyrelation",
                          "onClick" => "$(\"#familyrelation_dialog\").dialog(\"close\"); $(\"#familyrelation_name\").val(\"$data->familyrelationname\"); $(\"#Applicantfamily_familyrelationid\").val(\"$data->familyrelationid\");"))',
                          ),
                        'familyrelationid',
                        'familyrelationname',
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
                                          array('onclick'=>'$("#familyrelation_dialog").dialog("open"); return false;',
                                       ));?>
              <?php echo $form->error($model,'familyrelationid'); ?>
            </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'familyname'); ?>
          <?php echo $form->textField($model,'familyname',array('size'=>20,'maxlength'=>50)); ?>
          <?php echo $form->error($model,'familyname'); ?>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="row">
            <?php echo $form->labelEx($model,'sexid'); ?>
        <?php echo $form->hiddenField($model,'sexid'); ?>
                  <input type="text" name="sex_name" id="sex_name" readonly value="<?php echo (Sex::model()->findByPk($model->sexid)!==null)?Sex::model()->findByPk($model->sexid)->sexname:''; ?>">
                  <?php
                    $this->beginWidget('zii.widgets.jui.CJuiDialog',
                     array(   'id'=>'sex_dialog',
                              // additional javascript options for the dialog plugin
                              'options'=>array(
                                              'title'=>Yii::t('app','Sex'),
                                              'width'=>'auto',
                                              'autoOpen'=>false,
                                              'modal'=>true,
                                              ),
                                      ));

                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'sex-grid',
                    'dataProvider'=>$sex->Searchwstatus(),
                    'filter'=>$sex,
                    'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
                    'columns'=>array(
                      array(
                        'header'=>'',
                        'type'=>'raw',
                      /* Here is The Button that will send the Data to The MAIN FORM */
                        'value'=>'CHtml::Button("+",
                        array("name" => "send_sex",
                        "id" => "send_sex",
                        "onClick" => "$(\"#sex_dialog\").dialog(\"close\"); $(\"#sex_name\").val(\"$data->sexname\"); $(\"#Applicantfamily_sexid\").val(\"$data->sexid\");"))',
                        ),
                      'sexid',
                      'sexname',
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
                                        array('onclick'=>'$("#sex_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'sexid'); ?>
          </div>
      </td>
      <td>
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
                        "onClick" => "$(\"#city_dialog\").dialog(\"close\"); $(\"#city_name\").val(\"$data->cityname\"); $(\"#Applicantfamily_cityid\").val(\"$data->cityid\");"))',
                        ),
                      'cityid',
                      'cityname',
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
                                        array('onclick'=>'$("#city_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'cityid'); ?>
          </div>
      </td>
      <td>
              <div class="row">
          <?php echo $form->labelEx($model,'birthdate'); ?>
      <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'attribute'=>'birthdate',
                    'model'=>$model,
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'fold',
						'dateFormat'=>'yy-mm-dd',
												'changeMonth'=>true,
												'changeYear'=>true
                    ),
                    'htmlOptions'=>array(
                        'style'=>'height:20px;'
                    ),
                ));?>		<?php echo $form->error($model,'birthdate'); ?>
        </div>
      </td>
    </tr>
    <tr>      
      <td>
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
                        "onClick" => "$(\"#education_dialog\").dialog(\"close\"); $(\"#education_name\").val(\"$data->educationname\"); $(\"#Applicantfamily_educationid\").val(\"$data->educationid\");"))',
                        ),
                      'educationid',
                      'educationname',
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
                                        array('onclick'=>'$("#education_dialog").dialog("open"); return false;',
                                     ));?>		<?php echo $form->error($model,'educationid'); ?>
          </div>
      </td>
      <td>
<div class="row">
		<?php echo $form->labelEx($model,'occupationid'); ?>
<?php echo $form->hiddenField($model,'occupationid'); ?>
          <input type="text" name="occupation_name" id="occupation_name" readonly value="<?php echo (Education::model()->findByPk($model->educationid)!==null)?Education::model()->findByPk($model->educationid)->educationname:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'occupation_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Occupation'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'occupation-grid',
            'dataProvider'=>$occupation->Searchwstatus(),
            'filter'=>$occupation,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_occupation",
                "id" => "send_occupation",
                "onClick" => "$(\"#occupation_dialog\").dialog(\"close\"); $(\"#occupation_name\").val(\"$data->occupationname\"); $(\"#Applicantfamily_occupationid\").val(\"$data->occupationid\");"))',
                ),
              'occupationid',
              'occupationname',
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
                                array('onclick'=>'$("#occupation_dialog").dialog("open"); return false;',
                             ));?>		<?php echo $form->error($model,'occupationid'); ?>
	</div>
      </td>
      <td>
        	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>
      </td>
    </tr>
  </table>
<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('applicantfamily/write'),
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
		array('applicantfamily/cancelwrite'),
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

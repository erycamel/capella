<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'applicant-form',
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'employeeid'); ?>
<?php echo $form->hiddenField($model,'addressbookid'); ?>
	

  <table>
    <tr>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'fullname'); ?>
          <?php echo $form->textField($model,'fullname', array('size'=>10,'maxlength'=>50)); ?>
          <?php echo $form->error($model,'fullname'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'oldnik'); ?>
          <?php echo $form->textField($model,'oldnik',array('size'=>10,'maxlength'=>50)); ?>
          <?php echo $form->error($model,'oldnik'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'orgstructureid'); ?>
          <?php echo $form->hiddenField($model,'orgstructureid'); ?>
          <input type="text" name="orgstructure_name" id="orgstructure_name" size="10" maxlength="50"  readonly value="<?php echo (Orgstructure::model()->findByPk($model->orgstructureid)!==null)?Orgstructure::model()->findByPk($model->orgstructureid)->structurename:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'orgstructure_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Organization Structure'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'orgstructure-grid',
            'dataProvider'=>$orgstructure->Searchwstatus(),
            'filter'=>$orgstructure,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_orgstructure",
                "id" => "send_orgstructure",
                "onClick" => "$(\"#orgstructure_dialog\").dialog(\"close\"); $(\"#orgstructure_name\").val(\"$data->structurename\"); $(\"#Applicant_orgstructureid\").val(\"$data->orgstructureid\");"))',
                ),
              'orgstructureid',
              'structurename',
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
                                array('onclick'=>'$("#orgstructure_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'orgstructureid'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'positionid'); ?>
          <?php echo $form->hiddenField($model,'positionid'); ?>
          <input type="text" name="position_name" id="position_name" readonly size="10" maxlength="50" value="<?php echo (Position::model()->findByPk($model->positionid)!==null)?Position::model()->findByPk($model->positionid)->positionname:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'position_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Position'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'position-grid',
            'dataProvider'=>$position->Searchwstatus(),
            'filter'=>$position,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_position",
                "id" => "send_position",
                "onClick" => "$(\"#position_dialog\").dialog(\"close\"); $(\"#position_name\").val(\"$data->positionname\"); $(\"#Applicant_positionid\").val(\"$data->positionid\");"))',
                ),
              'positionid',
              'positionname',
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
                                array('onclick'=>'$("#position_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'positionid'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'employeetypeid'); ?>
          <?php echo $form->hiddenField($model,'employeetypeid'); ?>
          <input type="text" name="employeetype_name" id="employeetype_name" size="10" maxlength="50" readonly value="<?php echo (Employeetype::model()->findByPk($model->employeetypeid)!==null)?Employeetype::model()->findByPk($model->employeetypeid)->employeetypename:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'employeetype_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Employee Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'employeetype-grid',
            'dataProvider'=>$employeetype->Searchwstatus(),
            'filter'=>$employeetype,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_employeetype",
                "id" => "send_employeetype",
                "onClick" => "$(\"#employeetype_dialog\").dialog(\"close\"); $(\"#employeetype_name\").val(\"$data->employeetypename\"); $(\"#Applicant_employeetypeid\").val(\"$data->employeetypeid\");"))',
                ),
              'employeetypeid',
              'employeetypename',
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
                                array('onclick'=>'$("#employeetype_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'employeetypeid'); ?>
        </div>
      </td>
    </tr>
    <tr>      
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'sexid'); ?>
          <?php echo $form->hiddenField($model,'sexid'); ?>
          <input type="text" name="sex_name" id="sex_name" size="10" maxlength="50" readonly value="<?php echo (Sex::model()->findByPk($model->sexid)!==null)?Sex::model()->findByPk($model->sexid)->sexname:''; ?>">
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
                "onClick" => "$(\"#sex_dialog\").dialog(\"close\"); $(\"#sex_name\").val(\"$data->sexname\"); $(\"#Applicant_sexid\").val(\"$data->sexid\");"))',
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
                             ));?>
          <?php echo $form->error($model,'sexid'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'bloodtypeid'); ?>
          <?php echo $form->hiddenField($model,'bloodtypeid'); ?>
          <input type="text" name="bloodtype_name" id="bloodtype_name" size="10" maxlength="50" readonly value="<?php echo (Bloodtype::model()->findByPk($model->bloodtypeid)!==null)?Bloodtype::model()->findByPk($model->bloodtypeid)->bloodtypename:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'bloodtype_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Blood Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'bloodtype-grid',
            'dataProvider'=>$bloodtype->Searchwstatus(),
            'filter'=>$bloodtype,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_bloodtype",
                "id" => "send_bloodtype",
                "onClick" => "$(\"#bloodtype_dialog\").dialog(\"close\"); $(\"#bloodtype_name\").val(\"$data->bloodtypename\"); $(\"#Applicant_bloodtypeid\").val(\"$data->bloodtypeid\");"))',
                ),
              'bloodtypeid',
              'bloodtypename',
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
                                array('onclick'=>'$("#bloodtype_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'bloodtypeid'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'birthcityid'); ?>
          <?php echo $form->hiddenField($model,'birthcityid'); ?>
          <input type="text" name="birthcity_name" id="birthcity_name" size="10" maxlength="50" readonly value="<?php echo (City::model()->findByPk($model->birthcityid)!==null)?City::model()->findByPk($model->birthcityid)->cityname:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'birthcity_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','City'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'birthcity-grid',
            'dataProvider'=>$birthcity->Searchwstatus(),
            'filter'=>$birthcity,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_birthcity",
                "id" => "send_birthcity",
                "onClick" => "$(\"#birthcity_dialog\").dialog(\"close\"); $(\"#birthcity_name\").val(\"$data->cityname\"); $(\"#Applicant_birthcityid\").val(\"$data->cityid\");"))',
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
                                array('onclick'=>'$("#birthcity_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'birthcityid'); ?>
        </div>
        <div class="row">
          <?php echo $form->labelEx($model,'birthdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'birthdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                   'yearRange'=>'1900:+0'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
          <?php echo $form->error($model,'birthdate'); ?>
        </div>      
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'religionid'); ?>
          <?php echo $form->hiddenField($model,'religionid'); ?>
          <input type="text" name="religion_name" id="religion_name" size="10" maxlength="50" readonly value="<?php echo (City::model()->findByPk($model->religionid)!==null)?City::model()->findByPk($model->religionid)->cityname:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'religion_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Religion'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'religion-grid',
            'dataProvider'=>$religion->Searchwstatus(),
            'filter'=>$religion,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_religion",
                "id" => "send_religion",
                "onClick" => "$(\"#religion_dialog\").dialog(\"close\"); $(\"#religion_name\").val(\"$data->religionname\"); $(\"#Applicant_religionid\").val(\"$data->religionid\");"))',
                ),
              'religionid',
              'religionname',
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
                                array('onclick'=>'$("#religion_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'religionid'); ?>
        </div>
      </td>
            <td>
        <div class="row">
          <?php echo $form->labelEx($model,'maritalstatusid'); ?>
          <?php echo $form->hiddenField($model,'maritalstatusid'); ?>     
          <input type="text" name="maritalstatus_name" id="maritalstatus_name" size="10" maxlength="50" readonly value="<?php echo (Maritalstatus::model()->findByPk($model->maritalstatusid)!==null)?Maritalstatus::model()->findByPk($model->maritalstatusid)->maritalstatusname:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'maritalstatus_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Marital Status'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'maritalstatus-grid',
            'dataProvider'=>$maritalstatus->Searchwstatus(),
            'filter'=>$maritalstatus,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_maritalstatus",
                "id" => "send_maritalstatus",
                "onClick" => "$(\"#maritalstatus_dialog\").dialog(\"close\"); $(\"#maritalstatus_name\").val(\"$data->maritalstatusname\"); $(\"#Applicant_maritalstatusid\").val(\"$data->maritalstatusid\");"))',
                ),
              'maritalstatusid',
              'maritalstatusname',
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
                                array('onclick'=>'$("#maritalstatus_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'maritalstatusid'); ?>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'tribeid'); ?>
          <?php echo $form->hiddenField($model,'tribeid'); ?>
          <input type="text" name="tribe_name" id="tribe_name" size="10" maxlength="50" readonly value="<?php echo (Tribe::model()->findByPk($model->tribeid)!==null)?Tribe::model()->findByPk($model->tribeid)->tribename:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'tribe_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Tribe'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'tribe-grid',
            'dataProvider'=>$tribe->Searchwstatus(),
            'filter'=>$tribe,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_tribe",
                "id" => "send_tribe",
                "onClick" => "$(\"#tribe_dialog\").dialog(\"close\"); $(\"#tribe_name\").val(\"$data->tribename\"); $(\"#Applicant_tribeid\").val(\"$data->tribeid\");"))',
                ),
              'tribeid',
              'tribename',
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
                                array('onclick'=>'$("#tribe_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'tribeid'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'referenceby'); ?>
          <?php echo $form->textField($model,'referenceby',array('size'=>10,'maxlength'=>50)); ?>
          <?php echo $form->error($model,'referenceby'); ?>
        </div>
      </td>
            <td>
        <div class="row">
          <?php echo $form->labelEx($model,'joindate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'name'=>'joindate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px;',
                  'size'=>'10'
              ),
          ));?>
          <?php echo $form->error($model,'joindate'); ?>
        </div>
      </td>
            <td>
        <div class="row">
          <?php echo $form->labelEx($model,'employeestatusid'); ?>
          <?php echo $form->hiddenField($model,'employeestatusid'); ?>
          <input type="text" name="employeestatus_name" id="employeestatus_name" size="10" maxlength="50" readonly value="<?php echo (Employeestatus::model()->findByPk($model->employeestatusid)!==null)?Employeestatus::model()->findByPk($model->employeestatusid)->employeestatusname:''; ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'employeestatus_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Employee Status'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'employeestatus-grid',
            'dataProvider'=>$employeestatus->Searchwstatus(),
            'filter'=>$employeestatus,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_employeestatus",
                "id" => "send_employeestatus",
                "onClick" => "$(\"#employeestatus_dialog\").dialog(\"close\"); $(\"#employeestatus_name\").val(\"$data->employeestatusname\"); $(\"#Applicant_employeestatusid\").val(\"$data->employeestatusid\");"))',
                ),
              'employeestatusid',
              'employeestatusname',
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
                                array('onclick'=>'$("#employeestatus_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'employeestatusid'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'istrial'); ?>
          <?php echo $form->checkBox($model,'istrial'); ?>
          <?php echo $form->error($model,'istrial'); ?>
        </div>
      </td>
    </tr>
    <tr>      
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'bodyheight'); ?>
          <?php echo $form->textField($model,'bodyheight', array('size'=>10)); ?>
          <?php echo $form->error($model,'bodyheight'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'bodyweight'); ?>
          <?php echo $form->textField($model,'bodyweight', array('size'=>10)); ?>
          <?php echo $form->error($model,'bodyweight'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'dresssize'); ?>
          <?php echo $form->textField($model,'dresssize',array('size'=>10,'maxlength'=>10)); ?>
          <?php echo $form->error($model,'dresssize'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'resigndate'); ?>
		  <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'name'=>'resigndate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px;',
                  'size'=>'10'
              ),
          ));?>
          <?php echo $form->error($model,'resigndate'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'shoesize'); ?>
          <?php echo $form->textField($model,'shoesize',array('size'=>10,'maxlength'=>10)); ?>
          <?php echo $form->error($model,'shoesize'); ?>
        </div>
      </td>
    </tr>
  </table>
	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('applicant/write'),
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
		array('applicant/cancelwrite'),
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
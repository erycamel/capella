<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-form',
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
          <?php echo $form->textField($model,'fullname', array('maxlength'=>50)); ?>
          <?php echo $form->error($model,'fullname'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'orgstructureid'); ?>
          <?php echo $form->hiddenField($model,'orgstructureid'); ?>
          <input type="text" name="orgstructure_name" id="orgstructure_name" size="10" maxlength="50"  readonly >
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
                "onClick" => "$(\"#orgstructure_dialog\").dialog(\"close\"); $(\"#orgstructure_name\").val(\"$data->structurename\"); $(\"#Employee_orgstructureid\").val(\"$data->orgstructureid\");"))',
                ),
	array('name'=>'orgstructureid', 'visible'=>false,'value'=>'$data->orgstructureid','htmlOptions'=>array('width'=>'1%')),
              'structurename',
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
          <input type="text" name="position_name" id="position_name" readonly size="10" maxlength="50" >
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
                "onClick" => "$(\"#position_dialog\").dialog(\"close\"); $(\"#position_name\").val(\"$data->positionname\"); $(\"#Employee_positionid\").val(\"$data->positionid\");"))',
                ),
	array('name'=>'positionid', 'visible'=>false,'value'=>'$data->positionid','htmlOptions'=>array('width'=>'1%')),
              'positionname',
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
          <?php echo $form->labelEx($model,'levelorgid'); ?>
          <?php echo $form->hiddenField($model,'levelorgid'); ?>
          <input type="text" name="levelorgname" id="levelorgname" size="10" maxlength="50"  readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'levelorg_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Level Organization'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'levelorg-grid',
            'dataProvider'=>$levelorg->Searchwstatus(),
            'filter'=>$levelorg,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_orgstructure",
                "id" => "send_orgstructure",
                "onClick" => "$(\"#levelorg_dialog\").dialog(\"close\");
                $(\"#levelorgname\").val(\"$data->levelorgname\");
                $(\"#Employee_levelorgid\").val(\"$data->levelorgid\");"))',
                ),
	array('name'=>'levelorgid', 'visible'=>false,'value'=>'$data->levelorgid','htmlOptions'=>array('width'=>'1%')),
              'levelorgname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#levelorg_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'levelorgid'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'employeetypeid'); ?>
          <?php echo $form->hiddenField($model,'employeetypeid'); ?>
          <input type="text" name="employeetype_name" id="employeetype_name" size="10" maxlength="50" readonly >
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
                "onClick" => "$(\"#employeetype_dialog\").dialog(\"close\"); $(\"#employeetype_name\").val(\"$data->employeetypename\"); $(\"#Employee_employeetypeid\").val(\"$data->employeetypeid\");"))',
                ),
	array('name'=>'employeetypeid', 'visible'=>false,'value'=>'$data->employeetypeid','htmlOptions'=>array('width'=>'1%')),
              'employeetypename',
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
          <input type="text" name="sex_name" id="sex_name" size="10" maxlength="50" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'sex_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','sex'),
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
                "onClick" => "$(\"#sex_dialog\").dialog(\"close\"); $(\"#sex_name\").val(\"$data->sexname\"); $(\"#Employee_sexid\").val(\"$data->sexid\");"))',
                ),
	array('name'=>'sexid', 'visible'=>false,'value'=>'$data->sexid','htmlOptions'=>array('width'=>'1%')),
              'sexname',
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
          <?php echo $form->labelEx($model,'birthcityid'); ?>
          <?php echo $form->hiddenField($model,'birthcityid'); ?>
          <input type="text" name="birthcity_name" id="birthcity_name" size="10" maxlength="50" readonly >
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
                "onClick" => "$(\"#birthcity_dialog\").dialog(\"close\"); $(\"#birthcity_name\").val(\"$data->cityname\"); $(\"#Employee_birthcityid\").val(\"$data->cityid\");"))',
                ),
	array('name'=>'cityid', 'visible'=>false,'value'=>'$data->cityid','htmlOptions'=>array('width'=>'1%')),
              'cityname',
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
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
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
          <input type="text" name="religion_name" id="religion_name" size="10" maxlength="50" readonly >
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
                "onClick" => "$(\"#religion_dialog\").dialog(\"close\"); $(\"#religion_name\").val(\"$data->religionname\"); $(\"#Employee_religionid\").val(\"$data->religionid\");"))',
                ),
	array('name'=>'religionid', 'visible'=>false,'value'=>'$data->religionid','htmlOptions'=>array('width'=>'1%')),
              'religionname',
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
          <input type="text" name="maritalstatus_name" id="maritalstatus_name" size="10" maxlength="50" readonly >
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
                "onClick" => "$(\"#maritalstatus_dialog\").dialog(\"close\"); $(\"#maritalstatus_name\").val(\"$data->maritalstatusname\"); $(\"#Employee_maritalstatusid\").val(\"$data->maritalstatusid\");"))',
                ),
	array('name'=>'maritalstatusid', 'visible'=>false,'value'=>'$data->maritalstatusid','htmlOptions'=>array('width'=>'1%')),
              'maritalstatusname',
              ),
          ));
          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#maritalstatus_dialog").dialog("open"); return false;',
                             ));?>
          <?php echo $form->error($model,'maritalstatusid'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'referenceby'); ?>
          <?php echo $form->textField($model,'referenceby',array('size'=>10,'maxlength'=>50)); ?>
          <?php echo $form->error($model,'referenceby'); ?>
        </div>
      </td>
    </tr>
    <tr>      
            <td>
        <div class="row">
          <?php echo $form->labelEx($model,'joindate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'joindate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
          <?php echo $form->error($model,'joindate'); ?>
        </div>
      </td>
            <td>
        <div class="row">
          <?php echo $form->labelEx($model,'employeestatusid'); ?>
          <?php echo $form->hiddenField($model,'employeestatusid'); ?>
          <input type="text" name="employeestatus_name" id="employeestatus_name" size="10" maxlength="50" readonly >
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
                "onClick" => "$(\"#employeestatus_dialog\").dialog(\"close\"); $(\"#employeestatus_name\").val(\"$data->employeestatusname\"); $(\"#Employee_employeestatusid\").val(\"$data->employeestatusid\");"))',
                ),
	array('name'=>'employeestatusid', 'visible'=>false,'value'=>'$data->employeestatusid','htmlOptions'=>array('width'=>'1%')),
              'employeestatusname',
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
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'dplkno'); ?>
          <?php echo $form->textField($model,'dplkno', array('size'=>20)); ?>
          <?php echo $form->error($model,'dplkno'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'accountno'); ?>
          <?php echo $form->textField($model,'accountno'); ?>
          <?php echo $form->error($model,'accountno'); ?>
        </div>
      </td>
    </tr>
    <tr>      
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'resigndate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'resigndate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
          <?php echo $form->error($model,'resigndate'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'email'); ?>
          <?php echo $form->textField($model,'email'); ?>
          <?php echo $form->error($model,'email'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'alternateemail'); ?>
          <?php echo $form->textField($model,'alternateemail'); ?>
          <?php echo $form->error($model,'alternateemail'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'phoneno'); ?>
          <?php echo $form->textField($model,'phoneno'); ?>
          <?php echo $form->error($model,'phoneno'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'hpno'); ?>
          <?php echo $form->textField($model,'hpno'); ?>
          <?php echo $form->error($model,'hpno'); ?>
        </div>
      </td>
    </tr>
    <tr>      
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'hpno2'); ?>
          <?php echo $form->textField($model,'hpno2'); ?>
          <?php echo $form->error($model,'hpno2'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'taxno'); ?>
          <?php echo $form->textField($model,'taxno'); ?>
          <?php echo $form->error($model,'taxno'); ?>
        </div>
      </td>
      <td>
        <div class="row">
          <?php echo $form->labelEx($model,'medical'); ?>
          <?php echo $form->textField($model,'medical'); ?>
          <?php echo $form->error($model,'medical'); ?>
        </div>
      </td>
	  <td>
        <div class="row">
          <?php echo $form->labelEx($model,'oldnik'); ?>
          <?php echo $form->textField($model,'oldnik'); ?>
          <?php echo $form->error($model,'oldnik'); ?>
        </div>
      </td>
    </tr>
  </table>
	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('employee/write'),
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
		array('employee/cancelwrite'),
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
<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'soheader-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)};",
));  ?>
	
<?php echo $form->hiddenField($model,'soheaderid'); ?>

	<table>
		<tr>
			<td>
						<div class="row">
					<?php echo $form->labelEx($model,'addressbookid'); ?>
				<?php echo $form->hiddenField($model,'addressbookid'); ?>
				<input type="text" name="stat_name" id="fullname" readonly value="<?php echo (Customer::model()->findByPk($model->addressbookid)!==null)?Customer::model()->findByPk($model->addressbookid)->fullname:''; ?>">
				<?php
				  $this->beginWidget('zii.widgets.jui.CJuiDialog',
				   array('id'=>'addressbook_dialog',
							// additional javascript options for the dialog plugin
							'options'=>array(
											'title'=>Yii::t('app','Customer'),
											'width'=>'auto',
											'autoOpen'=>false,
											'modal'=>true
											),
									));
				  $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'customer-grid',
					'dataProvider'=>$customer->searchwstatus(),
					'filter'=>$customer,
					'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
					'columns'=>array(
					array(
					  'header'=>'',
					  'type'=>'raw',
					/* Here is The Button that will send the Data to The MAIN FORM */
					  'value'=>'CHtml::Button("+",
					  array("name" => "send_absstatus",
					  "id" => "send_absstatus",
					  "onClick" => "$(\"#addressbook_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->fullname\"); $(\"#Soheader_addressbookid\").val(\"$data->addressbookid\");"))',
					  ),
				array('name'=>'addressbookid','visible'=>false, 'header'=>'ID','value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
					  'fullname',
					),
				  ));
				$this->endWidget('zii.widgets.jui.CJuiDialog');
				echo CHtml::Button('...',
									  array('onclick'=>'$("#addressbook_dialog").dialog("open"); return false;',
								   ))
				?>
					<?php echo $form->error($model,'addressbookid'); ?>
				</div>
			</td>
			<td>
				<div class="row">
					<?php echo $form->labelEx($model,'contractno'); ?>
					<?php echo $form->textField($model,'contractno'); ?>
					<?php echo $form->error($model,'contractno'); ?>
				</div>
			</td>
			<td>
			<div class="row">
		<?php echo $form->labelEx($model,'startdate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'startdate',
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
		<?php echo $form->error($model,'startdate'); ?>
	</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="row">
		<?php echo $form->labelEx($model,'enddate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'enddate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+20'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
		<?php echo $form->error($model,'enddate'); ?>
	</div>
			</td>
			<td>
				<div class="row">
		<?php echo $form->labelEx($model,'projectvalue'); ?>
		<?php echo $form->textField($model,'projectvalue'); ?>
		<?php echo $form->error($model,'projectvalue'); ?>
	</div>
			</td>
			<td>
			<div class="row">
					<?php echo $form->labelEx($model,'currencyid'); ?>
				<?php echo $form->hiddenField($model,'currencyid'); ?>
				<input type="text" name="currencyname" id="currencyname" readonly 
				value="<?php echo (Currency::model()->findByPk($model->currencyid)!==null)?Currency::model()->findByPk($model->currencyid)->currencyname:''; ?>">
				<?php
				  $this->beginWidget('zii.widgets.jui.CJuiDialog',
				   array('id'=>'currency_dialog',
							// additional javascript options for the dialog plugin
							'options'=>array(
											'title'=>Yii::t('app','Currency'),
											'width'=>'auto',
											'autoOpen'=>false,
											'modal'=>true
											),
									));
				  $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'currency-grid',
					'dataProvider'=>$currency->searchwstatus(),
					'filter'=>$currency,
					'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
					'columns'=>array(
					array(
					  'header'=>'',
					  'type'=>'raw',
					/* Here is The Button that will send the Data to The MAIN FORM */
					  'value'=>'CHtml::Button("+",
					  array("name" => "send_absstatus",
					  "id" => "send_absstatus",
					  "onClick" => "$(\"#currency_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); $(\"#Soheader_currencyid\").val(\"$data->currencyid\");"))',
					  ),
				array('name'=>'currencyid','visible'=>false, 'header'=>'ID','value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
					  'currencyname',
					),
				  ));
				$this->endWidget('zii.widgets.jui.CJuiDialog');
				echo CHtml::Button('...',
									  array('onclick'=>'$("#currency_dialog").dialog("open"); return false;',
								   ))
				?>
					<?php echo $form->error($model,'currencyid'); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td>
			 <div class="row">
		<?php echo $form->labelEx($model,'projecttypeid'); ?>
    <?php echo $form->hiddenField($model,'projecttypeid'); ?>
    <input type="text" name="projecttypecode" id="projecttypecode" readonly 
	value="<?php echo (Projecttype::model()->findByPk($model->projecttypeid)!==null)?Projecttype::model()->findByPk($model->projecttypeid)->projecttypecode:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'projecttype_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Project Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'projecttype-grid',
        'dataProvider'=>$projecttype->searchwstatus(),
        'filter'=>$projecttype,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#projecttype_dialog\").dialog(\"close\"); $(\"#projecttypecode\").val(\"$data->projecttypecode\"); $(\"#Soheader_projecttypeid\").val(\"$data->projecttypeid\");"))',
          ),
	array('name'=>'projecttypeid','visible'=>false, 'header'=>'ID','value'=>'$data->projecttypeid','htmlOptions'=>array('width'=>'1%')),
          'projecttypecode',
		  'description'
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#projecttype_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'addressbookid'); ?>
	</div>
			</td>
			<td>
			<div class="row">
		<?php echo $form->labelEx($model,'projectname'); ?>
		<?php echo $form->textField($model,'projectname'); ?>
		<?php echo $form->error($model,'projectname'); ?>
	</div>
			</td>
			<td>
			<div class="row">
		<?php echo $form->labelEx($model,'personincharge'); ?>
		<?php echo $form->textField($model,'personincharge'); ?>
		<?php echo $form->error($model,'personincharge'); ?>
	</div>
			</td>
		</tr>
		<tr>
		<td>
		<div class="row">
					<?php echo $form->labelEx($model,'employeeid'); ?>
				<?php echo $form->hiddenField($model,'employeeid'); ?>
				<input type="text" name="employeename" id="employeename" readonly 
				value="<?php echo (Employee::model()->findByPk($model->employeeid)!==null)?Employee::model()->findByPk($model->employeeid)->fullname:''; ?>">
				<?php
				  $this->beginWidget('zii.widgets.jui.CJuiDialog',
				   array('id'=>'employee_dialog',
							// additional javascript options for the dialog plugin
							'options'=>array(
											'title'=>Yii::t('app','Employee'),
											'width'=>'auto',
											'autoOpen'=>false,
											'modal'=>true
											),
									));
				  $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'employee-grid',
					'dataProvider'=>$employee->searchwstatus(),
					'filter'=>$employee,
					'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
					'columns'=>array(
					array(
					  'header'=>'',
					  'type'=>'raw',
					/* Here is The Button that will send the Data to The MAIN FORM */
					  'value'=>'CHtml::Button("+",
					  array("name" => "send_absstatus",
					  "id" => "send_absstatus",
					  "onClick" => "$(\"#employee_dialog\").dialog(\"close\"); $(\"#employeename\").val(\"$data->fullname\"); $(\"#Soheader_employeeid\").val(\"$data->employeeid\");"))',
					  ),
				array('name'=>'employeeid','visible'=>false, 'header'=>'ID','value'=>'$data->employeeid','htmlOptions'=>array('width'=>'1%')),
					  'fullname',
					),
				  ));
				$this->endWidget('zii.widgets.jui.CJuiDialog');
				echo CHtml::Button('...',
									  array('onclick'=>'$("#employee_dialog").dialog("open"); return false;',
								   ))
				?>
					<?php echo $form->error($model,'employeeid'); ?>
				</div>
		</td>
		<td>
<div class="row">
					<?php echo $form->labelEx($model,'servicetypeid'); ?>
				<?php echo $form->hiddenField($model,'servicetypeid'); ?>
				<input type="text" name="servicetypename" id="servicetypename" readonly 
				value="<?php echo (Servicetype::model()->findByPk($model->servicetypeid)!==null)?Servicetype::model()->findByPk($model->servicetypeid)->servicetypename:''; ?>">
				<?php
				  $this->beginWidget('zii.widgets.jui.CJuiDialog',
				   array('id'=>'servicetype_dialog',
							// additional javascript options for the dialog plugin
							'options'=>array(
											'title'=>Yii::t('app','Service Type'),
											'width'=>'auto',
											'autoOpen'=>false,
											'modal'=>true
											),
									));
				  $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'servicetype-grid',
					'dataProvider'=>$servicetype->searchwstatus(),
					'filter'=>$servicetype,
					'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
					'columns'=>array(
					array(
					  'header'=>'',
					  'type'=>'raw',
					/* Here is The Button that will send the Data to The MAIN FORM */
					  'value'=>'CHtml::Button("+",
					  array("name" => "send_absstatus",
					  "id" => "send_absstatus",
					  "onClick" => "$(\"#servicetype_dialog\").dialog(\"close\"); $(\"#servicetypename\").val(\"$data->servicetypename\"); $(\"#Soheader_servicetypeid\").val(\"$data->servicetypeid\");"))',
					  ),
				array('name'=>'servicetypeid','visible'=>false, 'header'=>'ID','value'=>'$data->servicetypeid','htmlOptions'=>array('width'=>'1%')),
					  'servicetypename',
					),
				  ));
				$this->endWidget('zii.widgets.jui.CJuiDialog');
				echo CHtml::Button('...',
									  array('onclick'=>'$("#servicetype_dialog").dialog("open"); return false;',
								   ))
				?>
					<?php echo $form->error($model,'currencyid'); ?>
				</div>		</td>
		
		</tr>
	</table>
		  <div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

		<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('soheader/write'),
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
		array('soheader/cancelwrite'),
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
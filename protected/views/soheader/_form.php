<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'genjournal-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'soheaderid');?>
	<table>
	  <tr>
	  <td>
	   <div class="row">
		<?php echo $form->labelEx($model,'sodate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'sodate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'-10:+10'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'15',
              ),
          ));?>
		<?php echo $form->error($model,'sodate'); ?>
	</div>
	  </td>
		     <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'addressbookid'); ?>
		<?php echo $form->hiddenField($model,'addressbookid'); ?>
	  <input type="text" name="product_name" id="fullname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'addressbook_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Customer'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
		$customer=new Customer('search');
	  $customer->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$customer->attributes=$_GET['Customer'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'addressbook-grid',
      'dataProvider'=>$customer->Searchwstatus(),
      'filter'=>$customer,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#addressbook_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->fullname\"); $(\"#Soheader_addressbookid\").val(\"$data->addressbookid\");
		  "))',
          ),
	array('name'=>'addressbookid', 'visible'=>false,'value'=>'$data->addressbookid'),
        'fullname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("addressbook-grid");$("#addressbook_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'addressbookid'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'paymentmethodid'); ?>
		<?php echo $form->hiddenField($model,'paymentmethodid'); ?>
	  <input type="text" name="product_name" id="paycode" readonly />
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'paymentmethod_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Payment Method'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
      $paymentmethod=new Paymentmethod('search');
	  $paymentmethod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Paymentmethod']))
		$paymentmethod->attributes=$_GET['Paymentmethod'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'paymentmethod-grid',
      'dataProvider'=>$paymentmethod->Searchwstatus(),
      'filter'=>$paymentmethod,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#paymentmethod_dialog\").dialog(\"close\");$(\"#paycode\").val(\"$data->paycode\");$(\"#Soheader_paymentmethodid\").val(\"$data->paymentmethodid\");
		  "))',
          ),
	array('name'=>'paymentmethodid', 'visible'=>false,'value'=>'$data->paymentmethodid'),
        'paycode',
          'paydays',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("paymentmethod-grid");$("#paymentmethod_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'paymentmethodid'); ?>
	</div>
		</td>
        	  </tr>
			  <tr>
			  <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'employeeid'); ?>
		<?php echo $form->hiddenField($model,'employeeid'); ?>
	  <input type="text" name="employeename" id="employeename" readonly />
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
      $employee=new Employee('search');
	  $employee->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$employee->attributes=$_GET['Employee'];
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
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#employee_dialog\").dialog(\"close\");$(\"#employeename\").val(\"$data->fullname\");
		  $(\"#Soheader_employeeid\").val(\"$data->employeeid\");
		  "))',
          ),
	array('name'=>'employeeid', 'visible'=>false,'value'=>'$data->employeeid'),
        'fullname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("employee-grid");$("#employee_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'employeeid'); ?>
	</div>
		</td>
				<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'headernote'); ?>
		<?php echo $form->textArea($model,'headernote',array('rows'=>3, 'cols'=>30)); ?>
		<?php echo $form->error($model,'headernote'); ?>
	</div>
		</td>
			  </tr>
			  <tr>
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
                                  'yearRange'=>'-10:+10'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'15',
              ),
          ));?>
		<?php echo $form->error($model,'startdate'); ?>
	</div>
	  </td>
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
                                  'yearRange'=>'-10:+10'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'15',
              ),
          ));?>
		<?php echo $form->error($model,'enddate'); ?>
	</div>
	  </td>
			  </tr>
	</table>
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
	<?php
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs' => array(
		'Detail' => array('content' => $this->renderPartial('indexdetail',
				  array('sodetail'=>$sodetail),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->
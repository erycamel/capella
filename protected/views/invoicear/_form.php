<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'invoiceid'); ?>
     
	<table class="table-condensed" style="width:100%">
	<tr> 
			<td>
		<div class="row">
          <?php echo $form->labelEx($model,'invoicedate'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'invoicedate',
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
          ));?>          <?php echo $form->error($model,'invoicedate'); ?>
        </div>
		</td>
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'soheaderid'); ?>
          <?php echo $form->hiddenField($model,'soheaderid'); ?>
    <input type="text" name="sono" id="sono" readonly>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'so_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Sales Order'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$soheader=new Soheader('searchwfstatus');
	  $soheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Soheader']))
		$soheader->attributes=$_GET['Soheader'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'soheader-grid',
        'dataProvider'=>$soheader->searchwfinvstatus(),
        'filter'=>$soheader,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#so_dialog\").dialog(\"close\"); $(\"#sono\").val(\"$data->sono\"); 
		  $(\"#Invoice_soheaderid\").val(\"$data->soheaderid\");
		  $(\"#Invoice_invoicedate\").val(\"$data->sodate\");
		  generatedata();"))',
          ),
	array('name'=>'soheaderid', 'visible'=>false,
        'value'=>'$data->soheaderid','htmlOptions'=>array('width'=>'1%')),
          'sono',      
          array(
      'name'=>'sodate',
      'type'=>'raw',
         'value'=>'($data->sodate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->sodate)):""'
     ),
          array('name'=>'addressbookid','value'=>'($data->customer!==null)?$data->customer->fullname:""'),
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("soheader-grid");$("#so_dialog").dialog("open"); return false;',
                       ))?>
          <?php echo $form->error($model,'sono'); ?>
        </div>
		</td>
		</tr>
		<tr>
<td>
		<div class="row">
          <?php echo $form->labelEx($model,'amount'); ?>
          <?php echo $form->textField($model,'amount'); ?>
          <?php echo $form->error($model,'amount'); ?>
        </div>
		</td>
		<td>
		<?php echo $form->labelEx($model,'currencyid'); ?>
    <?php echo $form->hiddenField($model,'currencyid'); ?>
    <input type="text" name="currencyname" id="currencyname" readonly>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'currency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Currency'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$currency=new Currency('searchwfstatus');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];
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
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); 
		  $(\"#Invoice_currencyid\").val(\"$data->currencyid\");"))',
          ),
	array('name'=>'currencyid', 'visible'=>false,
        'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
          'currencyname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("currency-grid");$("#currency_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'currencyid'); ?>
		</td>
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'rate'); ?>
          <?php echo $form->textField($model,'rate'); ?>
          <?php echo $form->error($model,'rate'); ?>
        </div>
		</td>		
		</tr>
		<tr>
		<td>
		<?php echo $form->labelEx($model,'taxid'); ?>
    <?php echo $form->hiddenField($model,'taxid'); ?>
    <input type="text" name="taxcode" id="taxcode" readonly>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'tax_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Tax'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
$tax=new Tax('searchwfstatus');
	  $tax->unsetAttributes();  // clear any default values
	  if(isset($_GET['Tax']))
		$tax->attributes=$_GET['Tax'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'tax-grid',
        'dataProvider'=>$tax->searchwstatus(),
        'filter'=>$tax,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#tax_dialog\").dialog(\"close\"); $(\"#taxcode\").val(\"$data->taxcode\"); 
		  $(\"#Invoice_taxid\").val(\"$data->taxid\");"))',
          ),
	array('name'=>'taxid', 'visible'=>false,
        'value'=>'$data->taxid','htmlOptions'=>array('width'=>'1%')),
          'taxcode',
		  'taxvalue'
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("tax-grid");$("#tax_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'taxid'); ?>
		</td>
		<td>
		<?php echo $form->labelEx($model,'paymentmethodid'); ?>
    <?php echo $form->hiddenField($model,'paymentmethodid'); ?>
    <input type="text" name="paycode" id="paycode" readonly>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'pay_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Payment Method'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$paymentmethod=new Paymentmethod('searchwfstatus');
	  $paymentmethod->unsetAttributes();  // clear any default values
	  if(isset($_GET['Paymentmethod']))
		$paymentmethod->attributes=$_GET['Paymentmethod'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'pay-grid',
        'dataProvider'=>$paymentmethod->searchwstatus(),
        'filter'=>$paymentmethod,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#pay_dialog\").dialog(\"close\"); $(\"#paycode\").val(\"$data->paycode\"); 
		  $(\"#Invoice_paymentmethodid\").val(\"$data->paymentmethodid\");"))',
          ),
	array('name'=>'paymentmethodid', 'visible'=>false,
        'value'=>'$data->paymentmethodid','htmlOptions'=>array('width'=>'1%')),
          'paycode',
		  'paydays'
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("pay-grid");$("#pay_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'paymentmethodid'); ?>
		</td>
		<td>
		<div class="row">
          <?php echo $form->labelEx($model,'headernote'); ?>
          <?php echo $form->textArea($model,'headernote'); ?>
          <?php echo $form->error($model,'headernote'); ?>
        </div>
		</td>		
	</tr>
	</table>
		<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('invoicear/write'),
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
		array('invoicear/cancelwrite'),
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
         'Detail' => array('content' => $this->renderPartial('indexinvoicedet',
			 array('invoicedet'=>$invoicedet),true)),
         'Journal' => array('content' => $this->renderPartial('indexinvoiceacc',
			 array('invoiceacc'=>$invoiceacc),true)),
/*         'Informal' => array('content' => $this->renderPartial('indexinformal',
			 array('employeeinformal'=>$employeeinformal),true)),
         'Working Experience' => array('content' => $this->renderPartial('indexwo',
			 array('employeewo'=>$employeewo),true)),
         'Family' => array('content' => $this->renderPartial('indexfamily',
			 array('employeefamily'=>$employeefamily),true)),*/
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->

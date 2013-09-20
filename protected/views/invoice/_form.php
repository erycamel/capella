<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
<?php echo $form->hiddenField($model,'invoiceid'); ?>
	
	<table>
	  <tr>
        <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'poheaderid'); ?>
<?php echo $form->hiddenField($model,'poheaderid'); ?>
	  <input type="text" name="account_name" id="pono" title="Account name" readonly value="<?php
echo (Poheader::model()->findByPk($model->poheaderid)!==null)?Poheader::model()->findByPk($model->poheaderid)->pono:''; ?>">
<?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'poheader_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Purchase Order'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$poheader=new Poheader('searchwfstatus');
	  $poheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Poheader']))
		$poheader->attributes=$_GET['Poheader'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'poheader-grid',
      'dataProvider'=>$poheader->Searchwfstatus(),
      'filter'=>$poheader,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#poheader_dialog\").dialog(\"close\"); $(\"#pono\").val(\"$data->pono\"); $(\"#Invoice_poheaderid\").val(\"$data->poheaderid\");
          generatedata();
		  "))',
          ),
        'poheaderid',
        'pono',
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
                          array('onclick'=>'$("#poheader_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'poheaderid'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'invoiceno'); ?>
		<?php echo $form->textField($model,'invoiceno',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'invoiceno'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'invoicedate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'invoicedate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?> format: yyyy-mm-dd
		<?php echo $form->error($model,'invoicedate'); ?>
	</div>
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'addressbookid'); ?>
<?php echo $form->hiddenField($model,'addressbookid'); ?>
	  <input type="text" name="account_name" id="fullname" title="Account name" readonly value="<?php
echo (Supplier::model()->findByPk($model->addressbookid)!==null)?Supplier::model()->findByPk($model->addressbookid)->fullname:''; ?>">
<?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'supplier_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Supplier'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$addressbook=new Supplier('searchwstatus');
	  $addressbook->unsetAttributes();  // clear any default values
	  if(isset($_GET['Supplier']))
		$addressbook->attributes=$_GET['Supplier'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'supplier-grid',
      'dataProvider'=>$addressbook->Searchwstatus(),
      'filter'=>$addressbook,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#supplier_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->fullname\"); $(\"#Invoice_addressbookid\").val(\"$data->addressbookid\");
		  "))',
          ),
        'addressbookid',
        'fullname',
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
                          array('onclick'=>'$("#supplier_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'addressbookid'); ?>
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
		array('invoice/write'),
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
		array('invoice/cancelwrite'),
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
		'Material' => array('content' => $this->renderPartial('indexdetail',
			array('invoicemat'=>$invoicemat),true)),
		'Payment' => array('content' => $this->renderPartial('indexpay',
			array('invoicepay'=>$invoicepay),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->
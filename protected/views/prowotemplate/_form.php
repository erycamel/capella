<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prowotemplate-form',
	'enableAjaxValidation'=>false,
)); ?>
      <?php
    $imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));?>
<?php echo $form->hiddenField($model,'prowotemplateid'); ?>
	
    <table>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'projecttypeid'); ?>
            <?php echo $form->hiddenField($model,'projecttypeid'); ?>
<input type="text" name="sched_name" id="protypedescription" title="Enter Schedule name" readonly value="<?php
echo (Projecttype::model()->findByPk($model->projecttypeid)!==null)?Projecttype::model()->findByPk($model->projecttypeid)->description :'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'projecttype_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Project Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'projecttype-grid',
      'dataProvider'=>$projecttype->Searchwstatus(),
      'filter'=>$projecttype,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#projecttype_dialog\").dialog(\"close\");
          $(\"#protypedescription\").val(\"$data->description\");
          $(\"#Prowotemplate_projecttypeid\").val(\"$data->projecttypeid\");
		  "))',
          ),
        'projecttypeid',
        'projecttypecode',
          'description',
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
                          array('onclick'=>'$("#projecttype_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'projecttypeid'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'addressbookid'); ?>
            <?php echo $form->hiddenField($model,'addressbookid'); ?>
<input type="text" name="sched_name" id="fullname" title="Enter Schedule name" readonly value="<?php
echo (Customer::model()->findByPk($model->addressbookid)!==null)?Customer::model()->findByPk($model->addressbookid)->fullname :'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'customer_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Project Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'customer-grid',
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
          "onClick" => "$(\"#customer_dialog\").dialog(\"close\");
          $(\"#fullname\").val(\"$data->fullname\");
          $(\"#Prowotemplate_addressbookid\").val(\"$data->addressbookid\");
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
                          array('onclick'=>'$("#customer_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'addressbookid'); ?>
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
		<?php echo $form->labelEx($model,'productid'); ?>
            <?php echo $form->hiddenField($model,'productid'); ?>
<input type="text" name="sched_name" id="productname" title="Enter Schedule name" readonly value="<?php
echo (Product::model()->findByPk($model->productid)!==null)?Product::model()->findByPk($model->productid)->productname :'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Province'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$product->Searchwstatus(),
      'filter'=>$product,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\");
          $(\"#productname\").val(\"$data->productname\");
          $(\"#Prowotemplate_productid\").val(\"$data->productid\");
		  "))',
          ),
        'productid',
        'productname',
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
                          array('onclick'=>'$("#product_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'currencyid'); ?>
	</div>
        </td>
      </tr>
      <tr>
         <td>
          <div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'unitofmeasureid'); ?>
            <?php echo $form->hiddenField($model,'unitofmeasureid'); ?>
<input type="text" name="sched_name" id="uomcode" title="Enter Schedule name" readonly value="<?php
echo (Unitofmeasure::model()->findByPk($model->unitofmeasureid)!==null)?Unitofmeasure::model()->findByPk($model->unitofmeasureid)->uomcode :'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'uom_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Province'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'uom-grid',
      'dataProvider'=>$unitofmeasure->Searchwstatus(),
      'filter'=>$unitofmeasure,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#uom_dialog\").dialog(\"close\");
          $(\"#uomcode\").val(\"$data->uomcode\");
          $(\"#Prowotemplate_unitofmeasureid\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
        'unitofmeasureid',
        'uomcode',
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
                          array('onclick'=>'$("#uom_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'unitofmeasureid'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'currencyid'); ?>
            <?php echo $form->hiddenField($model,'currencyid'); ?>
<input type="text" name="sched_name" id="currencyname" title="Enter Schedule name" readonly value="<?php
echo (Currency::model()->findByPk($model->currencyid)!==null)?Currency::model()->findByPk($model->currencyid)->currencyname :'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'currency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Province'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'catering-grid',
      'dataProvider'=>$currency->Searchwstatus(),
      'filter'=>$currency,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\");
          $(\"#currencyname\").val(\"$data->currencyname\");
          $(\"#Prowotemplate_currencyid\").val(\"$data->currencyid\");
		  "))',
          ),
        'currencyid',
        'currencyname',
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
                          array('onclick'=>'$("#currency_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'currencyid'); ?>
	</div>
        </td>
       <tr>
         <td>
          <div class="row">
		<?php echo $form->labelEx($model,'serviceqty'); ?>
		<?php echo $form->textField($model,'serviceqty'); ?>
		<?php echo $form->error($model,'serviceqty'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'serviceuomid'); ?>
            <?php echo $form->hiddenField($model,'serviceuomid'); ?>
<input type="text" name="sched_name" id="serviceuomcode" title="Enter Schedule name" readonly value="<?php
echo (Unitofmeasure::model()->findByPk($model->serviceuomid)!==null)?Unitofmeasure::model()->findByPk($model->serviceuomid)->uomcode :'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'serviceuom_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Province'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'serviceuom-grid',
      'dataProvider'=>$serviceuom->Searchwstatus(),
      'filter'=>$serviceuom,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#serviceuom_dialog\").dialog(\"close\");
          $(\"#serviceuomcode\").val(\"$data->uomcode\");
          $(\"#Prowotemplate_serviceuomid\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
        'unitofmeasureid',
        'uomcode',
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
                          array('onclick'=>'$("#serviceuom_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'serviceuomid'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'serviceprice'); ?>
		<?php echo $form->textField($model,'serviceprice'); ?>
		<?php echo $form->error($model,'serviceprice'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'servicecurrencyid'); ?>
            <?php echo $form->hiddenField($model,'servicecurrencyid'); ?>
<input type="text" name="sched_name" id="servicecurrencyname" title="Enter Schedule name" readonly value="<?php
echo (Currency::model()->findByPk($model->servicecurrencyid)!==null)?Currency::model()->findByPk($model->servicecurrencyid)->currencyname :'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'servicecurrency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Province'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'servicecurrency-grid',
      'dataProvider'=>$servicecurrency->Searchwstatus(),
      'filter'=>$servicecurrency,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#servicecurrency_dialog\").dialog(\"close\");
          $(\"#servicecurrencyname\").val(\"$data->currencyname\");
          $(\"#Prowotemplate_servicecurrencyid\").val(\"$data->currencyid\");
		  "))',
          ),
        'currencyid',
        'currencyname',
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
                          array('onclick'=>'$("#servicecurrency_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'servicecurrencyid'); ?>
	</div>
        </td>
      </tr>
        <tr>
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
		array('prowotemplate/write'),
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
		array('prowotemplate/cancelwrite'),
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

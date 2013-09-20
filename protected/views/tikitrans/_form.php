<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tikitrans-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpmodifdialog',
    'options'=>array(
        'title'=>'Help Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>500,
        'height'=>400,
    ),
));?>
<?php echo $this->renderPartial('_helpmodif'); ?>
<?php $this->endWidget();?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"$('#helpmodifdialog').dialog('open');",
));  ?>

	

	<?php echo $form->errorSummary($model); ?>
<div class="row">
		<?php echo $form->labelEx($model,'airwaybillno'); ?>
		<?php echo $form->textField($model,'airwaybillno',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'airwaybillno'); ?>
	</div>
	<table>
	  <tr>
		<td>
		  Shipper
		</td>
		<td>
		  Receiver
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'shipcompany'); ?>
		<?php echo $form->textField($model,'shipcompany',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'shipcompany'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'rcvcompany'); ?>
		<?php echo $form->textField($model,'rcvcompany',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'rcvcompany'); ?>
	</div>
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'shipaddress'); ?>
		<?php echo $form->textArea($model,'shipaddress',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'shipaddress'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'rcvaddress'); ?>
		<?php echo $form->textArea($model,'rcvaddress',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'rcvaddress'); ?>
	</div>
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'shipcityid'); ?>
			<?php echo $form->hiddenField($model,'shipcityid'); ?>
          <input type="text" name="shipcity_name" id="shipcity_name" readonly value="<?php echo City::model()->findByPk($model->shipcityid)->cityname ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'shipcity_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Organization Structure'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'shipcity-grid',
            'dataProvider'=>$shipcity->Searchwstatus(),
            'filter'=>$shipcity,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_shipcity",
                "id" => "send_shipcity",
                "onClick" => "$(\"#shipcity_dialog\").dialog(\"close\"); $(\"#shipcity_name\").val(\"$data->cityname\"); $(\"#Tikitrans_shipcityid\").val(\"$data->cityid\");"))',
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
                                array('onclick'=>'$("#shipcity_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'shipcityid'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'rcvcityid'); ?>
<?php echo $form->hiddenField($model,'rcvcityid'); ?>
          <input type="text" name="rcvcity_name" id="rcvcity_name" readonly value="<?php echo City::model()->findByPk($model->rcvcityid)->cityname ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'rcvcity_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Organization Structure'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'rcvcity-grid',
            'dataProvider'=>$rcvcity->Searchwstatus(),
            'filter'=>$rcvcity,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_rcvcity",
                "id" => "send_rcvcity",
                "onClick" => "$(\"#rcvcity_dialog\").dialog(\"close\"); $(\"#rcvcity_name\").val(\"$data->cityname\"); $(\"#Tikitrans_rcvcityid\").val(\"$data->cityid\");"))',
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
                                array('onclick'=>'$("#rcvcity_dialog").dialog("open"); return false;',
                             ));?>		<?php echo $form->error($model,'rcvcityid'); ?>
	</div>
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'shipprovinceid'); ?>
<?php echo $form->hiddenField($model,'shipprovinceid'); ?>
          <input type="text" name="shipprovince_name" id="shipprovince_name" readonly value="<?php echo Province::model()->findByPk($model->shipprovinceid)->provincename ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'shipprovince_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Province'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'shipprovince-grid',
            'dataProvider'=>$shipprovince->Searchwstatus(),
            'filter'=>$shipprovince,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_shipprovince",
                "id" => "send_shipprovince",
                "onClick" => "$(\"#shipprovince_dialog\").dialog(\"close\"); $(\"#shipprovince_name\").val(\"$data->provincename\"); $(\"#Tikitrans_shipprovinceid\").val(\"$data->provinceid\");"))',
                ),
              'provinceid',
              'provincename',
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
                                array('onclick'=>'$("#shipprovince_dialog").dialog("open"); return false;',
                             ));?>		
		<?php echo $form->error($model,'shipprovinceid'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'rcvprovinceid'); ?>
<?php echo $form->hiddenField($model,'rcvprovinceid'); ?>
          <input type="text" name="rcvprovince_name" id="rcvprovince_name" readonly value="<?php echo Province::model()->findByPk($model->rcvprovinceid)->provincename ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'rcvprovince_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Province'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'rcvprovince-grid',
            'dataProvider'=>$rcvprovince->Searchwstatus(),
            'filter'=>$rcvprovince,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_rcvprovince",
                "id" => "send_rcvprovince",
                "onClick" => "$(\"#rcvprovince_dialog\").dialog(\"close\"); $(\"#rcvprovince_name\").val(\"$data->provincename\"); $(\"#Tikitrans_rcvprovinceid\").val(\"$data->provinceid\");"))',
                ),
              'provinceid',
              'provincename',
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
                                array('onclick'=>'$("#rcvprovince_dialog").dialog("open"); return false;',
                             ));?>		<?php echo $form->error($model,'rcvprovinceid'); ?>
	</div>
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'shipcountryid'); ?>
<?php echo $form->hiddenField($model,'shipcountryid'); ?>
          <input type="text" name="shipcountry_name" id="shipcountry_name" readonly value="<?php echo Country::model()->findByPk($model->shipcountryid)->countryname ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'shipcountry_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','country'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'shipcountry-grid',
            'dataProvider'=>$shipcountry->Searchwstatus(),
            'filter'=>$shipcountry,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_shipcountry",
                "id" => "send_shipcountry",
                "onClick" => "$(\"#shipcountry_dialog\").dialog(\"close\"); $(\"#shipcountry_name\").val(\"$data->countryname\"); $(\"#Tikitrans_shipcountryid\").val(\"$data->countryid\");"))',
                ),
              'countryid',
              'countryname',
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
                                array('onclick'=>'$("#shipcountry_dialog").dialog("open"); return false;',
                             ));?>		<?php echo $form->error($model,'shipcountryid'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'rcvcountryid'); ?>
			<?php echo $form->hiddenField($model,'rcvcountryid'); ?>
          <input type="text" name="rcvcountry_name" id="rcvcountry_name" readonly value="<?php echo Country::model()->findByPk($model->rcvcountryid)->countryname ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'rcvcountry_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','country'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'rcvcountry-grid',
            'dataProvider'=>$rcvcountry->Searchwstatus(),
            'filter'=>$rcvcountry,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_rcvcountry",
                "id" => "send_rcvcountry",
                "onClick" => "$(\"#rcvcountry_dialog\").dialog(\"close\"); $(\"#rcvcountry_name\").val(\"$data->countryname\"); $(\"#Tikitrans_rcvcountryid\").val(\"$data->countryid\");"))',
                ),
              'countryid',
              'countryname',
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
                                array('onclick'=>'$("#rcvcountry_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'rcvcountryid'); ?>
	</div>
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'shipzipcode'); ?>
		<?php echo $form->textField($model,'shipzipcode',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'shipzipcode'); ?>
	</div>
		</td>
		<td>
<div class="row">
		<?php echo $form->labelEx($model,'rcvzipcode'); ?>
		<?php echo $form->textField($model,'rcvzipcode',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'rcvzipcode'); ?>
	</div>
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'shipname'); ?>
		<?php echo $form->textField($model,'shipname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'shipname'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'rcvattention'); ?>
		<?php echo $form->textField($model,'rcvattention',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'rcvattention'); ?>
	</div>
		</td>
	  </tr>
	  <tr>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'shiptelno'); ?>
		<?php echo $form->textField($model,'shiptelno',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'shiptelno'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'rcvtelno'); ?>
		<?php echo $form->textField($model,'rcvtelno',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'rcvtelno'); ?>
	</div>
		</td>
	  </tr>
	</table>	

	<div class="row">
		<?php echo $form->labelEx($model,'descofship'); ?>
		<?php echo $form->textArea($model,'descofship',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'descofship'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deliveryinst'); ?>
		<?php echo $form->textArea($model,'deliveryinst',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'deliveryinst'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paymentmethodid'); ?>
<?php echo $form->hiddenField($model,'paymentmethodid'); ?>
          <input type="text" name="paymentmethod_name" id="paymentmethod_name" readonly value="<?php echo Paymentmethod::model()->findByPk($model->paymentmethodid)->paymentname ?>">
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
                array("name" => "send_paymentmethod",
                "id" => "send_paymentmethod",
                "onClick" => "$(\"#paymentmethod_dialog\").dialog(\"close\"); $(\"#paymentmethod_name\").val(\"$data->paymentname\"); $(\"#Tikitrans_paymentmethodid\").val(\"$data->paymentmethodid\");"))',
                ),
              'paymentmethodid',
			  'paycode',
              'paymentname',
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
                                array('onclick'=>'$("#paymentmethod_dialog").dialog("open"); return false;',
                             ));?>		<?php echo $form->error($model,'paymentmethodid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'charges'); ?>
		<?php echo $form->textField($model,'charges',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'charges'); ?>
	</div>	

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('',
		array('tikitrans/write'),
	  array('update'=>'#messagediv')); ?>
	</div>
<?php $this->endWidget(); ?>
	<div id="messagediv"></div>
</div><!-- form -->

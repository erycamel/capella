<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'journaldetail-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'journaldetailid'); ?>
<?php echo $form->hiddenField($model,'genjournalid'); ?>
	

    <div class="row">
		<?php echo $form->labelEx($model,'accountid'); ?>
<?php echo $form->hiddenField($model,'accountid'); ?>
	  <input type="text" name="account_name" id="account_name" readonly >    
<?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'account_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Account'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$account=new Account('searchwstatus');
	  $account->unsetAttributes();  // clear any default values
	  if(isset($_GET['Account']))
		$account->attributes=$_GET['Account'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'account-grid',
      'dataProvider'=>$account->Searchwstatus(),
      'filter'=>$account,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#account_dialog\").dialog(\"close\"); $(\"#account_name\").val(\"$data->accountname\"); $(\"#Journaldetail_accountid\").val(\"$data->accountid\");
		  "))',
          ),
		  	array('name'=>'accountid', 'visible'=>false,'value'=>'$data->accountid','htmlOptions'=>array('width'=>'1%')),
        'accountcode',
        'accountname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#account_dialog").dialog("open"); return false;',
                       ))?>		
		<?php echo $form->error($model,'accountid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'debit'); ?>
		<?php echo $form->textField($model,'debit'); ?>
		<?php echo $form->error($model,'debit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'credit'); ?>
		<?php echo $form->textField($model,'credit'); ?>
		<?php echo $form->error($model,'credit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currencyid'); ?>
<?php echo $form->hiddenField($model,'currencyid'); ?>
	  <input type="text" name="account_name" id="currencyname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'currency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Currency'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$currency=new Currency('searchwstatus');
	  $currency->unsetAttributes();  // clear any default values
	  if(isset($_GET['Currency']))
		$currency->attributes=$_GET['Currency'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'currency-grid',
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
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); $(\"#Journaldetail_currencyid\").val(\"$data->currencyid\");
		  "))',
          ),
		  	array('name'=>'currencyid', 'visible'=>false,'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
        'currencyname',
        'symbol',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#currency_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'currencyid'); ?>
	</div>

    	<div class="row">
		<?php echo $form->labelEx($model,'ratevalue'); ?>
		<?php echo $form->textField($model,'ratevalue'); ?>
		<?php echo $form->error($model,'ratevalue'); ?>
	</div>

    	<div class="row">
		<?php echo $form->labelEx($model,'detailnote'); ?>
		<?php echo $form->textArea($model,'detailnote',array('cols'=>20,'rows'=>5)); ?>
		<?php echo $form->error($model,'detailnote'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('genjournal/writedetail'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("detaildatagrid");
			  $("#createdialog1").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
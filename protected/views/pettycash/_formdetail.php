<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pettycashdetail-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'pettycashdetailid'); ?>
<?php echo $form->hiddenField($model,'pettycashid'); ?>
	

    <div class="row">
		<?php echo $form->labelEx($model,'accountid'); ?>
<?php echo $form->hiddenField($model,'accountid'); ?>
	  <input type="text" name="account_name" id="account_name" title="Account name" readonly value="<?php 
echo (Account::model()->findByPk($model->accountid)!==null)?Account::model()->findByPk($model->accountid)->accountname:''; ?>">    
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
          "onClick" => "$(\"#account_dialog\").dialog(\"close\"); $(\"#account_name\").val(\"$data->accountname\"); $(\"#Pettycashdetail_accountid\").val(\"$data->accountid\");
		  "))',
          ),
        'accountid',
        'accountcode',
        'accountname',
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
	  <input type="text" name="account_name" id="currencyname" title="Account name" readonly value="<?php 
echo (Currency::model()->findByPk($model->currencyid)!==null)?Currency::model()->findByPk($model->currencyid)->currencyname:''; ?>">
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
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\"); $(\"#currencyname\").val(\"$data->currencyname\"); $(\"#Pettycashdetail_currencyid\").val(\"$data->currencyid\");
		  "))',
          ),
        'currencyid',
        'currencyname',
        'symbol',
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
                       ))?>
		<?php echo $form->error($model,'currencyid'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'projectid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	  <input type="text" name="account_name" id="projectno" title="Account name" readonly value="<?php
echo (Project::model()->findByPk($model->projectid)!==null)?Project::model()->findByPk($model->projectid)->projectno:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'project_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Project'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$project=new Project('search');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'project-grid',
      'dataProvider'=>$project->search(),
      'filter'=>$project,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#project_dialog\").dialog(\"close\"); $(\"#projectno\").val(\"$data->projectno\"); $(\"#Pettycashdetail_projectid\").val(\"$data->projectid\");
		  "))',
          ),
        'projectid',
        'projectno',
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
                          array('onclick'=>'$("#project_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'projectid'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'itemnote'); ?>
		<?php echo $form->textArea($model,'itemnote'); ?>
		<?php echo $form->error($model,'itemnote'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('pettycash/writedetail'),
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
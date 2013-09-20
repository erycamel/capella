<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prodoctemplate-form',
	'enableAjaxValidation'=>false,
)); ?>
      <?php
    $imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));?>
<?php echo $form->hiddenField($model,'prodoctemplateid'); ?>
	
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
          $(\"#Prodoctemplate_projecttypeid\").val(\"$data->projecttypeid\");
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
		<?php echo $form->labelEx($model,'documentname'); ?>
		<?php echo $form->textField($model,'documentname'); ?>
		<?php echo $form->error($model,'documentname'); ?>
	</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'documenttypeid'); ?>
            <?php echo $form->hiddenField($model,'documenttypeid'); ?>
<input type="text" name="sched_name" id="documenttypename" title="Enter Schedule name" readonly value="<?php
echo (Documenttype::model()->findByPk($model->documenttypeid)!==null)?Documenttype::model()->findByPk($model->documenttypeid)->documenttypename :'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'documenttype_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Project Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'documenttype-grid',
      'dataProvider'=>$documenttype->Searchwstatus(),
      'filter'=>$documenttype,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#documenttype_dialog\").dialog(\"close\");
          $(\"#documenttypename\").val(\"$data->documenttypename\");
          $(\"#Prodoctemplate_documenttypeid\").val(\"$data->documenttypeid\");
		  "))',
          ),
        'documenttypeid',
        'documenttypename',
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
                          array('onclick'=>'$("#documenttype_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'documenttypeid'); ?>
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
		array('prodoctemplate/write'),
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
		array('prodoctemplate/cancelwrite'),
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

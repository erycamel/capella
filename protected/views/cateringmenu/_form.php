<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cateringmenu-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpmodifdata()}",
));  ?>

<?php echo $form->hiddenField($model,'cateringmenuid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'addressbookid'); ?>
		<?php echo $form->hiddenField($model,'addressbookid'); ?>
	  <input type="text" name="sched_name" id="cateringname" title="Enter Schedule name" readonly value="<?php echo Catering::model()->findByPk($model->addressbookid)->fullname ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'catering_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Catering'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'catering-grid',
      'dataProvider'=>$catering->Searchwstatus(),
      'filter'=>$catering,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#catering_dialog\").dialog(\"close\"); $(\"#cateringname\").val(\"$data->fullname\"); $(\"#Cateringmenu_addressbookid\").val(\"$data->addressbookid\");
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
                          array('onclick'=>'$("#catering_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'addressbookid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datefrom'); ?>
		<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'datefrom',
              'model'=>$model,
			  'mode'=>'datetime',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeMonth'=>true,
				  'changeYear'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
		<?php echo $form->error($model,'datefrom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dateto'); ?>
		<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'dateto',
              'model'=>$model,
			  'mode'=>'datetime',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeMonth'=>true,
				  'changeYear'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
		<?php echo $form->error($model,'dateto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'istestfood'); ?>
		<?php echo $form->checkBox($model,'istestfood'); ?>
		<?php echo $form->error($model,'istestfood'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'catmenutypeid'); ?>
		<?php echo $form->hiddenField($model,'catmenutypeid'); ?>
	  <input type="text" name="sched_name" id="description" title="Enter Schedule name" readonly value="<?php echo Catmenutype::model()->findByPk($model->catmenutypeid)->description ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'cateringmenu_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Catering Menu Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'cateringmenu-grid',
      'dataProvider'=>$catmenutype->Searchwstatus(),
      'filter'=>$catmenutype,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_cateringmenu",
          "id" => "send_cateringmenu",
          "onClick" => "$(\"#cateringmenu_dialog\").dialog(\"close\"); $(\"#description\").val(\"$data->description\"); $(\"#Cateringmenu_catmenutypeid\").val(\"$data->catmenutypeid\");
		  "))',
          ),
        'catmenutypeid',
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
                          array('onclick'=>'$("#cateringmenu_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'catmenutypeid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'foodmenu'); ?>
		<?php echo $form->textArea($model,'foodmenu',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'foodmenu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('cateringmenu/write'),
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
		array('cateringmenu/cancelwrite'),
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

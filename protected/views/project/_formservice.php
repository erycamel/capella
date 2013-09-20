<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projectdoc-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'projectserviceid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	

        <div class="row">
            <?php echo $form->labelEx($model,'requestforid'); ?>
    <?php echo $form->hiddenField($model,'requestforid'); ?>
    <input type="text" name="requestforname" id="requestforname" readonly value="<?php
echo (Requestfor::model()->findByPk($model->requestforid)!==null)?Requestfor::model()->findByPk($model->requestforid)->requestforname :'';?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'requestfor_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Request For'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$requestfor=new Requestfor('searchwstatus');
	  $requestfor->unsetAttributes();  // clear any default values
	  if(isset($_GET['Requestfor']))
		$requestfor->attributes=$_GET['Requestfor'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'requestfor-grid',
        'dataProvider'=>$requestfor->searchwstatus(),
        'filter'=>$requestfor,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#requestfor_dialog\").dialog(\"close\"); $(\"#requestforname\").val(\"$data->requestforname\");
          $(\"#Projectservice_requestforid\").val(\"$data->requestforid\");"))',
          ),
          array('name'=>'requestforid', 'visible'=>false, 'value'=>'$data->requestforid'),
          'requestforname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#requestfor_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'requestforid'); ?>
    </div>

    <div class="row">
		<?php echo $form->labelEx($model,'dateofdelivery'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'dateofdelivery',
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
                  'size'=>'15',
              ),
          ));?>
		<?php echo $form->error($model,'dateofdelivery'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'dateofdeliverydevice'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'dateofdeliverydevice',
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
                  'size'=>'15',
              ),
          ));?>
		<?php echo $form->error($model,'dateofdeliverydevice'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'estimatedelivery'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'estimatedelivery',
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
                  'size'=>'15',
              ),
          ));?>
		<?php echo $form->error($model,'estimatedelivery'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'installdate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'installdate',
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
		<?php echo $form->error($model,'installdate'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'onlinedate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'onlinedate',
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
		<?php echo $form->error($model,'onlinedate'); ?>
	</div>
	
	<div class="row">
            <?php echo $form->labelEx($model,'contracttermid'); ?>
    <?php echo $form->hiddenField($model,'contracttermid'); ?>
    <input type="text" name="contracttermname" id="contracttermname" readonly value="<?php
echo (Contractterm::model()->findByPk($model->contracttermid)!==null)?Contractterm::model()->findByPk($model->contracttermid)->contracttermname :'';?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'contractterm_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Contract Term'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$contractterm=new Contractterm('searchwstatus');
	  $contractterm->unsetAttributes();  // clear any default values
	  if(isset($_GET['Contractterm']))
		$contractterm->attributes=$_GET['Contractterm'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'contractterm-grid',
        'dataProvider'=>$contractterm->searchwstatus(),
        'filter'=>$contractterm,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#contractterm_dialog\").dialog(\"close\"); $(\"#contracttermname\").val(\"$data->contracttermname\");
          $(\"#Projectservice_contracttermid\").val(\"$data->contracttermid\");"))',
          ),
          array('name'=>'contracttermid', 'visible'=>false, 'value'=>'$data->contracttermid'),
          'contracttermname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#contractterm_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'contracttermid'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writeservice'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("servicedatagrid");
			  $("#createdialog2").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
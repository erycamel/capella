<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employeebenefitdetail-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'employeebenefitdetailid'); ?>
<?php echo $form->hiddenField($model,'employeebenefitid'); ?>
	

    <div class="row">
		<?php echo $form->labelEx($model,'wagetypeid'); ?>
<?php echo $form->hiddenField($model,'wagetypeid'); ?>
	  <input type="text" name="wagename" id="wagename" title="Account name" readonly value="<?php
echo (Wagetype::model()->findByPk($model->wagetypeid)!==null)?Wagetype::model()->findByPk($model->wagetypeid)->wagename:''; ?>">
<?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'wage_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Wage Type'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$wagetype=new Wagetype('searchwstatus');
	  $wagetype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Wagetype']))
		$wagetype->attributes=$_GET['Wagetype'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'wagetype-grid',
      'dataProvider'=>$wagetype->Searchwstatus(),
      'filter'=>$wagetype,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#wage_dialog\").dialog(\"close\");
          $(\"#wagename\").val(\"$data->wagename\");
          $(\"#Employeebenefitdetail_wagetypeid\").val(\"$data->wagetypeid\");
          generatedata();
		  "))',
          ),
	array('name'=>'wagetypeid', 'visible'=>false,'value'=>'$data->wagetypeid','htmlOptions'=>array('width'=>'1%')),
        'wagename',
          array(
          'class'=>'CCheckBoxColumn',
          'name'=>'ispph',
          'selectableRows'=>'0',
          'header'=>'Is Tax',
          'checked'=>'$data->ispph'
        ),
        array(
          'class'=>'CCheckBoxColumn',
          'name'=>'ispayroll',
          'selectableRows'=>'0',
          'header'=>'Is Payroll',
          'checked'=>'$data->ispayroll'
        ),
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#wage_dialog").dialog("open"); return false;',
                       ))?>		
		<?php echo $form->error($model,'accountid'); ?>
	</div>

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
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
		<?php echo $form->error($model,'startdate'); ?>
	</div>

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
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
		<?php echo $form->error($model,'enddate'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	

    <div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason'); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>

     <div class="row">
		<?php echo $form->labelEx($model,'isfinal'); ?>
		<?php echo $form->checkBox($model,'isfinal'); ?>
		<?php echo $form->error($model,'isfinal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('employeebenefit/writedetail'),
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
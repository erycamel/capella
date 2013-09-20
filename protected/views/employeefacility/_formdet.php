<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employeefacilitydet-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'employeefacilitydetid'); ?>
<?php echo $form->hiddenField($model,'employeefacilityid'); ?>
	

    <div class="row">
		<?php echo $form->labelEx($model,'facilitytypeid'); ?>
<?php echo $form->hiddenField($model,'facilitytypeid'); ?>
          <input type="text" name="facilitytype_name" id="facilitytypename" readonly value="
<?php echo (Facilitytype::model()->findByPk($model->facilitytypeid)!==null)?Facilitytype::model()->findByPk($model->facilitytypeid)->facilitytypename:'';?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'facilitytype_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Facility Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$facilitytype = new Facilitytype('searchwstatus');
	  $facilitytype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Facilitytype']))
		$facilitytype->attributes=$_GET['Facilitytype'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'facilitytype-grid',
            'dataProvider'=>$facilitytype->Searchwstatus(),
            'filter'=>$facilitytype,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_facilitytype",
                "id" => "send_facilitytype",
                "onClick" => "$(\"#facilitytype_dialog\").dialog(\"close\");
                $(\"#facilitytypename\").val(\"$data->facilitytypename\");
                $(\"#Employeefacilitydet_facilitytypeid\").val(\"$data->facilitytypeid\");"))',
                ),
              	array('name'=>'facilitytypeid', 'visible'=>false,'value'=>'$data->facilitytypeid','htmlOptions'=>array('width'=>'1%')),
              'facilitytypename',
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
                                array('onclick'=>'$("#facilitytype_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'facilitytypeid'); ?>
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
                                  'yearRange'=>'1900:+30'
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
                                  'yearRange'=>'1900:+30'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
		<?php echo $form->error($model,'enddate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('employeefacility/writeemployeefacilitydet'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("employeefacilitydetdatagrid");
			  $("#createdialog1").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->

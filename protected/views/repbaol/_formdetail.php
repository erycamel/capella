<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'baoldoc-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'baoldetailid'); ?>
<?php echo $form->hiddenField($model,'baolid'); ?>
	

        <div class="row">
            <?php echo $form->labelEx($model,'projectid'); ?>
    <?php echo $form->hiddenField($model,'projectid'); ?>
    <input type="text" name="projectname" id="projectname" readonly value="<?php
echo (Requestfor::model()->findByPk($model->projectid)!==null)?Requestfor::model()->findByPk($model->projectid)->projectname :'';?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'project_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Project'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$project=new Project('searchwstatus');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'project-grid',
        'dataProvider'=>$project->searchwfgstatus(),
        'filter'=>$project,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#project_dialog\").dialog(\"close\"); $(\"#projectname\").val(\"$data->projectname\");
          $(\"#baoldetail_projectid\").val(\"$data->projectid\");"))',
          ),
          array('name'=>'projectid', 'visible'=>false, 'value'=>'$data->projectid'),
          'projectname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#project_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'projectid'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('baol/writedetail'),
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
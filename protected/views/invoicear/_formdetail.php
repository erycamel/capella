<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoiceproject-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'invoiceprojectid'); ?>
<?php echo $form->hiddenField($model,'invoicearid'); ?>
	

    <table>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'projectid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
        <input type="text" name="projectno" id="projectno" title="Account name" style="width: 200px" readonly 
		value="<?php echo (Project::model()->findByPk($model->projectid)!==null)?Project::model()->findByPk($model->projectid)->projectno:''; ?>">
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
$project=new Project('searchwfstatus');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'project-grid',
      'dataProvider'=>$project->Searchwfstatus(),
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
          "onClick" => "$(\"#project_dialog\").dialog(\"close\"); $(\"#projectno\").val(\"$data->projectno\"); 
		  $(\"#Invoiceproject_projectid\").val(\"$data->projectid\");
		  "))',
          ),
		  	array('name'=>'projectid', 'visible'=>false,'value'=>'$data->projectid','htmlOptions'=>array('width'=>'1%')),
        'projectno',
		'projectname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#project_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'productid'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>
        </td>
      </tr>
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
		<?php echo $form->labelEx($model,'serviceprice'); ?>
		<?php echo $form->textField($model,'serviceprice'); ?>
		<?php echo $form->error($model,'serviceprice'); ?>
	</div>
        </td>
      </tr>
    </table>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('invoicear/writedetail'),
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
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subdistrict-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
<?php echo $form->hiddenField($model,'subdistrictid'); ?>
	
<div class="row">
		<?php echo $form->labelEx($model,'cityid'); ?>
<?php echo $form->hiddenField($model,'cityid'); ?>
	  <input type="text" name="sched_name" id="cityname" title="Enter Schedule name" readonly value="<?php echo (City::model()->findByPk($model->cityid)!==null)?City::model()->findByPk($model->cityid)->cityname:'';
?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'country_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','City'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$city=new City('searchwstatus');
	  $city->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$city->attributes=$_GET['City'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$city->Searchwstatus(),
      'filter'=>$city,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#country_dialog\").dialog(\"close\"); $(\"#cityname\").val(\"$data->cityname\"); $(\"#Subdistrict_cityid\").val(\"$data->cityid\");
		  "))',
          ),
	array('name'=>'cityid', 'visible'=>false,'value'=>'$data->cityid','htmlOptions'=>array('width'=>'1%')),
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
                          array('onclick'=>'$("#country_dialog").dialog("open"); return false;',
                       ))?>		<?php echo $form->error($model,'cityid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subdistrictname'); ?>
		<?php echo $form->textField($model,'subdistrictname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'subdistrictname'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'zipcode'); ?>
		<?php echo $form->textField($model,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'zipcode'); ?>
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
		array('subdistrict/write'),
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
		array('subdistrict/cancelwrite'),
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
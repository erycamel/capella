<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'kelurahan-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'sptwilid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'kelurahanid'); ?>
<?php echo $form->hiddenField($model,'kelurahanid'); ?>
          <input type="text" name="kelurahanname" id="kelurahanname" readonly value="<?php
echo (Kelurahan::model()->findByPk($model->kelurahanid)!==null)?Kelurahan::model()->findByPk($model->kelurahanid)->kelurahanname:'';?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'kelurahan_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Address Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$kelurahan = new Kelurahan('searchwstatus');
	  $kelurahan->unsetAttributes();  // clear any default values
	  if(isset($_GET['Kelurahan']))
		$kelurahan->attributes=$_GET['Kelurahan'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'kelurahan-grid',
            'dataProvider'=>$kelurahan->Searchwstatus(),
            'filter'=>$kelurahan,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_addresstype",
                "id" => "send_addresstype",
                "onClick" => "$(\"#kelurahan_dialog\").dialog(\"close\"); $(\"#kelurahanname\").val(\"$data->kelurahanname\"); $(\"#Sptwil_kelurahanid\").val(\"$data->kelurahanid\");"))',
                ),
              'kelurahanid',
                'kelurahanname',
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
                                array('onclick'=>'$("#kelurahan_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'kelurahanid'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'kdwil'); ?>
		<?php echo $form->textField($model,'kdwil'); ?>
		<?php echo $form->error($model,'kdwil'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'kpp'); ?>
		<?php echo $form->textField($model,'kpp'); ?>
		<?php echo $form->error($model,'kpp'); ?>
	</div>


	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('sptwil/write'),
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
		array('sptwil/cancelwrite'),
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

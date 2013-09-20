<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'baol-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)};",
));  ?>
	
<?php echo $form->hiddenField($model,'baolid'); ?>
      <table>
        <tr>
          <td>
    <div class="row">
            <?php echo $form->labelEx($model,'soheaderid'); ?>
    <?php echo $form->hiddenField($model,'soheaderid'); ?>
    <input type="text" name="contractno" id="contractno" readonly value="<?php
echo (Soheader::model()->findByPk($model->soheaderid)!==null)?Soheader::model()->findByPk($model->soheaderid)->contractno :'';?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'soheader_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Sales Order'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$soheader=new Soheader('searchwfstatus');
	  $soheader->unsetAttributes();  // clear any default values
	  if(isset($_GET['Soheader']))
		$soheader->attributes=$_GET['Soheader'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'absstatus-grid',
        'dataProvider'=>$soheader->searchwfstatus(),
        'filter'=>$soheader,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#soheader_dialog\").dialog(\"close\"); $(\"#contractno\").val(\"$data->contractno\");
          $(\"#Baol_soheaderid\").val(\"$data->soheaderid\");
          generatedata();"))',
          ),
          array('name'=>'soheaderid', 'visible'=>false, 'value'=>'$data->soheaderid'),
          'sono',
          array('name'=>'addressbookid', 'value'=>'($data->customer!==null)?$data->customer->fullname:""'),
		  'contractno',
          array('name'=>'servicetypeid', 'value'=>'($data->servicetype!==null)?$data->servicetype->servicetypename:""'),
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#soheader_dialog").dialog("open"); return false;',
                       ))?>
    <?php echo $form->error($model,'absstatusid'); ?>
    </div>
          </td>
          <td>
<div class="row">
		<?php echo $form->labelEx($model,'baoldate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'baoldate',
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
		<?php echo $form->error($model,'baoldate'); ?>
	</div>
          </td>
		  </tr>
		  <tr>
		  <td>
<div class="row">
		<?php echo $form->labelEx($model,'pic'); ?>
		<?php echo $form->textField($model,'pic'); ?>
		<?php echo $form->error($model,'pic'); ?>
	</div>
          </td>
		  <td>
<div class="row">
		<?php echo $form->labelEx($model,'jabatan'); ?>
		<?php echo $form->textField($model,'jabatan'); ?>
		<?php echo $form->error($model,'jabatan'); ?>
	</div>
		</td>
        </tr>
		<tr>		
		<td>
<div class="row">
		<?php echo $form->labelEx($model,'piccust'); ?>
		<?php echo $form->textField($model,'piccust'); ?>
		<?php echo $form->error($model,'piccust'); ?>
	</div>
		</td>
		<td>
<div class="row">
		<?php echo $form->labelEx($model,'jabatancust'); ?>
		<?php echo $form->textField($model,'jabatancust'); ?>
		<?php echo $form->error($model,'jabatancust'); ?>
	</div>
		</td>
		</tr>
      </table>
		<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('baol/write'),
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
		array('baol/cancelwrite'),
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
	<?php
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs' => array(
         'Detail' => array('content' => $this->renderPartial('indexdetail',
			 array('baoldetail'=>$baoldetail),true)),
 	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->

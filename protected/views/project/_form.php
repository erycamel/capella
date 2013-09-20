<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)};",
));  ?>
	
<?php echo $form->hiddenField($model,'projectid'); ?>
      <table>
        <tr>
          <td>
    <div class="row">
            <?php echo $form->labelEx($model,'soheaderid'); ?>
    <?php echo $form->hiddenField($model,'soheaderid'); ?>
    <input type="text" name="stat_name" id="sono" readonly value="<?php
echo (Soheader::model()->findByPk($model->soheaderid)!==null)?Soheader::model()->findByPk($model->soheaderid)->sono :'';?>">
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
          "onClick" => "$(\"#soheader_dialog\").dialog(\"close\"); $(\"#sono\").val(\"$data->sono\");
          $(\"#Project_soheaderid\").val(\"$data->soheaderid\");
          generatedata();"))',
          ),
          array('name'=>'soheaderid', 'visible'=>false, 'value'=>'$data->soheaderid'),
          'sono',
          array('name'=>'addressbookid', 'value'=>'($data->customer!==null)?$data->customer->fullname:""'),
		  'projectname',
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
		<?php echo $form->labelEx($model,'projectdate'); ?>
          <?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'projectdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+10',
				  'timeFormat'=>Yii::app()->params['timeviewcjui'],
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'40',
              ),
          ));?>
		<?php echo $form->error($model,'jamsostekdate'); ?>
	</div>
		  </td>
		  </tr>
          <td>
<div class="row">
		<?php echo $form->labelEx($model,'projectnote'); ?>
		<?php echo $form->textArea($model,'projectnote'); ?>
		<?php echo $form->error($model,'projectnote'); ?>
	</div>
          </td>
		  <td>
<div class="row">
		<?php echo $form->labelEx($model,'serviceno'); ?>
		<?php echo $form->textField($model,'serviceno'); ?>
		<?php echo $form->error($model,'serviceno'); ?>
	</div>
          </td>
        </tr>
		<tr>
		<td>
<div class="row">
		<?php echo $form->labelEx($model,'priceotr'); ?>
		<?php echo $form->textField($model,'priceotr'); ?>
		<?php echo $form->error($model,'priceotr'); ?>
	</div>
		</td>
		<td>
<div class="row">
		<?php echo $form->labelEx($model,'priceotc'); ?>
		<?php echo $form->textField($model,'priceotc'); ?>
		<?php echo $form->error($model,'priceotc'); ?>
	</div>
		</td>
		</tr>
      </table>
		<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/write'),
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
		<?php echo CHtml::ajaxSubmitButton('Delete',
		array('project/cancelwrite'),
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
         'Service Detail' => array('content' => $this->renderPartial('indexservice',
			 array('projectservice'=>$projectservice),true)),
         'Person In Charge' => array('content' => $this->renderPartial('indexpic',
			 array('projectpic'=>$projectpic),true)),
         'Location Detail' => array('content' => $this->renderPartial('indexlocation',
			 array('projectlocation'=>$projectlocation),true)),
         'Document BAOL' => array('content' => $this->renderPartial('indexdocument',
			 array('projectdocument'=>$projectdocument),true)),
         'Network Spec' => array('content' => $this->renderPartial('indexnetwork',
			 array('projectnetwork'=>$projectnetwork),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->

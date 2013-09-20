<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usergroup-form',
	'enableAjaxValidation'=>true,
)); ?>
<?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
<?php echo $form->hiddenField($model,'troubleticketid'); ?>
	
	<?php echo $form->errorSummary($model); ?>	
<table>
<tr>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'serviceno'); ?>
		<?php echo $form->textField($model,'serviceno'); ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'project_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Service No'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
$project=new Project('searchsdstatus');
	  $project->unsetAttributes();  // clear any default values
	  if(isset($_GET['Project']))
		$project->attributes=$_GET['Project'];      
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'project-grid',
        'dataProvider'=>$project->searchttstatus(),
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
          "onClick" => "$(\"#project_dialog\").dialog(\"close\");
		  $(\"#Troubleticket_serviceno\").val(\"$data->serviceno\");"))',
          ),
			'serviceno',
			array(
             'name'=>'dest_address',
			 'header'=>'Destination Address',
             'value'=>'(count($data->projectlocation)>0)?$data->projectlocation[0]->destaddress:""'
			 //($data->projectlocation!==null)?(count($data->projectlocation)>0)?$data->projectlocation[0]->destaddress:"":""'
         ),
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#project_dialog").dialog("open"); return false;',
                       ))?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'customername'); ?>
		<?php echo $form->textField($model,'customername',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'customername'); ?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'unitkerja'); ?>
		<?php echo $form->textField($model,'unitkerja',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'unitkerja'); ?>
	</div>
</td>
</tr>
<tr>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'phoneno'); ?>
		<?php echo $form->textField($model,'phoneno',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'phoneno'); ?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'mobilephoneno'); ?>
		<?php echo $form->textField($model,'mobilephoneno',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'mobilephoneno'); ?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'customeraddress'); ?>
		<?php echo $form->textField($model,'customeraddress',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'customeraddress'); ?>
	</div>
</td>
</tr>
<tr>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>5,'cols'=>20)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
</td>
<td>
<div class="row">
		<?php echo $form->labelEx($model,'useraccessid'); ?>
		<?php echo $form->hiddenField($model,'useraccessid'); ?>
<input type="text" name="realname" id="realname" readonly 
value="<?php echo (Useraccess::model()->findByPk($model->useraccessid)!==null)?Useraccess::model()->findByPk($model->useraccessid)->realname:''; ?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'useraccess_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','User'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
$useraccess=new Useraccess('searchsdstatus');
	  $useraccess->unsetAttributes();  // clear any default values
	  if(isset($_GET['Useraccess']))
		$useraccess->attributes=$_GET['Useraccess'];      
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'useraccess-grid',
        'dataProvider'=>$useraccess->searchwstatus(),
        'filter'=>$useraccess,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#useraccess_dialog\").dialog(\"close\");
		  $(\"#realname\").val(\"$data->realname\");
		  $(\"#Troubleticket_useraccessid\").val(\"$data->useraccessid\");"))',
          ),
			array(
             'name'=>'useraccessid',
			 'visible'=>false,
             'value'=>'$data->useraccessid'
         ),
			'username',
			'realname'
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#useraccess_dialog").dialog("open"); return false;',
                       ))?>
	</div>
</td>
</tr>
<tr>
<td>
		<?php echo $form->labelEx($model,'startdate'); ?>
<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'startdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0',
				  'timeFormat'=>Yii::app()->params['timeviewcjui'],
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
</td>

<td>
		<?php echo $form->labelEx($model,'enddate'); ?>
<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
              'attribute'=>'enddate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0',
				  'timeFormat'=>Yii::app()->params['timeviewcjui'],
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
</td>



<td>
<div class="row">
		<?php echo $form->labelEx($model,'troubleticketstatusid'); ?>
		<?php echo $form->hiddenField($model,'troubleticketstatusid'); ?>
<input type="text" name="troublecode" id="troublecode" readonly value="<?php echo (Troubleticketstatus::model()->findByPk($model->troubleticketstatusid)!==null)?Troubleticketstatus::model()->findByPk($model->troubleticketstatusid)->troublecode:''; ?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'ttstatus_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Trouble Ticket Status'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
$ttstatus=new Troubleticketstatus('searchsdstatus');
	  $ttstatus->unsetAttributes();  // clear any default values
	  if(isset($_GET['Troubleticketstatus']))
		$ttstatus->attributes=$_GET['Troubleticketstatus'];      
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'ttstatus-grid',
        'dataProvider'=>$ttstatus->search(),
        'filter'=>$ttstatus,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#ttstatus_dialog\").dialog(\"close\");
		  $(\"#troublecode\").val(\"$data->troublecode\");
		  $(\"#Troubleticket_troubleticketstatusid\").val(\"$data->troubleticketstatusid\");"))',
          ),
			array(
             'name'=>'troubleticketstatusid',
			 'visible'=>false,
             'value'=>'$data->troubleticketstatusid'
         ),
'troublecode',
'description'
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#ttstatus_dialog").dialog("open"); return false;',
                       ))?>
	</div>
</td>
</tr>
</table>
	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('troubleticket/write'),
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
		array('troubleticket/cancelwrite'),
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
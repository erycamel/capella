<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'doheader-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
	
<?php echo $form->hiddenField($model,'doheaderid'); ?>
	<table>
	 	  <tr>
             <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'soheaderid'); ?>
    <?php echo $form->hiddenField($model,'soheaderid'); ?>
    <input type="text" name="stat_name" id="sono" readonly value="<?php echo (Soheader::model()->findByPk($model->soheaderid)!==null)?Soheader::model()->findByPk($model->soheaderid)->sono:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'poc_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Sales Order'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'poc-grid',
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
          "onClick" => "$(\"#poc_dialog\").dialog(\"close\"); $(\"#sono\").val(\"$data->sono\"); $(\"#Doheader_soheaderid\").val(\"$data->soheaderid\");
                $(\"#Doheader_addressbookid\").val(\"$data->addressbookid\");
                generatedata1();
                "))',
          ),
          'soheaderid',
          'sono',
            'addressbookid',
		  array('name'=>'addressbookid', 'value'=>'($data->customer!==null)?$data->customer->fullname:""'),
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
                          array('onclick'=>'$("#poc_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'soheaderid'); ?>
	</div>
		</td>

		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'addressbookid'); ?>
    <?php echo $form->hiddenField($model,'addressbookid'); ?>
    <input type="text" name="stat_name" id="fullname" readonly value="<?php echo (Customer::model()->findByPk($model->addressbookid)!==null)?Customer::model()->findByPk($model->addressbookid)->fullname:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'addressbook_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Customer'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'customer-grid',
        'dataProvider'=>$customer->searchwstatus(),
        'filter'=>$customer,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#addressbook_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->fullname\"); $(\"#Doheader_addressbookid\").val(\"$data->addressbookid\");"))',
          ),
          'addressbookid',
          'fullname',
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
                          array('onclick'=>'$("#addressbook_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'addressbookid'); ?>
	</div>
		</td>
		<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>
		</td>
	  </tr>
      <tr>
        <td>
        <div class="row">
		<?php echo $form->labelEx($model,'projectid'); ?>
    <?php echo $form->hiddenField($model,'projectid'); ?>
    <input type="text" name="stat_name" id="sono" readonly value="<?php echo (Project::model()->findByPk($model->projectid)!==null)?Project::model()->findByPk($model->projectid)->projectno:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'project_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Sales Order'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'project-grid',
        'dataProvider'=>$project->search(),
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
          "onClick" => "$(\"#project_dialog\").dialog(\"close\"); $(\"#projectno\").val(\"$data->projectno\"); $(\"#Doheader_projectid\").val(\"$data->projectid\");
                $(\"#Doheader_addressbookid\").val(\"$data->addressbookid\");
                
                "))',
          ),
          'projectid',
          'projectno',
		  array('name'=>'addressbookid', 'value'=>'($data->customer!==null)?$data->customer->fullname:""'),
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
                          array('onclick'=>'$("#project_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'soheaderid'); ?>
	</div>
        </td>
      </tr>
	</table>
		<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('doheader/write'),
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
		array('doheader/cancelwrite'),
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
			array('dodetail'=>$dodetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->
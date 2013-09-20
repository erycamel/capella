<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productbasic-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'productbasicid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

    <table>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'productid'); ?>
<?php echo $form->hiddenField($model,'productid'); ?>
	  <input type="text" name="sched_name" id="productname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Master'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$product->searchwstatus(),
      'filter'=>$product,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Productbasic_productid\").val(\"$data->productid\");
		  "))',
          ),
	array('name'=>'productid', 'visible'=>false,'value'=>'$data->productid','htmlOptions'=>array('width'=>'1%')),
        'productname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#product_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'productid'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'baseuom'); ?>
	  <?php echo $form->hiddenField($model,'baseuom'); ?>
	  <input type="text" name="sched_name" id="uomcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'baseuom_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Unit of Measure'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'uom-grid',
      'dataProvider'=>$baseuom->Searchwstatus(),
      'filter'=>$baseuom,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#baseuom_dialog\").dialog(\"close\"); $(\"#uomcode\").val(\"$data->uomcode\"); $(\"#Productbasic_baseuom\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#baseuom_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'baseuom'); ?>
	</div>
        </td>
        <td>
        <div class="row">
		<?php echo $form->labelEx($model,'materialgroupid'); ?>
 <?php echo $form->hiddenField($model,'materialgroupid'); ?>
	  <input type="text" name="sched_name" id="materialgroupcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'materialgroup_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'materialgroup-grid',
      'dataProvider'=>$materialgroup->Searchwstatus(),
      'filter'=>$materialgroup,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_materialgroup",
          "id" => "send_materialgroup",
          "onClick" => "$(\"#materialgroup_dialog\").dialog(\"close\"); $(\"#materialgroupcode\").val(\"$data->materialgroupcode\"); $(\"#Productbasic_materialgroupid\").val(\"$data->materialgroupid\");
		  "))',
          ),
	array('name'=>'materialgroupid', 'visible'=>false,'value'=>'$data->materialgroupid','htmlOptions'=>array('width'=>'1%')),
        'materialgroupcode',
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#materialgroup_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'materialgroupid'); ?>
	</div>
          </td>
      </tr>
      <tr>        
          <td>
            <div class="row">
		<?php echo $form->labelEx($model,'oldmatno'); ?>
		<?php echo $form->textField($model,'oldmatno',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'oldmatno'); ?>
	</div>
          </td>
          <td>
          <div class="row">
		<?php echo $form->labelEx($model,'divisionid'); ?>
 <?php echo $form->hiddenField($model,'divisionid'); ?>
	  <input type="text" name="sched_name" id="divisionname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'division_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Division'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'division-grid',
      'dataProvider'=>$division->Searchwstatus(),
      'filter'=>$division,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_division",
          "id" => "send_division",
          "onClick" => "$(\"#division_dialog\").dialog(\"close\"); $(\"#divisionname\").val(\"$data->divisioncode\"); $(\"#Productbasic_divisionid\").val(\"$data->divisionid\");
		  "))',
          ),
	array('name'=>'divisionid', 'visible'=>false,'value'=>'$data->divisionid','htmlOptions'=>array('width'=>'1%')),
        'divisioncode',
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#division_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'divisionid'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'grossweight'); ?>
		<?php echo $form->textField($model,'grossweight',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'grossweight'); ?>
	</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'weightunit'); ?>
<?php echo $form->hiddenField($model,'weightunit'); ?>
	  <input type="text" name="sched_name" id="weightuomcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'weightunit_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Weight Unit'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'weightunit-grid',
      'dataProvider'=>$weightunit->Searchwstatus(),
      'filter'=>$weightunit,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#weightunit_dialog\").dialog(\"close\"); $(\"#weightuomcode\").val(\"$data->uomcode\"); $(\"#Productbasic_weightunit\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#weightunit_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'weightunit'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'netweight'); ?>
		<?php echo $form->textField($model,'netweight',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'netweight'); ?>
	</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'volume'); ?>
		<?php echo $form->textField($model,'volume',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'volume'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'volumeunit'); ?>
 <?php echo $form->hiddenField($model,'volumeunit'); ?>
	  <input type="text" name="sched_name" id="volumeuomcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'volumeunit_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Volume Unit'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'volumeunit-grid',
      'dataProvider'=>$volumeunit->Searchwstatus(),
      'filter'=>$volumeunit,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#volumeunit_dialog\").dialog(\"close\"); $(\"#volumeuomcode\").val(\"$data->uomcode\"); $(\"#Productbasic_volumeunit\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#volumeunit_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'volumeunit'); ?>
	</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'sizedimension'); ?>
		<?php echo $form->textField($model,'sizedimension',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'sizedimension'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'materialpackage'); ?>
 <?php echo $form->hiddenField($model,'materialpackage'); ?>
	  <input type="text" name="sched_name" id="materialname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'materialpackage_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Package'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'matpack-grid',
      'dataProvider'=>$product->Searchwstatus(),
      'filter'=>$product,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_product",
          "id" => "send_product",
          "onClick" => "$(\"#materialpackage_dialog\").dialog(\"close\"); $(\"#materialname\").val(\"$data->productname\"); $(\"#Productbasic_materialpackage\").val(\"$data->productid\");
		  "))',
          ),
	array('name'=>'productid', 'visible'=>false,'value'=>'$data->productid','htmlOptions'=>array('width'=>'1%')),
        'productname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#materialpackage_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'materialpackage'); ?>
	</div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
    <?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>
        </td>
      </tr>
    </table>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('productbasic/write'),
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
		array('productbasic/cancelwrite'),
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
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'productpurchase-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'productpurchaseid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'productid'); ?>
		<?php echo $form->hiddenField($model,'productid'); ?>
	  <input type="text" name="sched_name" id="productname" readonly ">
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
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); $(\"#Productpurchase_productid\").val(\"$data->productid\");
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

	<div class="row">
		<?php echo $form->labelEx($model,'plantid'); ?>
		<?php echo $form->hiddenField($model,'plantid'); ?>
	  <input type="text" name="sched_name" id="plantcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'plantcode_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Plant'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'plant-grid',
      'dataProvider'=>$plant->Searchwstatus(),
      'filter'=>$plant,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_fromuom",
          "id" => "send_fromuom",
          "onClick" => "$(\"#plantcode_dialog\").dialog(\"close\"); $(\"#plantcode\").val(\"$data->plantcode\"); $(\"#Productpurchase_plantid\").val(\"$data->plantid\");
		  "))',
          ),
	array('name'=>'plantid', 'visible'=>false,'value'=>'$data->plantid','htmlOptions'=>array('width'=>'1%')),
        'plantcode',
		'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#plantcode_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'plantid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'orderunit'); ?>
		<?php echo $form->hiddenField($model,'orderunit'); ?>
	  <input type="text" name="sched_name" id="orderuomcode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'orderunit_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Order UOM'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'orderuom-grid',
      'dataProvider'=>$orderunit->Searchwstatus(),
      'filter'=>$orderunit,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_fromuom",
          "id" => "send_fromuom",
          "onClick" => "$(\"#orderunit_dialog\").dialog(\"close\"); $(\"#orderuomcode\").val(\"$data->uomcode\"); $(\"#Productpurchase_orderunit\").val(\"$data->unitofmeasureid\");
		  "))',
          ),
	array('name'=>'unitofmeasureid', 'visible'=>false,'value'=>'$data->unitofmeasureid','htmlOptions'=>array('width'=>'1%')),
        'uomcode',
		'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#orderunit_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'orderunit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'purchasinggroupid'); ?>
		<?php echo $form->hiddenField($model,'purchasinggroupid'); ?>
	  <input type="text" name="sched_name" id="purchasinggroupcode" readonly>
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'purchasinggroupcode_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Purchasing Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'purchgroup-grid',
      'dataProvider'=>$purchasinggroup->Searchwstatus(),
      'filter'=>$purchasinggroup,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_fromuom",
          "id" => "send_fromuom",
          "onClick" => "$(\"#purchasinggroupcode_dialog\").dialog(\"close\"); $(\"#purchasinggroupcode\").val(\"$data->purchasinggroupcode\"); $(\"#Productpurchase_purchasinggroupid\").val(\"$data->purchasinggroupid\");
		  "))',
          ),
	array('name'=>'purchasinggroupid', 'visible'=>false,'value'=>'$data->purchasinggroupid','htmlOptions'=>array('width'=>'1%')),
        'purchasinggroupcode',
		'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#purchasinggroupcode_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'purchasinggroupid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'validfrom'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'validfrom',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
		<?php echo $form->error($model,'validfrom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'validto'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'validto',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'20',
              ),
          ));?>
		<?php echo $form->error($model,'validto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'isautoPO'); ?>
		<?php echo $form->checkBox($model,'isautoPO'); ?>
		<?php echo $form->error($model,'isautoPO'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('productpurchase/write'),
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
		array('productpurchase/cancelwrite'),
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
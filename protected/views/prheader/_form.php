<div class="form">
<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'genjournal-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
	
<?php echo $form->hiddenField($model,'prheaderid');?>
	<table>
	  <tr>		
	  <td>
		<div class="row">
          <?php echo $form->labelEx($model,'prdate'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'prdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
             'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'-10:+10'
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>          <?php echo $form->error($model,'prdate'); ?>
        </div>
		</td>
				<td>
          <div class="row">
		<?php echo $form->labelEx($model,'slocid'); ?>
<?php echo $form->hiddenField($model,'slocid'); ?>
	  <input type="text" name="sloccode" id="sloccode" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'sloc_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Storage Location'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'sloc-grid',
      'dataProvider'=>$sloc->searchslocfrompr(),
      'filter'=>$sloc,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#sloc_dialog\").dialog(\"close\"); $(\"#sloccode\").val(\"$data->description\"); $(\"#Prheader_slocid\").val(\"$data->slocid\");
		  "))',
          ),
	array('name'=>'slocid', 'visible'=>false, 'value'=>'$data->slocid'),
	array('name'=>'plantid','value'=>'($data->plant!==null)?$data->plant->description:""'),
        'sloccode',
          'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("sloc-grid");$("#sloc_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'unitofmeasureid'); ?>
	</div>
        </td>		
        <td>
           <div class="row">
		<?php echo $form->labelEx($model,'deliveryadviceid'); ?>
<?php echo $form->hiddenField($model,'deliveryadviceid'); ?>
        <input type="text" name="product_name" id="dano" style="width: 200px" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'da_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Form Request (Goods/Service/Delivery)'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'da-grid',
      'dataProvider'=>$deliveryadvice->searchwfprstatus(),
      'filter'=>$deliveryadvice,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#da_dialog\").dialog(\"close\"); $(\"#dano\").val(\"$data->dano\");
          $(\"#Prheader_deliveryadviceid\").val(\"$data->deliveryadviceid\");
                generatedata2();
		  "))',
          ),
	array('name'=>'deliveryadviceid', 'visible'=>false, 'value'=>'$data->deliveryadviceid'),
        'dano',
                      'headernote',
          array(
      'name'=>'dadate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->dadate))',
     ),
          array(
      'name'=>'slocid',
      'type'=>'raw',
         'value'=>'($data->sloc!==null?$data->sloc->description:"")',
     ),
                      	array('name'=>'useraccessid', 'value'=>'($data->useraccess!==null)?$data->useraccess->username:""'),
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("da-grid", {
                    data: {
                        "slocid": $("#Prheader_slocid").val(),
                    }
                });$("#da_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'productid'); ?>
	</div>
        </td>
<td>
		  <div class="row">
		<?php echo $form->labelEx($model,'headernote'); ?>
		<?php echo $form->textArea($model,'headernote',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'headernote'); ?>
	</div>
		</td>      	  </tr>
	</table>
		<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('prheader/write'),
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
		array('prheader/cancelwrite'),
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
				  array('prmaterial'=>$prmaterial,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'requestedby'=>$requestedby),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'gidetail-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'gidetailid'); ?>
<?php echo $form->hiddenField($model,'giheaderid'); ?>
	

    <div class="row">
		<?php echo $form->labelEx($model,'productdetailid'); ?>
<?php echo $form->hiddenField($model,'productdetailid'); ?>
<?php echo $form->hiddenField($model,'productid'); ?>
	  <input type="text" name="productname" id="productname" title="Account name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Detail'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$productdetail=new Productdetail('searchwstatus');
	  $productdetail->unsetAttributes();  // clear any defaqult values
	  if(isset($_GET['Productdetail']))
		$productdetail->attributes=$_GET['Productdetail'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$productdetail->Searchwmatcode(),
      'filter'=>$productdetail,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); 
$(\"#Gidetail_productdetailid\").val(\"$data->productdetailid\");
$(\"#Gidetail_productid\").val(\"$data->productid\");
$(\"#Gidetail_qty\").val(\"$data->qty\");
generatedata();
		  "))',
          ),
	array('name'=>'productdetailid', 'visible'=>false,'value'=>'$data->productdetailid:""'),
	'materialcode',
	array('name'=>'productid','value'=>'($data->product!==null)?$data->product->productname:""'),
        'serialno',		
 array(
      'name'=>'qty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
	array('name'=>'unitofmeasureid','value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
	array('name'=>'slocid','value'=>'($data->sloc!==null)?$data->sloc->description:""'),
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$.fn.yiiGridView.update("product-grid", {
                    data: {
                        "deliveryadviceid": $("#Giheader_deliveryadviceid").val(),
						"soheaderid": $("#Giheader_soheaderid").val()
                    }
                });$("#product_dialog").dialog("open"); return false;',
                       ))?>		
		<?php echo $form->error($model,'productdetailid'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'serialno'); ?>
	  <input type="text" name="serialno" id="serialno" readonly >
	</div>

<div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unitofmeasureid'); ?>
		<?php echo $form->hiddenField($model,'unitofmeasureid'); ?>
	  <input type="text" name="uomcode" id="uomcode" readonly >
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slocid'); ?>
		<?php echo $form->hiddenField($model,'slocid'); ?>
	  <input type="text" name="account_name" id="sloccode" title="Account name" readonly >
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'itemnote'); ?>
		<?php echo $form->textArea($model,'itemnote'); ?>
		<?php echo $form->error($model,'itemnote'); ?>
	</div>


    
	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('giheader/writedetail'),
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
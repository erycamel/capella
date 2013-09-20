<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'projectdoc-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(8)}",
));  ?>
<?php echo $form->hiddenField($model,'projectlocationid'); ?>
<?php echo $form->hiddenField($model,'projectid'); ?>
	

	<table>
	<tr>
		<td>
		
		</td>
		<td>
		Original
		</td>
		<td>
		Destination
		</td>
	</tr>
	<tr>
		<td>
		Customer
		</td>
		<td>
		<?php echo $form->hiddenField($model,'originid'); ?>
    <input type="text" name="originname" id="originname" readonly value="<?php
echo (Customer::model()->findByPk($model->originid)!==null)?Customer::model()->findByPk($model->originid)->fullname :'';?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'origin_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Original Customer'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$origin=new Customer('searchwstatus');
	  $origin->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$origin->attributes=$_GET['Customer'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'origin-grid',
        'dataProvider'=>$origin->searchwstatus(),
        'filter'=>$origin,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#origin_dialog\").dialog(\"close\"); $(\"#originname\").val(\"$data->fullname\");
          $(\"#Projectlocation_originid\").val(\"$data->addressbookid\");"))',
          ),
          array('name'=>'addressbookid', 'visible'=>false, 'value'=>'$data->addressbookid'),
          'fullname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#origin_dialog").dialog("open"); return false;',
                       ))?>
		</td>
		<td>
    <?php echo $form->hiddenField($model,'destid'); ?>
    <input type="text" name="destname" id="destname" readonly value="<?php
echo (Customer::model()->findByPk($model->destid)!==null)?Customer::model()->findByPk($model->destid)->fullname :'';?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'dest_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Destination Customer'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$dest=new Customer('searchwstatus');
	  $dest->unsetAttributes();  // clear any default values
	  if(isset($_GET['Customer']))
		$dest->attributes=$_GET['Customer'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'dest-grid',
        'dataProvider'=>$dest->searchwstatus(),
        'filter'=>$dest,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#dest_dialog\").dialog(\"close\"); $(\"#destname\").val(\"$data->fullname\");
          $(\"#Projectlocation_destid\").val(\"$data->addressbookid\");"))',
          ),
          array('name'=>'addressbookid', 'visible'=>false, 'value'=>'$data->addressbookid'),
          'fullname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#dest_dialog").dialog("open"); return false;',
                       ))?>
		</td>
	</tr>
	<tr>
		<td>
		Address
		</td>
		<td>
		<?php echo $form->textArea($model,'originaddress'); ?>
		</td>
		<td>
		<?php echo $form->textArea($model,'destaddress'); ?>
		</td>
	</tr>
	<tr>
		<td>
		City
		</td>
		<td>
		<?php echo $form->hiddenField($model,'origincityid'); ?>
    <input type="text" name="origincityname" id="origincityname" readonly value="<?php
echo (City::model()->findByPk($model->origincityid)!==null)?City::model()->findByPk($model->origincityid)->cityname :'';?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'origincity_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Original City'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$origincity=new City('searchwstatus');
	  $origincity->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$origincity->attributes=$_GET['City'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'origincity-grid',
        'dataProvider'=>$origincity->searchwstatus(),
        'filter'=>$origincity,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#origincity_dialog\").dialog(\"close\"); $(\"#origincityname\").val(\"$data->cityname\");
          $(\"#Projectlocation_origincityid\").val(\"$data->cityid\");"))',
          ),
          array('name'=>'cityid', 'visible'=>false, 'value'=>'$data->cityid'),
          'cityname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#origincity_dialog").dialog("open"); return false;',
                       ))?>
		</td>
		<td>
		<?php echo $form->hiddenField($model,'destcityid'); ?>
    <input type="text" name="destcityname" id="destcityname" readonly value="<?php
echo (City::model()->findByPk($model->destcityid)!==null)?City::model()->findByPk($model->destcityid)->cityname :'';?>">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'destcity_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Destination City'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
						$destcity= new City('searchwstatus');
	  $destcity->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$destcity->attributes=$_GET['City'];
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'destcity-grid',
        'dataProvider'=>$destcity->searchwstatus(),
        'filter'=>$destcity,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#destcity_dialog\").dialog(\"close\"); $(\"#destcityname\").val(\"$data->cityname\");
          $(\"#Projectlocation_destcityid\").val(\"$data->cityid\");"))',
          ),
          array('name'=>'cityid', 'visible'=>false, 'value'=>'$data->cityid'),
          'cityname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#destcity_dialog").dialog("open"); return false;',
                       ))?>
		</td>
	</tr>
	<tr>
		<td>
		Building
		</td>
		<td>
		<?php echo $form->textArea($model,'originbuilding'); ?>
		</td>
		<td>
		<?php echo $form->textArea($model,'destbuilding'); ?>
		</td>
	</tr>
	</table>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('project/writelocation'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("locationdatagrid");
			  $("#createdialog4").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
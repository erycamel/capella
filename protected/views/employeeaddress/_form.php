<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'address-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
<?php echo $form->hiddenField($model,'addressid'); ?>
	
<table>
    <tr>
      <td>
        <div class="row">
		<?php echo $form->labelEx($model,'addressbookid'); ?>
<?php echo $form->hiddenField($model,'addressbookid'); ?>
          <input type="text" name="fullname" id="fullname" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'addressbook_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Employee'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$employeeaddressbook = new Employee('searchwstatus');
	  $employeeaddressbook->unsetAttributes();  // clear any default values
	  if(isset($_GET['Employee']))
		$employeeaddressbook->attributes=$_GET['Employee'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'addressbook-grid',
            'dataProvider'=>$employeeaddressbook->Searchwstatus(),
            'filter'=>$employeeaddressbook,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_addresstype",
                "id" => "send_addresstype",
                "onClick" => "$(\"#addressbook_dialog\").dialog(\"close\");
                $(\"#fullname\").val(\"$data->fullname\");
                $(\"#Employeeaddress_addressbookid\").val(\"$data->addressbookid\");"))',
                ),
	array('name'=>'addressbookid', 'visible'=>false,'value'=>'$data->addressbookid','htmlOptions'=>array('width'=>'1%')),
              'fullname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#addressbook_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'addressbookid'); ?>
	</div>
      </td>
      <td>
        <div class="row">
		<?php echo $form->labelEx($model,'addresstypeid'); ?>
<?php echo $form->hiddenField($model,'addresstypeid'); ?>
          <input type="text" name="addresstypename" id="addresstypename" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'addresstype_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Address Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$addresstype = new Addresstype('searchwstatus');
	  $addresstype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Addresstype']))
		$addresstype->attributes=$_GET['Addresstype'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'addresstype-grid',
            'dataProvider'=>$addresstype->Searchwstatus(),
            'filter'=>$addresstype,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_addresstype",
                "id" => "send_addresstype",
                "onClick" => "$(\"#addresstype_dialog\").dialog(\"close\"); 
                $(\"#addresstypename\").val(\"$data->addresstypename\");
                $(\"#Employeeaddress_addresstypeid\").val(\"$data->addresstypeid\");"))',
                ),
	array('name'=>'addresstypeid', 'visible'=>false,'value'=>'$data->addresstypeid','htmlOptions'=>array('width'=>'1%')),
              'addresstypename',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#addresstype_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'addresstypeid'); ?>
	</div>
      </td>
      <td>
        <div class="row">
		<?php echo $form->labelEx($model,'addressname'); ?>
		<?php echo $form->textField($model,'addressname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'addressname'); ?>
	</div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="row">
		<?php echo $form->labelEx($model,'rt'); ?>
		<?php echo $form->textField($model,'rt',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'rt'); ?>
	</div>
      </td>
      <td>
        <div class="row">
		<?php echo $form->labelEx($model,'rw'); ?>
		<?php echo $form->textField($model,'rw',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'rw'); ?>
	</div>
      </td>
      <td>
        <div class="row">
		<?php echo $form->labelEx($model,'cityid'); ?>
    <?php echo $form->hiddenField($model,'cityid'); ?>
          <input type="text" name="cityname" id="cityname" readonly >

          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'city_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','City'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$city = new City('searchwstatus');
	  $city->unsetAttributes();  // clear any default values
	  if(isset($_GET['City']))
		$city->attributes=$_GET['City'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'city-grid',
            'dataProvider'=>$city->Searchwstatus(),
            'filter'=>$city,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_city",
                "id" => "send_city",
                "onClick" => "$(\"#city_dialog\").dialog(\"close\"); $(\"#cityname\").val(\"$data->cityname\"); $(\"#Employeeaddress_cityid\").val(\"$data->cityid\");"))',
                ),
	array('name'=>'cityid', 'visible'=>false,'value'=>'$data->cityid','htmlOptions'=>array('width'=>'1%')),
              'cityname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#city_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'cityid'); ?>
	</div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="row">
		<?php echo $form->labelEx($model,'kelurahanid'); ?>
<?php echo $form->hiddenField($model,'kelurahanid'); ?>
          <input type="text" name="kelurahanname" id="kelurahanname" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'kelurahan_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Sub Subdistrict'),
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
                array("name" => "send_kelurahan",
                "id" => "send_kelurahan",
                "onClick" => "$(\"#kelurahan_dialog\").dialog(\"close\"); $(\"#kelurahanname\").val(\"$data->kelurahanname\"); $(\"#Employeeaddress_kelurahanid\").val(\"$data->kelurahanid\");"))',
                ),
	array('name'=>'kelurahanid', 'visible'=>false,'value'=>'$data->kelurahanid','htmlOptions'=>array('width'=>'1%')),
              'kelurahanname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#kelurahan_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'kelurahanid'); ?>
	</div>
      </td>
      <td>
        <div class="row">
		<?php echo $form->labelEx($model,'subdistrictid'); ?>
<?php echo $form->hiddenField($model,'subdistrictid'); ?>
          <input type="text" name="subdistrict_name" id="subdistrict_name" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'subdistrict_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Subdistrict'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$subdistrict = new Subdistrict('searchwstatus');
	  $subdistrict->unsetAttributes();  // clear any default values
	  if(isset($_GET['Subdistrict']))
		$subdistrict->attributes=$_GET['Subdistrict'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'subdistrict-grid',
            'dataProvider'=>$subdistrict->Searchwstatus(),
            'filter'=>$subdistrict,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_subdistrict",
                "id" => "send_subdistrict",
                "onClick" => "$(\"#subdistrict_dialog\").dialog(\"close\"); $(\"#subdistrict_name\").val(\"$data->subdistrictname\"); $(\"#Employeeaddress_subdistrictid\").val(\"$data->subdistrictid\");"))',
                ),
	array('name'=>'subdistrictid', 'visible'=>false,'value'=>'$data->subdistrictid','htmlOptions'=>array('width'=>'1%')),
              'subdistrictname',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#subdistrict_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'subdistrictid'); ?>
	</div>
      </td>
<td>
        <div class="row">
		<?php echo $form->labelEx($model,'phoneno'); ?>
    <?php echo $form->textField($model,'phoneno'); ?>
		<?php echo $form->error($model,'phoneno'); ?>
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
		array('employeeaddress/write'),
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
		array('employeeaddress/cancelwrite'),
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

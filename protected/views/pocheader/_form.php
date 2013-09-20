<div class="form">
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'pocheader-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
	
<?php echo $form->hiddenField($model,'pocheaderid'); ?>
	<table>
	  <tr>
              <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'addressbookid'); ?>
    <?php echo $form->hiddenField($model,'addressbookid'); ?>
    <input type="text" name="stat_name" id="fullname" readonly value="<?php echo (Customer::model()->findByPk($model->addressbookid)!==null)?Customer::model()->findByPk($model->addressbookid)->fullname:'';?>">
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
          "onClick" => "$(\"#addressbook_dialog\").dialog(\"close\"); $(\"#fullname\").val(\"$data->fullname\"); $(\"#Pocheader_addressbookid\").val(\"$data->addressbookid\");"))',
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
		<?php echo $form->labelEx($model,'projecttypeid'); ?>
    <?php echo $form->hiddenField($model,'projecttypeid'); ?>
    <input type="text" name="stat_name" id="protypedescription" readonly value="
<?php echo (Projecttype::model()->findByPk($model->projecttypeid)!==null)?Projecttype::model()->findByPk($model->projecttypeid)->description:'';?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'projecttype_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Customer'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'projecttype-grid',
        'dataProvider'=>$projecttype->searchwstatus(),
        'filter'=>$projecttype,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#projecttype_dialog\").dialog(\"close\"); $(\"#protypedescription\").val(\"$data->description\"); $(\"#Pocheader_projecttypeid\").val(\"$data->projecttypeid\");"))',
          ),
          'projecttypeid',
          'description',
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
                          array('onclick'=>'$("#projecttype_dialog").dialog("open"); return false;',
                       ))
    ?>
		<?php echo $form->error($model,'projecttypeid'); ?>
	</div>
		</td>
              <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'pocno'); ?>
		<?php echo $form->textField($model,'pocno'); ?>
		<?php echo $form->error($model,'pocno'); ?>
	</div>
		</td>
                      <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'contractno'); ?>
		<?php echo $form->textField($model,'contractno'); ?>
		<?php echo $form->error($model,'contractno'); ?>
	</div>
		</td>
                      <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'sono'); ?>
		<?php echo $form->textField($model,'sono'); ?>
		<?php echo $form->error($model,'sono'); ?>
	</div>
		</td>
                      <td>
		  <div class="row">
		<?php echo $form->labelEx($model,'woino'); ?>
		<?php echo $form->textField($model,'woino'); ?>
		<?php echo $form->error($model,'woino'); ?>
	</div>
		</td>
	  </tr>
	  <tr>
        <td>
          <div class="row">
          <?php echo $form->labelEx($model,'pocdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'pocdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
          <?php echo $form->error($model,'pocdate'); ?>
        </div>
        </td>
        <td>
          <div class="row">
          <?php echo $form->labelEx($model,'deliverydate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'deliverydate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
          <?php echo $form->error($model,'deliverydate'); ?>
        </div>
        </td>
        <td>
          <div class="row">
          <?php echo $form->labelEx($model,'testdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'testdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
          <?php echo $form->error($model,'testdate'); ?>
        </div>
        </td>
         <td>
          <div class="row">
          <?php echo $form->labelEx($model,'qcdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'qcdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
          <?php echo $form->error($model,'qcdate'); ?>
        </div>
         </td>
         <td>
          <div class="row">
          <?php echo $form->labelEx($model,'docdate'); ?>
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'docdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
          <?php echo $form->error($model,'docdate'); ?>
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
		<?php echo $form->labelEx($model,'phoneno'); ?>
		<?php echo $form->textField($model,'phoneno'); ?>
		<?php echo $form->error($model,'phoneno'); ?>
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
	</table>
		<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('pocheader/write'),
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
		array('pocheader/cancelwrite'),
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
			array('pocdetail'=>$pocdetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
                'currency'=>$currency),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->
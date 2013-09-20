<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userfav-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelpmodif=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelpmodif,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>
<?php echo $form->hiddenField($model,'userfavid'); ?>
	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'useraccessid'); ?>
		<?php echo $form->hiddenField($model,'useraccessid'); ?>
          <input type="text" name="addresstype_name" id="realname" readonly value="<?php echo (Useraccess::model()->findByPk($model->useraccessid)!==null)?Useraccess::model()->findByPk($model->useraccessid)->realname :'';?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'useraccess_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Address Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
            $useraccess = new Useraccess('searchwstatus');
	  $useraccess->unsetAttributes();  // clear any default values
	  if(isset($_GET['Useraccess']))
		$useraccess->attributes=$_GET['Useraccess'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'useraccess-grid',
            'dataProvider'=>$useraccess->Searchwstatus(),
            'filter'=>$useraccess,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_addresstype",
                "id" => "send_addresstype",
                "onClick" => "$(\"#useraccess_dialog\").dialog(\"close\"); $(\"#realname\").val(\"$data->realname\"); $(\"#Userfav_useraccessid\").val(\"$data->useraccessid\");"))',
                ),
              'useraccessid',
              'username',
			  'realname',
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
                                array('onclick'=>'$("#useraccess_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'useraccessid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menuaccessid'); ?>
		<?php echo $form->hiddenField($model,'menuaccessid'); ?>
          <input type="text" name="addresstype_name" id="description" readonly value="<?php echo (Menuaccess::model()->findByPk($model->menuaccessid)!==null)?Menuaccess::model()->findByPk($model->menuaccessid)->description :'';?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'menuaccess_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Address Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'menuaccess-grid',
            'dataProvider'=>$menuaccess->Searchwstatus(),
            'filter'=>$menuaccess,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_addresstype",
                "id" => "send_addresstype",
                "onClick" => "$(\"#menuaccess_dialog\").dialog(\"close\"); $(\"#description\").val(\"$data->description\"); $(\"#Userfav_menuaccessid\").val(\"$data->menuaccessid\");"))',
                ),
              'menuaccessid',
              'menuname',
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
                                array('onclick'=>'$("#menuaccess_dialog").dialog("open"); return false;',
                             ));?>
		<?php echo $form->error($model,'menuaccessid'); ?>
	</div>

	<div class="row buttons">
<?php echo CHtml::ajaxSubmitButton('Save',
		array('userfav/write'),
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
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tikitransdet-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'airwaybillno'); ?>
<?php echo $form->hiddenField($model,'airwaybillno'); ?>
          <input type="text" name="tikitrans_name" id="tikitrans_name" readonly value="<?php echo Tikitrans::model()->findByPk($model->airwaybillno)->airwaybillno ?>">
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'tikitrans_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Organization Structure'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));

          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'tikitrans-grid',
            'dataProvider'=>$tikitrans->Searchwstatus(),
            'filter'=>$tikitrans,
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("+",
                array("name" => "send_tikitrans",
                "id" => "send_tikitrans",
                "onClick" => "$(\"#tikitrans_dialog\").dialog(\"close\"); $(\"#tikitrans_name\").val(\"$data->airwaybillno\"); $(\"#Tikitransdet_airwaybillno\").val(\"$data->airwaybillno\");"))',
                ),
              'airwaybillno',
              'shipcompany',
			  'shipname',
			  'rcvcompany',
			  'rcvattention',
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
                                array('onclick'=>'$("#tikitrans_dialog").dialog("open"); return false;',
                             ));?>		
		<?php echo $form->error($model,'airwaybillno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pieces'); ?>
		<?php echo $form->textField($model,'pieces'); ?>
		<?php echo $form->error($model,'pieces'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'length'); ?>
		<?php echo $form->textField($model,'length'); ?>
		<?php echo $form->error($model,'length'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'width'); ?>
		<?php echo $form->textField($model,'width',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'width'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'height'); ?>
		<?php echo $form->textField($model,'height',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'height'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weightvol'); ?>
		<?php echo $form->textField($model,'weightvol',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'weightvol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
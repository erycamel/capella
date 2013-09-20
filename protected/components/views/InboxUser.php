<div class="userinboxform">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'userinbox-form',
	'enableAjaxValidation'=>true,
)); ?>
<fieldset>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'gridtodo',
	'dataProvider'=>$model->Search(),
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array(
      'name'=>'tododate',
      'type'=>'raw',
         'value'=>'($data->tododate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->tododate)):""',
     ),  
	 array(
      'name'=>'menuname',
      'type'=>'raw',
         'value'=>'$data->menuname',
     ),  
	 array(
      'name'=>'description',
      'type'=>'raw',
         'value'=>'$data->description',
     ),  
  ),
));
?>
<?php $this->endWidget(); ?>
</fieldset>
</div>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('moduletypeid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->moduletypeid), array('view', 'id'=>$data->moduletypeid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('moduletypename')); ?>:</b>
	<?php echo CHtml::encode($data->moduletypename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recordstatus')); ?>:</b>
	<?php echo CHtml::encode($data->recordstatus); ?>
	<br />


</div>
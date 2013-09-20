<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('userinboxid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->userinboxid), array('view', 'id'=>$data->userinboxid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('useraccessid')); ?>:</b>
	<?php echo CHtml::encode($data->useraccessid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('messages')); ?>:</b>
	<?php echo CHtml::encode($data->messages); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recordstatus')); ?>:</b>
	<?php echo CHtml::encode($data->recordstatus); ?>
	<br />


</div>
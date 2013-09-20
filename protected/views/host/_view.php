<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('hostid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->hostid), array('view', 'id'=>$data->hostid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hostname')); ?>:</b>
	<?php echo CHtml::encode($data->hostname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ipclient')); ?>:</b>
	<?php echo CHtml::encode($data->ipclient); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recordstatus')); ?>:</b>
	<?php echo CHtml::encode($data->recordstatus); ?>
	<br />


</div>
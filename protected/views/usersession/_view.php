<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('usersessionid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->usersessionid), array('view', 'id'=>$data->usersessionid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('useraccessid')); ?>:</b>
	<?php echo CHtml::encode($data->useraccessid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menuaccessid')); ?>:</b>
	<?php echo CHtml::encode($data->menuaccessid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usertime')); ?>:</b>
	<?php echo CHtml::encode($data->usertime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sessioncode')); ?>:</b>
	<?php echo CHtml::encode($data->sessioncode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recordstatus')); ?>:</b>
	<?php echo CHtml::encode($data->recordstatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ipaddress')); ?>:</b>
	<?php echo CHtml::encode($data->ipaddress); ?>
	<br />


</div>
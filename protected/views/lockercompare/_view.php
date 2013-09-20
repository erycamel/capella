<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lockercompareid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lockercompareid), array('view', 'id'=>$data->lockercompareid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lockerkeyid')); ?>:</b>
	<?php echo CHtml::encode($data->lockerkeyid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('keynum')); ?>:</b>
	<?php echo CHtml::encode($data->keynum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employeeid')); ?>:</b>
	<?php echo CHtml::encode($data->employeeid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fullname')); ?>:</b>
	<?php echo CHtml::encode($data->fullname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oldnik')); ?>:</b>
	<?php echo CHtml::encode($data->oldnik); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('newnik')); ?>:</b>
	<?php echo CHtml::encode($data->newnik); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fulldivision')); ?>:</b>
	<?php echo CHtml::encode($data->fulldivision); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('absscheduleid')); ?>:</b>
	<?php echo CHtml::encode($data->absscheduleid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('schedulename')); ?>:</b>
	<?php echo CHtml::encode($data->schedulename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transdate')); ?>:</b>
	<?php echo CHtml::encode($data->transdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('takedate')); ?>:</b>
	<?php echo CHtml::encode($data->takedate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checkdate')); ?>:</b>
	<?php echo CHtml::encode($data->checkdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('returndate')); ?>:</b>
	<?php echo CHtml::encode($data->returndate); ?>
	<br />

	*/ ?>

</div>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lockertakeid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lockertakeid), array('view', 'id'=>$data->lockertakeid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employeeid')); ?>:</b>
	<?php echo CHtml::encode($data->employeeid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lockerkeyid')); ?>:</b>
	<?php echo CHtml::encode($data->lockerkeyid); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('fulldivision')); ?>:</b>
	<?php echo CHtml::encode($data->fulldivision); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('takedate')); ?>:</b>
	<?php echo CHtml::encode($data->takedate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recordstatus')); ?>:</b>
	<?php echo CHtml::encode($data->recordstatus); ?>
	<br />

	*/ ?>

</div>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lockerreturnid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lockerreturnid), array('view', 'id'=>$data->lockerreturnid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lockerkeyid')); ?>:</b>
	<?php echo CHtml::encode($data->lockerkeyid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lockerboxid')); ?>:</b>
	<?php echo CHtml::encode($data->lockerboxid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('returndate')); ?>:</b>
	<?php echo CHtml::encode($data->returndate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lockerstaffid')); ?>:</b>
	<?php echo CHtml::encode($data->lockerstaffid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employeeid')); ?>:</b>
	<?php echo CHtml::encode($data->employeeid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fullname')); ?>:</b>
	<?php echo CHtml::encode($data->fullname); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('oldnik')); ?>:</b>
	<?php echo CHtml::encode($data->oldnik); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('newnik')); ?>:</b>
	<?php echo CHtml::encode($data->newnik); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fulldivision')); ?>:</b>
	<?php echo CHtml::encode($data->fulldivision); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recordstatus')); ?>:</b>
	<?php echo CHtml::encode($data->recordstatus); ?>
	<br />

	*/ ?>

</div>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('tikitransdetid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->tikitransdetid), array('view', 'id'=>$data->tikitransdetid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('airwaybillno')); ?>:</b>
	<?php echo CHtml::encode($data->airwaybillno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pieces')); ?>:</b>
	<?php echo CHtml::encode($data->pieces); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('length')); ?>:</b>
	<?php echo CHtml::encode($data->length); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('width')); ?>:</b>
	<?php echo CHtml::encode($data->width); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('height')); ?>:</b>
	<?php echo CHtml::encode($data->height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weightvol')); ?>:</b>
	<?php echo CHtml::encode($data->weightvol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recordstatus')); ?>:</b>
	<?php echo CHtml::encode($data->recordstatus); ?>
	<br />

	*/ ?>

</div>
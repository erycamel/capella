<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('memberymid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->memberymid), array('view', 'id'=>$data->memberymid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('voucheragentid')); ?>:</b>
	<?php echo CHtml::encode($data->voucheragentid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idym')); ?>:</b>
	<?php echo CHtml::encode($data->idym); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recordstatus')); ?>:</b>
	<?php echo CHtml::encode($data->recordstatus); ?>
	<br />


</div>
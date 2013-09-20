<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('trxjunkid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->trxjunkid), array('view', 'id'=>$data->trxjunkid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trxdate')); ?>:</b>
	<?php echo CHtml::encode($data->trxdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('senderx')); ?>:</b>
	<?php echo CHtml::encode($data->senderx); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textdecoded')); ?>:</b>
	<?php echo CHtml::encode($data->textdecoded); ?>
	<br />


</div>
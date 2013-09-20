<div class="view">
  Click <?php echo CHtml::link('here', array($data->menuaccess->menuurl, 'id'=>$data->usertodoid)); ?> to go to menu<br/>
	<?php echo CHtml::encode($data->tododate); ?><br/>
	<?php echo CHtml::encode($data->description); ?><br/><br/>
</div>
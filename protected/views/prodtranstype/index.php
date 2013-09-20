<?php
$this->breadcrumbs=array(
	'Prodtranstypes',
);

$this->menu=array(
	array('label'=>'Create Prodtranstype', 'url'=>array('create')),
	array('label'=>'Manage Prodtranstype', 'url'=>array('admin')),
);
?>

<h1>Prodtranstypes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

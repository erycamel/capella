<?php
$this->breadcrumbs=array(
	'Projectboms',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function refreshdata1()
{
    $.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<?php
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(3)}",
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pettycashdatagrid',
	'dataProvider'=>$pettycash->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'pettycashdetailid', 'header'=>'ID','value'=>'$data->pettycashdetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'pettycashid', 'value'=>'($data->pettycash!==null)?$data->pettycash->pettycashno:""'),
	array('name'=>'currency','value'=>'$data->currency->currencyname'),
  ),
));
?>

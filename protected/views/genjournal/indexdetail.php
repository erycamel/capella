<?php
$this->breadcrumbs=array(
	'Genjournals',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('genjournal/createdetail'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Journaldetail_journaldetailid').val('');
					$('#Journaldetail_accountid').val('');
					$('#account_name').val('');
					$('#Journaldetail_debit').val('0');
					$('#Journaldetail_credit').val('0');
					$('#Journaldetail_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Journaldetail_detailnote').val('');
					$('#Journaldetail_ratevalue').val('1');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
                }
                else
                {
                    document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function editdata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('genjournal/updatedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Journaldetail_journaldetailid').val(data.journaldetailid);
					$('#Journaldetail_accountid').val(data.accountid);
					$('#account_name').val(data.accountname);
					$('#Journaldetail_debit').val(data.debit);
					$('#Journaldetail_credit').val(data.credit);
					$('#Journaldetail_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Journaldetail_detailnote').val(data.detailnote);
					$('#Journaldetail_ratevalue').val(data.ratevalue);
					if (data.recordstatus == '1')
					{
					  $('#recordstatus').checked='checked';
					}
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
                }
                else
                {
                    document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function deletedata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('genjournal/deletedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata1()
{
    $.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog1',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate1"></div>
<?php echo $this->renderPartial('_formdetail', array('model'=>$journaldetail)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata1()}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata1()}",
));
$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($img1delete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata1()}",
));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(3)}",
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detaildatagrid',
	'dataProvider'=>$journaldetail->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'journaldetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->journaldetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'accountid', 'header'=>'Account Code','value'=>'$data->account->accountcode'),
	array('name'=>'accountid', 'header'=>'Account Name','value'=>'$data->account->accountname'),
             array(
      'name'=>'debit',
      'type'=>'raw',
'value'=>'Yii::app()->numberFormatter->formatCurrency($data->debit,($data->currency!==null)?$data->currency->symbol:"")'
        ),
            array(
      'name'=>'credit',
      'type'=>'raw',
                'value'=>'Yii::app()->numberFormatter->formatCurrency($data->credit,($data->currency!==null)?$data->currency->symbol:"")',
     ),
	array('name'=>'currencyid', 'value'=>'$data->currency->currencyname'),
        'detailnote'
  ),
));
?>

<?php
$this->breadcrumbs=array(
	'Projects',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
    jQuery.ajax({
        'url': '/smlive/index.php?r=project/help',
        'data': {
            'id': value
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if (data.status == 'success') {
				document.getElementById('divhelp').innerHTML = data.div;
                $('#helpdialog').dialog('open');
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=repproject/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('inlocationdatagrid', {
                    data: {
                        'Projectlocation[projectid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    $.fn.yiiGridView.update('indocumentdatagrid', {
                    data: {
                        'Projectdocument[projectid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    $.fn.yiiGridView.update('innetworkdatagrid', {
                    data: {
                        'Projectnetwork[projectid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });	
	$.fn.yiiGridView.update('inpicdatagrid', {
                    data: {
                        'Projectpic[projectid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });	
    $.fn.yiiGridView.update('inservicedatagrid', {
                    data: {
                        'Projectservice[projectid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });	
				$.fn.yiiGridView.update('inemployeedatagrid', {
                    data: {
                        'Projectemp[projectid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
				$.fn.yiiGridView.update('insrftimedatagrid', {
                    data: {
                        'Srftime[projectid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpdialog',
    'options'=>array(
        'title'=>'Help',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divhelp"></div>
<?php $this->endWidget();?>
<h1>Report: Service Request Form (SRF)</h1><div id="toolbar">
<ul>
<?php
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
    'onclick'=>"{downloaddata()}",
   'title'=>Yii::t('app','download data')
));
echo CHtml :: closeTag('li');

$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>Yii::t('app','refresh data')
));
echo CHtml :: closeTag('li');

$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml :: openTag('li');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(1)}",
   'title'=>Yii::t('app','help')
));
echo CHtml :: closeTag('li');
?>
<div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></ul></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->Search(),
	'filter'=>$model,
    'selectionChanged'=>'showdetail',
    'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'projectid', 'visible'=>false,'header'=>'ID','value'=>'$data->projectid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'projectno', 'value'=>'$data->projectno'),
	array('name'=>'soheaderid', 'value'=>'($data->soheader!==null)?$data->soheader->sono:""'),
	array('name'=>'soheaderid', 'value'=>'($data->soheader!==null)?$data->soheader->customer->fullname:""'),
        'projectnote',
		'serviceno',
		array(
      'name'=>'priceotr',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->priceotr)',
     ),
		array(
      'name'=>'priceotc',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->priceotc)',
     ),
    array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appproject",$data->recordstatus)')
  ),
));
?>
<?php
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs' => array(
		'Service' => array('content' => $this->renderPartial('viewservice',
			 array('projectservice'=>$projectservice),true)),
		'Network' => array('content' => $this->renderPartial('viewnetwork',
			 array('projectnetwork'=>$projectnetwork),true)),
		'Schedule' => array('content' => $this->renderPartial('viewemployee',
			 array('projectemp'=>$projectemp),true)),
		'Person In Charge' => array('content' => $this->renderPartial('viewpic',
			 array('projectpic'=>$projectpic),true)),
		'Location' => array('content' => $this->renderPartial('viewlocation',
			 array('projectlocation'=>$projectlocation),true)),
		'Document' => array('content' => $this->renderPartial('viewdocument',
			 array('projectdocument'=>$projectdocument),true)),
		'SRF history' => array('content' => $this->renderPartial('viewsrftime',
			 array('srftime'=>$srftime),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>


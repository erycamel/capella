<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=reportsrf/download');
}
</script>
<script type="text/javascript">
function downloaddata2() {
	window.open('/smlive/index.php?r=reportsrf/downloaddetailservice');
}
</script>
<center>
<h1>Cetak Report SRF</h1>
<br><br>
<div id="toolbar">
<ul>
<?php
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
    'onclick'=>"{downloaddata()}",
   'title'=>Yii::t('app','Report SRF')
));
echo CHtml :: closeTag('li');
?>
<?php
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
    'onclick'=>"{downloaddata2()}",
   'title'=>Yii::t('app','Report SRF Per Service Type')
));
echo CHtml :: closeTag('li');

?>
</ul>
</div>
</center>
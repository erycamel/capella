<h>Work Order Historicall data</h><br/><br/>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$workorderhist->search(),
    'ajaxUpdate'=>false,
    'template'=>'{sorter}{pager}{summary}{items}{pager}',
    'itemView'=>'_view',
    'pager'=>array(
        'maxButtonCount'=>'7',
    ),
));?>
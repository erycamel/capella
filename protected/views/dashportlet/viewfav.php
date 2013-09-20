<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->searchwuser(),
    'template'=>'{items}',
    'itemView'=>'/dashportlet/_viewfav',
));
?>

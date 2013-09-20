<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->search(),
    'template'=>'{items}',
    'itemView'=>'/dashportlet/_viewinbox',
));
?>
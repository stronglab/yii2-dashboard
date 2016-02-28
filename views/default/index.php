<?php

use yii\widgets\ListView;

?>
<div class="dashboard-default-index">
    <?php
    echo ListView::widget([
        'id' => 'module-list',
        'dataProvider' => $dataProvider,
        'itemView' => '_modules',
        'summary' => '',
        'options' => ['class' => 'module-list-' . $column],
    ]);
    ?>
    <div class="clearfix"></div>
</div>

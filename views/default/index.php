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
    ]);
    ?>
</div>

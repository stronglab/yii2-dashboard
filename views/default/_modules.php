<?php

use yii\widgets\ListView;
?>

<h3><?php echo $model['title']; ?></h3>

<?php if (!is_null($model['routes'])) : ?>

    <?php
    echo ListView::widget([
        'id' => 'item-list',
        'dataProvider' => $model['routes'],
        'itemView' => '_items',
        'summary' => '',
        'itemOptions' => [
            'class' => 'dashboard-ico-block',
        ]
    ]);
    ?>

<?php endif; ?>
<div class="clearfix"></div>

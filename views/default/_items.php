<?php

use yii\helpers\Url;
?>

<a href="<?= Url::to($model['route']); ?>">
    <span class="glyphicon glyphicon-<?= $model['icon']; ?>" aria-hidden="true"></span><br />
    <?php echo $model['title']; ?>
</a>

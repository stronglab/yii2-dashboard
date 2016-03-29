<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use stronglab\dashboard\assets\DashboardAssets;
use stronglab\dashboard\Module;

DashboardAssets::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Dashboard',
        'brandUrl' => Url::toRoute('/' . Yii::$app->controller->module->id),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Module::t('gohome'), 'url' => Yii::$app->homeUrl, 'linkOptions' => ['target' => '_blank']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?php if (isset($this->params['breadcrumbs'])): ?>
            <?php
            array_splice($this->params['breadcrumbs'], 0, 0, [['label' => 'Dashboard', 'url' => Url::toRoute('/' . Yii::$app->controller->module->id)]]);
            echo Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
            ]);
            ?>
        <?php endif; ?>
        <?php
        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
        }
        ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

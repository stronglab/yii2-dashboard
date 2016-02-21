<?php

namespace stronglab\yii2\dashboard\controllers;

use yii\web\Controller;

/**
 * DefaultController
 *
 * @author strong
 */
class DefaultController extends Controller {

    public function beforeAction($action) {
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        var_dump($this->module->config->getConfigs());
    }

    public function actionRoute($m, $c, $a) {
        $route = $m . '/' . $c . ($a != 0 ? '/' . $a : '');
        return \Yii::$app->runAction($route);
    }

}

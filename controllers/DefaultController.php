<?php

namespace stronglab\yii2\dashboard\controllers;

use yii\web\Controller;

/**
 * DefaultController
 *
 * @author strong
 */
class DefaultController extends Controller {

    public function actionIndex() {
        var_dump($this->module->config->getConfigs());
    }

}

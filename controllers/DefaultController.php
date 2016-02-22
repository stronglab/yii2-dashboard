<?php

namespace stronglab\yii2\dashboard\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController
 *
 * @author strong
 */
class DefaultController extends Controller {

    public $layout = 'main';

    public function actionIndex($m = 0, $c = 0, $a = 0) {
        if ($m === 0 && $c === 0) {
            $dataProvider = $this->module->config->getDataProvider();
            return $this->render('index', [
                        'dataProvider' => $dataProvider,
            ]);
        }
        $route = $m . '/' . $c . ($a != 0 ? '/' . $a : '');
        if (!$this->module->config->isDashboardRoute($route)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $alias = $this->module->alias;
        $action = ($a === 0 ? $c : $a);
        $controller = \Yii::$app->createController($route);
        if (!isset($controller[0]) and ! ($controller[0] instanceof \yii\base\Controller)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $controller[0]->layout = $alias . '/views/layouts/main';
        return $controller[0]->run($action, \Yii::$app->request->get());
    }

}

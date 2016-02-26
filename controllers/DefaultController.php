<?php

namespace stronglab\yii2\dashboard\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use stronglab\yii2\dashboard\components\ConfigComponent;

/**
 * DefaultController
 *
 * @author strong
 */
class DefaultController extends Controller {

    /**
     *
     * @var string Custom layout for dashboard 
     */
    public $layout = 'main';

    /**
     * Dashboard index action
     * 
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex() {

        if ($page = $this->getIndexPage()) {
            return $page;
        }

        $route = $this->getDashboardRoute();
        $action = $this->getActionName();
        $controller = Yii::$app->createController($route);
        if (!isset($controller[0]) and ! ($controller[0] instanceof \yii\base\Controller)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $controller[0]->layout = $this->module->alias . '/views/layouts/main';
        return $controller[0]->run($action, Yii::$app->request->get());
    }

    /**
     * 
     * @inheritdoc
     */
    public function getRoute() {
        if (is_null(Yii::$app->request->get(ConfigComponent::FIRST_SEGMENT)) && is_null(Yii::$app->request->get(ConfigComponent::SECOND_SEGMENT))) {
            return parent::getRoute();
        }
        $third = (Yii::$app->request->get(ConfigComponent::THIRD_SEGMENT) === 0 ? '' : '/' . Yii::$app->request->get(ConfigComponent::THIRD_SEGMENT));
        return $this->module->id . '/' . Yii::$app->request->get(ConfigComponent::FIRST_SEGMENT) . '/' . Yii::$app->request->get(ConfigComponent::SECOND_SEGMENT) . $third;
    }

    /**
     * Check valid request for dashboard
     * 
     * @return array
     * @throws NotFoundHttpException
     */
    protected function checkValidRoute() {
        $getParam = Yii::$app->request->get();
        if (!isset($getParam[ConfigComponent::FIRST_SEGMENT], $getParam[ConfigComponent::SECOND_SEGMENT], $getParam[ConfigComponent::THIRD_SEGMENT])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $getParam;
    }

    /**
     * Get current dshboard route
     * 
     * @return string
     * @throws NotFoundHttpException
     */
    protected function getDashboardRoute() {
        $getParam = $this->checkValidRoute();
        $route = $getParam[ConfigComponent::FIRST_SEGMENT] . '/' .
                $getParam[ConfigComponent::SECOND_SEGMENT] . (
                $getParam[ConfigComponent::THIRD_SEGMENT] === 0 ? '' : '/' . $getParam[ConfigComponent::THIRD_SEGMENT]
                );
        
        if (!$this->module->config->isDashboardRoute($route)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $route;
    }

    /**
     * Return index page or false
     * 
     * @return boolean|string
     */
    protected function getIndexPage() {
        if (empty($_GET)) {
            $dataProvider = $this->module->config->getDataProvider();
            return $this->render('index', [
                        'dataProvider' => $dataProvider,
            ]);
        }
        return false;
    }

    /**
     * Get Action name from url
     * 
     * @return string
     */
    public function getActionName() {
        return (Yii::$app->request->get(ConfigComponent::THIRD_SEGMENT) === 0 ?
                        Yii::$app->request->get(ConfigComponent::SECOND_SEGMENT) :
                        Yii::$app->request->get(ConfigComponent::THIRD_SEGMENT)
                );
    }

}

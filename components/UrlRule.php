<?php

namespace stronglab\yii2\dashboard\components;

use Yii;

/**
 * UrlRules
 *
 * @author strong
 */
class UrlRule extends \yii\web\UrlRule {

    /**
     *
     * @var string Dashboard module ID
     */
    public $dashboardId = 'dashboard';

    /**
     * @inheritdoc
     */
    public function init() {
        $this->pattern = $this->dashboardId . '/<m>/<c>/<a>';
        $this->route = $this->dashboardId . '/default/index';
        $this->defaults = [
            'a' => 0,
        ];
        parent::init();
    }

    /**
     * Replace dashboard routes in url
     * 
     * @param object $manager
     * @param string $route
     * @param array $params
     * @return bool
     */
    public function createUrl($manager, $route, $params) {
        $customRoute = $this->prepareRoute($route);
        if (Yii::$app->getModule($this->dashboardId)->config->isDashboardRoute($customRoute)) {
            $extRoute = Yii::$app->getModule($this->dashboardId)->config->getRoute($customRoute);
            return parent::createUrl($manager, $this->dashboardId . '/default/index', array_merge($params, $this->paramzRoute($extRoute)));
        }
        return parent::createUrl($manager, $route, $params);
    }

    /**
     * Generate params array for createUrl method
     * 
     * @param string $route
     * @return array
     */
    protected function paramzRoute($route) {
        $route = explode('/', $route);
        $m = isset($route[0]) ? $route[0] : 0;
        $c = isset($route[1]) ? $route[1] : 0;
        $a = isset($route[2]) ? $route[2] : 0;
        return ['m' => $m, 'c' => $c, 'a' => $a];
    }

    /**
     * Prepare route for compare dashboard
     * 
     * @param string $route
     * @return string
     */
    protected function prepareRoute($route) {
        $getParam = \Yii::$app->request->get();
        if (!isset($getParam['a'], $getParam['c'], $getParam['m'])) {
            return $route;
        }
        if ($getParam['a'] === 0) {
            $route = str_replace($this->dashboardId . '/default', $getParam['m'], $route);
        } else {
            $route = str_replace($this->dashboardId . '/default', $getParam['m'] . '/' . $getParam['c'], $route);
        }
        return $route;
    }

}

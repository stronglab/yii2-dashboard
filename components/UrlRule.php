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
        if (Yii::$app->getModule($this->dashboardId)->config->isDashboardRoute($route)) {
            $extRoute = Yii::$app->getModule($this->dashboardId)->config->getRoute($route);
            return parent::createUrl($manager, $this->dashboardId . '/default/route', array_merge($params, $this->paramzRoute($extRoute)));
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

}

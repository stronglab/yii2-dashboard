<?php

namespace stronglab\yii2\dashboard\components;

use Yii;
use stronglab\yii2\dashboard\components\ConfigComponent;

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
        $this->pattern = $this->dashboardId . '/<' . ConfigComponent::FIRST_SEGMENT . '>/<' . ConfigComponent::SECOND_SEGMENT . '>/<' . ConfigComponent::THIRD_SEGMENT . '>';
        $this->route = $this->dashboardId . '/default/index';
        $this->defaults = [
            ConfigComponent::THIRD_SEGMENT => 0,
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
        $first = isset($route[0]) ? $route[0] : 0;
        $second = isset($route[1]) ? $route[1] : 0;
        $third = isset($route[2]) ? $route[2] : 0;
        return [ConfigComponent::FIRST_SEGMENT => $first, ConfigComponent::SECOND_SEGMENT => $second, ConfigComponent::THIRD_SEGMENT => $third];
    }

    /**
     * Prepare route for compare dashboard
     * 
     * @param string $route
     * @return string
     */
    protected function prepareRoute($route) {
        $getParam = Yii::$app->request->get();
        if (!isset($getParam[ConfigComponent::FIRST_SEGMENT], $getParam[ConfigComponent::SECOND_SEGMENT], $getParam[ConfigComponent::THIRD_SEGMENT])) {
            return $route;
        }
        if ($getParam[ConfigComponent::THIRD_SEGMENT] === 0) {
            $route = str_replace($this->dashboardId . '/default', $getParam[ConfigComponent::FIRST_SEGMENT], $route);
        } else {
            $route = str_replace($this->dashboardId . '/default', $getParam[ConfigComponent::FIRST_SEGMENT] . '/' . $getParam[ConfigComponent::SECOND_SEGMENT], $route);
        }
        return $route;
    }

}

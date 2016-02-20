<?php

namespace stronglab\yii2\dashboard\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use yii\base\Exception;

/**
 * ModulesHandler
 *
 * @author strong
 */
class ConfigComponent extends Component {

    /**
     * Non-module dashboard configuration key in modules array 
     */
    const APP_CONFIG_KEY = '_application';

    /**
     *
     * @var array List availavle configs
     */
    private $_configs = [];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->addApplicationConfig();
    }

    /**
     * Validate and set available modules for dashboard
     *
     * @param array $moduleNames
     * @return object 
     */
    public function setModules(array $moduleNames) {
        foreach ($moduleNames as $moduleName) {
            $this->setModule($moduleName);
        }
        return $this;
    }

    /**
     * Validate and set available module for dashboard
     * 
     * @param string $moduleName
     * @return object
     */
    public function setModule($moduleName) {
        $module = Yii::$app->getModule($moduleName, false);
        if (is_null($module)) {
            return $this;
        }
        $configFile = $module->getBasePath() . '/dashboard.json';
        $config = $this->getConfig($configFile);
        if ($config !== false) {
            $this->_configs[$moduleName] = $config;
        }
        return $this;
    }

    /**
     * Get available dashbord modules config
     * 
     * @return array
     */
    public function getConfigs() {
        return $this->_configs;
    }

    /**
     * Add base application dashboard config
     * 
     * @return null
     */
    protected function addApplicationConfig() {
        $configFile = Yii::getAlias('@app') . '/dashboard.json';
        $config = $this->getConfig($configFile);
        if ($config !== false) {
            $this->_configs[self::APP_CONFIG_KEY] = $config;
        }
    }

    /**
     * Get dashboard config
     * 
     * @param string $configFile
     * @return array|bool config data or FALSE
     */
    protected function getConfig($configFile) {

        if (!file_exists($configFile)) {
            return false;
        }
        if (!($content = @file_get_contents($configFile))) {
            return false;
        }
        $config = Json::decode($content);
        $this->validateConfig($config);
        return $this->filterConfig($config);
    }

    /**
     * Validate dashboard config
     * 
     * @param array $config
     * @return null
     */
    protected function validateConfig($config) {
        if (!isset($config['name'])) {
            throw new Exception("Syntax error: field 'name' is required");
        }
        if (!isset($config['routes'])) {
            throw new Exception("Syntax error: field 'routes' is required");
        }
        if (!is_array($config['routes'])) {
            throw new Exception("Syntax error: field 'routes' must be array");
        }
        foreach ($config['routes'] as $route => $params) {
            if (!isset($params['title'])) {
                throw new Exception("Syntax error: field 'title' not found in route '" . $route . "'");
            }
            if (!isset($params['route'])) {
                throw new Exception("Syntax error: field 'route' not found in route '" . $route . "'");
            }
        }
    }

    /**
     * Filter config params
     * 
     * @param array $config
     * @return array
     */
    protected function filterConfig($config) {
        if (!isset($config['title'])) {
            $config['title'] = $config['name'];
        }
        if (!isset($config['priority'])) {
            $config['priority'] = 10;
        }
        return $config;
    }

}

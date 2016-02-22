<?php

namespace stronglab\yii2\dashboard\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use yii\base\Exception;
use yii\data\ArrayDataProvider;

/**
 * ModulesHandler
 *
 * @author strong
 */
class ConfigComponent extends Component {

    /**
     * Non-module dashboard configuration key in configs array 
     */
    const APP_CONFIG_KEY = '_application';

    /**
     * 
     * @var string Default icon for dashboard
     */
    public $glyphiconDefault = 'cog';

    /**
     *
     * @var string Dashboard module ID
     */
    public $dashboardId = 'dashboard';

    /**
     *
     * @var array List available configs
     */
    private $_configs = [];

    /**
     *
     * @var array available routes 
     */
    private $_routes = [];

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
     * Get All dashboard routes
     * 
     * @return array
     */
    public function getRoutes() {
        if (empty($this->_routes)) {
            foreach ($this->_configs as $moduleName => $config) {
                $this->_routes += $this->getRoutesList($config, $moduleName);
            }
        }
        return $this->_routes;
    }

    /**
     * Check is dashboard route
     * 
     * @param string $route
     * @return bool
     */
    public function isDashboardRoute($route) {
        return isset($this->routes[$route]);
    }

    /**
     * Get full route
     * 
     * @param string $route
     * @return string|null
     */
    public function getRoute($route) {
        if ($this->isDashboardRoute($route)) {
            return $this->_routes[$route];
        }
        return null;
    }

    /**
     * Return data provider for bulid dashboard items
     * 
     * @return ArrayDataProvider
     */
    public function getDataProvider() {
        $configs = $this->getConfigs();
        if (empty($configs)) {
            throw new Exception("Configurations not found");
        }
        return new ArrayDataProvider([
            'allModels' => $this->prepareConfig($configs),
        ]);
    }

    /**
     * Prepare config data before output
     * 
     * @param array $configs
     * @return array
     */
    protected function prepareConfig($configs) {
        $result = [];
        foreach ($configs as $config) {
            $result[] = [
                'title' => $config['title'],
                'routes' => $this->createRoutesDataProvider($config['routes']),
            ];
        }
        return $result;
    }

    /**
     * Create dataprovider from config routes
     * 
     * @param array $routes
     * @return ArrayDataProvider
     */
    protected function createRoutesDataProvider($routes) {
        if (empty($routes)) {
            return;
        }
        foreach ($routes as &$route) {
            $route['route'] = isset($this->routes[$route['route']]) ? $this->routes[$route['route']] : $route['route'];
            $route['route'] = $this->dashboardId . '/' . $route['route'];
            $route['icon'] = isset($route['icon']) ? $route['icon'] : $this->glyphiconDefault;
        }
        return new ArrayDataProvider([
            'allModels' => $routes,
        ]);
    }

    /**
     * Get routes list by config
     * 
     * @param array $config
     * @param string $moduleName
     * @return array
     */
    protected function getRoutesList($config, $moduleName) {
        $routes = [];
        foreach ($config['routes'] as $route) {
            $module = $moduleName == self::APP_CONFIG_KEY ? '' : $moduleName . '/';
            $routes[$module . $route['route']] = $module . $route['route'];
            $routes[$route['route']] = $module . $route['route'];
        }
        return $routes;
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

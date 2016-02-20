<?php

namespace stronglab\yii2\dashboard\components;

use Yii;
use yii\base\Component;
use yii\base\Module;

/**
 * ModulesHandler
 *
 * @author strong
 */
class ModulesHandler extends Component {

    /**
     *
     * @var array List availavle modules
     */
    private $_modules = [];

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
    public function setModule(string $moduleName) {
        $module = Yii::$app->getModule($moduleName, false);
        if (is_null($module)) {
            return $this;
        }
        $config = $this->getDashboardConfig($module);
        if (!empty($config)) {
            $this->_modules[$moduleName] = $config;
        }
        return $this;
    }

    /**
     * Get available dashbord modules
     */
    public function getModules() {
        return $this->_modules;
    }

    /**
     * Get dashboard config
     * 
     * @param array $module
     * @return array Description
     */
    protected function getDashboardConfig(Module $module) {
        $path = $module->getBasePath();
        var_dump($path);
        return [];
    }

    /**
     * Validate dashboard config
     * 
     * @param array $config
     * @return bool
     */
    protected function validateConfig($config) {
        
    }

}

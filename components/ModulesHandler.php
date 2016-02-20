<?php

namespace stronglab\yii2\dashboard\components;

use yii\base\Component;

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
    }

    /**
     * Validate and set available module for dashboard
     * 
     * @param string $moduleName
     * @return bool
     */
    public function setModule(string $moduleName) {
        
    }

    /**
     * Get dashboard config
     * 
     * @param array $moduleName
     * @return array|null Description
     */
    protected function checkDashboardConfig($moduleName) {
        
    }

}

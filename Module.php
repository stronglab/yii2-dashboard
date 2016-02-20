<?php

namespace stronglab\yii2\dashboard;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * @author strong
 */
class Module extends \yii\base\Module {

    /**
     * 
     * @var string Alias for module
     */
    public $alias = '@dashboard';

    /**
     *
     * @var array List available module for dashboard
     */
    public $modules = [];

    /**
     * @inheritdoc
     */
    public function init() {

        parent::init();

        // set alias
        $this->setAliases([
            $this->alias => __DIR__,
        ]);

        //set components
        $this->setComponents([
            'config' => [
                'class' => 'stronglab\yii2\dashboard\components\ConfigComponent',
                'modules' => $this->modules,
            ],
        ]);
    }

}
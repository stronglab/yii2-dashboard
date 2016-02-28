<?php

namespace stronglab\dashboard;

/**
 * @author strong
 */
class Module extends \yii\base\Module
{
    /**
     * @var array Allowed roles. Guest by default
     */
    public $roles = ['?'];

    /**
     * @var int dashboard column num
     */
    public $column = 1;

    /**
     *
     * @var string Alias for module
     */
    public $alias = '@dashboard';

    /**
     *
     * @var string Default icon for dashboard
     */

    public $glyphiconDefault = 'cog';

    /**
     *
     * @var array List available module for dashboard
     */
    public $modules = [];

    /**
     * @inheritdoc
     */
    public function init()
    {

        parent::init();

        // set alias
        $this->setAliases([
            $this->alias => __DIR__,
        ]);

        //set components
        $this->setComponents([
            'config' => [
                'class' => 'stronglab\dashboard\components\ConfigComponent',
                'modules' => $this->modules,
                'glyphiconDefault' => $this->glyphiconDefault,
                'dashboardId' => $this->id,
            ],
        ]);
    }

}

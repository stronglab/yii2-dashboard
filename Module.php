<?php

namespace stronglab\dashboard;

/**
 * @author strong
 */

use Yii;

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
        $this->registerTranslations();
    }

    /**
     * Registeration translation files.
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['stronglab/dashboard/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'forceTranslation' => true,
            'basePath' => '@stronglab/dashboard/messages',
            'fileMap' => [
                'stronglab/dashboard/core' => 'core.php',
            ],
        ];
    }

    /**
     * Translates a message to the specified language.
     *
     * @param string $message the message to be translated.
     * @param array $params the parameters that will be used to replace the corresponding placeholders in the message.
     * @param string $language the language code (e.g. `en-US`, `en`). If this is null, the current application language
     * will be used.
     * @return string
     */
    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('stronglab/dashboard/core', $message, $params, $language);
    }

}

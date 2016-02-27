<?php

namespace stronglab\dashboard\components;

use yii\base\BootstrapInterface;

/**
 * Bootstrap
 *
 * @author strong
 */
class Bootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => 'stronglab\dashboard\components\UrlRule'
            ],
        ]);
    }

}

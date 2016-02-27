<?php
/**
 * DashboardAssets
 *
 * @author strong
 */

namespace stronglab\dashboard\assets;

use yii\web\AssetBundle;

class DashboardAssets extends AssetBundle
{
    
    public $css = [
        'css/dashboard.css',
    ];
    public $js = [
        'js/dashboard.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    
    public function init() {
        $this->sourcePath = '@stronglab/dashboard/web';
        parent::init();
    }
}

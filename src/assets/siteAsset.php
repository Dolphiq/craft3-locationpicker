<?php
/**
 * Created by PhpStorm.
 * User: lucasweijers
 * Date: 16-08-17
 * Time: 14:58
 */
namespace plugins\dolphiq\locationPicker\assets;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use yii\web\JqueryAsset;
use yii\web\View;

class siteAsset extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@vendor/dolphiq/craft3-locationpicker/src/resources';

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/map.js',
        ];

        $this->jsOptions = [
            'position' => View::POS_HEAD,
        ];

        $this->css = [
            'css/map.css',
        ];

        parent::init();
    }
}
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

class appAsset extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@vendor/dolphiq/craft3-locationpicker/src/resources-app';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/MapModal.js',
            'js/field.js',
            'js/map.js',
        ];

        $this->css = [
            'css/modal.css',
        ];

        parent::init();
    }
}
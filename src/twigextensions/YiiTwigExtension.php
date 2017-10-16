<?php

namespace plugins\dolphiq\locationPicker\twigextensions;

use craft\helpers\UrlHelper;

use plugins\dolphiq\form\models\vacancyForm;
use plugins\dolphiq\form\controllers\MainController;
use plugins\dolphiq\locationPicker\assets\siteAsset;
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

use Craft;
use ReflectionProperty;
use yii\base\Module;
use yii\web\View;
use yii\web\YiiAsset;

class YiiTwigExtension extends Twig_Extension
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'DolphiqLocationPicker';
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('dolphiqMap', [$this, 'dolphiqMap']),
        ];
    }


    //@TODO Enable the use of this function for multiple maps. So we have to generate a unique ID for the div and in JS (See the iconpicker plugin on how to do that)
    public function dolphiqMap($locations = [], $width, $height){

        $locationsJS = "var dolphiqMap_locations = ".json_encode($locations).";";
        $script = <<<JS


JS;

        Craft::$app->view->registerAssetBundle(siteAsset::className());
        Craft::$app->view->registerJs($locationsJS, View::POS_HEAD);
        //Craft::$app->view->registerJs($script, View::POS_HEAD);
        Craft::$app->view->registerJsFile('https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js');
        Craft::$app->view->registerJsFile('https://maps.googleapis.com/maps/api/js?key='.\plugins\dolphiq\locationPicker\Plugin::getInstance()->getSettings()->apiKey.'&callback=dolphiqMap', ['defer' => 'defer', 'async' => 'async']);

        return '<div class="dolphiqMap" id="dolphiqMap" style="width: '.$width.';height: '.$height.'; display: block;"></div>';

    }
}

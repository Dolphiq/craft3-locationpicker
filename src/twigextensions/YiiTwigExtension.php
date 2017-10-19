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

    private $defaultOptions = [
        'width' => '100%',
        'height' => '500px',
    ];

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
    public function dolphiqMap($locations = [], $options = []){

        $options = array_merge($this->defaultOptions, $options);

        if(!empty($locations) && is_array($locations) && !empty(array_filter($locations))) {
            $uniqueID = 'dolphiqlocation-' . uniqid() . '-' . time();
            $json_locations = json_encode($locations);

            $script = <<<JS
loadDolphiqMap('$uniqueID', $json_locations);
JS;

            Craft::$app->view->registerAssetBundle(siteAsset::className());
            Craft::$app->view->registerJs($script, View::POS_HEAD);
            Craft::$app->view->registerJsFile('https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js');
            Craft::$app->view->registerJsFile('https://maps.googleapis.com/maps/api/js?key=' . \plugins\dolphiq\locationPicker\Plugin::getInstance()->getSettings()->apiKey . '&callback=initDolphiqMap', ['defer' => 'defer', 'async' => 'async']);

            return '<div class="dolphiqMap" id="'.$uniqueID.'" style="width: ' . $options['width'] . ';height: ' . $options['height'] . '; display: block;"></div>';        }
    }
}

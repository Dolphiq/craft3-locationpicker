<?php

namespace plugins\dolphiq\locationPicker\models;

use Craft;
use craft\base\Model;
use plugins\dolphiq\locationPicker\assets\siteAsset;

/**
 * Created by PhpStorm.
 * User: lucasweijers
 * Date: 17-08-17
 * Time: 13:53
 */

class LocationModel extends Model{

    public $lat = "";
    public $long = "";
    public $address = "";

    private $uniqueId;

    public function rules()
    {
        return [
            [['address', 'lat', 'long'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'address' => Craft::t('site', 'Address'),
        ];
    }

    public function getMap(){

        // Load assets for map. Assetmanager will determine if they are already loaded
        $this->registerAssets();

        $uniqueId = $this->getUniqueId();
        $json_locations = json_encode([$this->attributes]);

        $script = <<<SCRIPT
loadDolphiqMap('$uniqueId', $json_locations);
SCRIPT;

        Craft::$app->view->registerJs($script);


        return '<div id="'.$uniqueId.'" class="dolphiqMap"></div>';
    }

    public function getUniqueId(){
        if(empty($this->uniqueId)){
            $this->uniqueId = 'dolphiq-craft3-locationpicker-'.uniqid().'-'.time();
        }

        return $this->uniqueId;
    }

    private function registerAssets(){
        Craft::$app->view->registerAssetBundle(siteAsset::className());
        Craft::$app->view->registerJsFile('https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js');
        Craft::$app->view->registerJsFile('https://maps.googleapis.com/maps/api/js?key=' . \plugins\dolphiq\locationPicker\Plugin::getInstance()->getSettings()->apiKey . '&callback=initDolphiqMap', ['defer' => 'defer', 'async' => 'async']);
    }
}
<?php

namespace plugins\dolphiq\locationPicker\models;

use Craft;
use craft\base\Model;

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
}
<?php
/**
 * Created by PhpStorm.
 * User: lucasweijers
 * Date: 16-08-17
 * Time: 13:51
 */

namespace plugins\dolphiq\locationPicker\models;


use craft\base\Model;

class Settings extends Model
{
    public $apiKey = '';

    public function rules()
    {
        return [
            [['apiKey'], 'required'],
        ];
    }
}
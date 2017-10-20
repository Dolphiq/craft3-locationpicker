<?php
/**
 * Created by PhpStorm.
 * User: lucasweijers
 * Date: 20-10-17
 * Time: 15:14
 */

namespace plugins\dolphiq\locationPicker\models;

use craft\base\Model;


class snazzyMaps extends Model {

    private $apiKey = 'c01c831f-1ffd-4bed-858a-dcd5e0ea5289';
    private $requestUrl = 'https://snazzymaps.com/explore.json';

    public function getStyles(){
        $query = [];

        return $this->request();
    }

    private function request($q = []){
        //Add api key to the query. This is the only parameter that is required
        $q = array_merge($q, ['key' => $this->apiKey]);

        // Build query string
        $query = http_build_query($q);

        // Build request string
        $request = $this->requestUrl . '?' . $query;

        $response = file_get_contents($request);
        $result = json_decode($response);

        return $result;
    }
}
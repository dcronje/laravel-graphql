<?php
namespace App\Lib;

use Exception;

/**
 * [GoogleGeo class for geocoding and reverse geocoding using google services]
 * Author: Drew Cronje
 * Contact: drew@silvertree.services
 * Date: 02-2018
 */

class GoogleGeo
{

    /**
     * [$unitType the unit type metric or imperial]
     * @type {String}
     */
    private $unitType = 'metric';

    /**
     * [$host the host server]
     * @type {String}
     */
    private $host = 'maps.googleapis.com';

    /**
     * [$geocodePath the geocode endpoint]
     * @type {String}
     */
    private $geocodePath = '/maps/api/geocode/json';

    /**
     * [$timezonePath the timezone endpoint]
     * @type {String}
     */
    private $timezonePath = '/maps/api/timezone/json';

    /**
     * [$key the Google API key]
     * @type {String}
     */
    private $key = '';

    /**
     * [__construct constructor function]
     * @param       {String} $unitType='metric' the unit type
     * @constructor
     * @return      {GoogleGeo}                 The GoogleGeo instance
     */
    function __construct($unitType = 'metric') {
        $this->unitType = $unitType;
        $this->key = config('google.apikey');
    }

    /**
     * [earthRadius get the earth radius based on unit type]
     * @return {Integer} The earth's radius
     */
    private function earthRadius()
    {
        if ($this->unitType == 'imperial') {
            return 3959;
        }
        return 6371;
    }

    /**
     * [geocode get a location or list of locations based on a set of coordinates]
     * @param  {Double}  $latitude                                  the latitude of the coordinates
     * @param  {Double}  $longitude                                 the longitude of the coordinates
     * @param  {Boolean} $multi=true                                return multiple result or the best matched location
     * @param  {Boolean} $raw=false                                 return raw data
     * @return {Array<Array<String, Any>> | Array<String, Any>}     the locations
     */
    public function geocode($latitude, $longitude, $multi = true, $raw = false)
    {
        $url = "https://".$this->host.$this->geocodePath."?latlng=".$latitude.",".$longitude."&sensor=false&key=".$this->key;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        $data = json_decode($result);
        $geoData = $this->parseData($data, $multi);
        return $geoData;
    }

    /**
     * [reverseGeocode get a location or list of locations based on an address]
     * @param  {String}  $address                                   the address to lookup
     * @param  {Boolean} $multi=true                                return multiple result or the best matched location
     * @param  {Boolean} $raw=false                                 return raw data
     * @return {Array<Array<String, Any>> | Array<String, Any>}     the locations
     */
    public function reverseGeocode($address, $multi = true, $raw = false)
    {
        $url = "https://".$this->host.$this->geocodePath."?address=".urlencode($address)."&sensor=false&key=".$this->key;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        $data = json_decode($result);
        $geoData = $this->parseData($data, $multi);
        return $geoData;
    }

    /**
     * [getTimezone get the timezone for a location]
     * @param  {Double}  $latitude        the latitude of the coordinates
     * @param  {Double}  $longitude       the longitude of the coordinates
     * @return {Array<String, Any>}                   Timezone information
     */
    private function getTimezone($latitude, $longitude)
    {
        $url = "https://".$this->host.$this->timezonePath."?location=".$latitude.",".$longitude."&timestamp=".time()."&sensor=false&key=".$this->key;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        $data = json_decode($result);
        if (!$data) {
            throw new Exception('Timezone lookup failed with error: NO_DATA');
        } else if ($data->status != 'OK') {
            throw new Exception('Timezone lookup failed with error: '.$data->status);
        }
        return $data;
    }

    /**
     * [parseData parse the data returned by google and make it more readable]
     * @param  {Object<String, Any>}                              $data             google data
     * @param  {Boolean}                                          $returnMultiple   return multiple results
     * @return {Array<Array<String, Any>> | Array<String, Any>}                     the result
     */
    private function parseData($data, $returnMultiple)
    {
        if (!$data) {
            throw new Exception('Geolocation lookup failed with error: NO_DATA');
        } else if ($data->status != 'OK') {
            throw  new Exception('Geolocation lookup failed with error: '.$data->status);
        }
        $geoData = [];
        for ($z = 0; $z < count($data->results); $z++) {
            $addressReturn = (object)[
                'areaName' => '',
                'center' => (object)[
                    'latitude' => $data->results[$z]->geometry->location->lat,
                    'longitude' => $data->results[$z]->geometry->location->lng,
                ],
                'streetAddress' => $data->results[$z]->formatted_address,
            ];
            // console->log(JSON->stringify($data->results[$z], null, 2));
            // process->exit(0);
            for ($x = 0; $x < count($data->results[$z]->address_components); $x++) {
                for ($y = 0; $y < count($data->results[$z]->address_components[$x]->types); $y++) {
                    if ($data->results[$z]->address_components[$x]->types[$y] == 'administrative_area_level_1') {
                        if (!isset($addressReturn->regionName) || empty($addressReturn->regionName)) {
                            $addressReturn->{'regionName'} = $data->results[$z]->address_components[$x]->long_name;
                        }
                    } else if ($data->results[$z]->address_components[$x]->types[$y] == 'administrative_area_level_2') {
                        if (!isset($addressReturn->countyName) || empty($addressReturn->countyName)) {
                            $addressReturn->{'countyName'} = $data->results[$z]->address_components[$x]->long_name;
                        }
                    } else if ($data->results[$z]->address_components[$x]->types[$y] == 'locality') {
                        if (!isset($addressReturn->cityName) || empty($addressReturn->cityName)) {
                            $addressReturn->{'cityName'} = $data->results[$z]->address_components[$x]->long_name;
                        }
                    } else if ($data->results[$z]->address_components[$x]->types[$y] == 'street_number') {
                        if (!isset($addressReturn->address) || empty($addressReturn->address)) {
                            $addressReturn->{'address'} = '';
                        } else {
                            $addressReturn->address .= ' ';
                        }
                        $addressReturn->address .= $data->results[$z]->address_components[$x]->long_name;
                    } else if ($data->results[$z]->address_components[$x]->types[$y] == 'route') {
                        $addressReturn->routeName = $data->results[$z]->address_components[$x]->long_name;
                        if (!isset($addressReturn->address) || empty($addressReturn->address)) {
                            $addressReturn->{'address'} = '';
                        } else {
                            $addressReturn->address .= ' ';
                        }
                        $addressReturn->address .= $data->results[$z]->address_components[$x]->long_name;
                    } else if ($data->results[$z]->address_components[$x]->types[$y] == 'premise') {
                        if (!isset($addressReturn->address) || empty($addressReturn->address)) {
                            $addressReturn->{'address'} = '';
                        } else {
                            $addressReturn->address .= ' ';
                        }
                        $addressReturn->address .= $data->results[$z]->address_components[$x]->long_name;
                    } else if ($data->results[$z]->address_components[$x]->types[$y] == 'neighborhood') {
                        if (!isset($addressReturn->neighborhood) || empty($addressReturn->neighborhood)) {
                            $addressReturn->{'neighborhood'} = $data->results[$z]->address_components[$x]->long_name;
                        }
                    } else if ($data->results[$z]->address_components[$x]->types[$y] == 'postal_code') {
                        if (!isset($addressReturn->zip) || empty($addressReturn->zip)) {
                            $addressReturn->{'zip'} = $data->results[$z]->address_components[$x]->long_name;
                        }
                    } else if ($data->results[$z]->address_components[$x]->types[$y] == 'country') {
                        if (!isset($addressReturn->countryName) || empty($addressReturn->countryName)) {
                            $addressReturn->{'countryName'} = $data->results[$z]->address_components[$x]->long_name;
                        }
                    } else if ($data->results[$z]->address_components[$x]->types[$y] == 'sublocality') {
                        if (!isset($addressReturn->areaName) || empty($addressReturn->areaName)) {
                            $addressReturn->{'areaName'} = $data->results[$z]->address_components[$x]->long_name;
                        }
                    }
                }
            }
            /*
            if ($data->results[$z]->geometry->bounds) {
                $addressReturn->northeast = {
                    latitude: $data->results[$z]->geometry->bounds->northeast->lat,
                    longitude: $data->results[$z]->geometry->bounds->northeast->lng
                };
                $addressReturn->southwest = {
                    latitude: $data->results[$z]->geometry->bounds->southwest->lat,
                    longitude: $data->results[$z]->geometry->bounds->southwest->lng
                };
            } else if($data->results[0]->geometry->viewport) {
                $addressReturn->northeast = {
                    latitude: $data->results[$z]->geometry->viewport->northeast->lat,
                    longitude: $data->results[$z]->geometry->viewport->northeast->lng
                };
                $addressReturn->southwest = {
                    latitude: $data->results[$z]->geometry->viewport->southwest->lat,
                    longitude: $data->results[$z]->geometry->viewport->southwest->lng
                };
            }
            */
            $add = true;
            if (!$addressReturn->countryName) {
                $add = false;
            }
            if (!$addressReturn->address) {
                $add = false;
            }
            if ($add) {
                $geoData[] = $addressReturn;
            }
        }
        if (!count($geoData)) {
            throw new Exception('Geolocation lookup failed with error: NO_RESULTS');
        }
        if ($returnMultiple) {
            foreach ($geoData as &$geoItem) {
                $geoItem->timezone = $this->getTimezone($geoItem->center->latitude, $geoItem->center->longitude);
            }
            return $geoData;
        } else {
            $location = $geoData[0];
            $location->timezone = $this->getTimezone($location->center->latitude, $location->center->longitude);
            return $location;
        }
    }

}

<?php
namespace App\Lib;

use App\Country;
use App\Region;
use App\City;
use App\Area;
use App\Location;

/**
 * [Locations a locations helper object that works in conjunction with GoogleGeo in order to serailize gecoded data]
 * Author: Drew Cronje
 * Contact: drew@silvertree.services
 * Date: 02-2018
 */

class Locations
{

    /**
     * [process process the data returned by google in order to serialize]
     * @param  {Object<String, Any>}          $data   the object returned by GoogleGeo
     * @return {Location}                             a serialized location object
     */
    static function process($data, $save = true)
    {
        $country = self::saveCountry($data);
        $region = self::saveRegion($data, $country);
        $city = self::saveCity($data, $country, $region);
        $area = self::saveArea($data, $country, $region, $city);
        $location = null;
        if ($save) {
          $location = new Location([
              'name' => $data->name,
              'building' => $data->building,
              'address' => $data->address,
              'longitude' => $data->center->longitude,
              'latitude' => $data->center->latitude,
              'countryId' => $country->id,
              'regionId' => $region->id,
              'cityId' => !empty($city) ? $city->id : null,
              'areaId' => !empty($area) ? $area->id : null,
              'timezone' => $data->timezone->timeZoneId,
          ]);
          $location->save();
        } else {
          return (object)[
              'address' => $data->address,
              'longitude' => $data->center->longitude,
              'latitude' => $data->center->latitude,
              'countryId' => $country->id,
              'regionId' => $region->id,
              'cityId' => !empty($city) ? $city->id : null,
              'areaId' => !empty($area) ? $area->id : null,
              'timezone' => $data->timezone->timeZoneId,
          ];
        }
        return $location;
    }

    /**
     * [saveCountry save country information to database]
     * @param  {Object<Srting, Any>} $data  GoogleGeo Object
     * @return {Eloquent<Country>}          The serialized country object
     */
    static function saveCountry($data)
    {
        $country = Country::where('name', 'LIKE', $data->countryName)->first();
        if (!$country) {
            $country = new Country([
                'name' => $data->countryName,
            ]);
            $country->save();
        }
        return $country;
    }

    /**
     * [saveRegion save region information to database]
     * @param  {Object<Srting, Any>}    $data       GoogleGeo Object
     * @param  {Eloquent<Country>}      $country    A serialized country object
     * @return {Eloquent<Region>}                   The serialized region object
     */
    static function saveRegion($data, $country)
    {
        $region = Region::where('name', 'LIKE', $data->regionName)
            ->where('countryId', $country->id)
            ->first();
        if (!$region) {
            $region = new Region([
                'name' => $data->regionName,
                'countryId' => $country->id,
            ]);
            $region->save();
        }
        return $region;
    }

    /**
     * [saveCity save city information to database]
     * @param  {Object<Srting, Any>}    $data       GoogleGeo Object
     * @param  {Eloquent<Country>}      $country    A serialized country object
     * @param  {Eloquent<Region>}       $region     A serialized region object
     * @return {Eloquent<City>}                     The serialized city object
     */
    static function saveCity($data, $country, $region)
    {
        if (!empty($data->cityName)) {
            $city = City::where('name', 'LIKE', $data->cityName)
                ->where('countryId', $country->id)
                ->where('regionId', $region->id)
                ->first();
            if (!$city) {
                $city = new City([
                    'name' => $data->cityName,
                    'countryId' => $country->id,
                    'regionId' => $region->id,
                ]);
                $city->save();
            }
            return $city;
        }
        return null;
    }

    /**
     * [saveCity save area information to database]
     * @param  {Object<Srting, Any>}    $data       GoogleGeo Object
     * @param  {Eloquent<Country>}      $country    A serialized country object
     * @param  {Eloquent<Region>}       $region     A serialized region object
     * @param  {Eloquent<City>}         $city       A serialized city object
     * @return {Eloquent<Area>}                     The serialized area object
     */
    static function saveArea($data, $country, $region, $city) {
        if (!empty($city) && !empty($data->areaName)) {
            $area = Area::where('name', 'LIKE', $data->areaName)
                ->where('countryId', $country->id)
                ->where('regionId', $region->id)
                ->where('cityId', $city->id)
                ->first();
            if (!$area) {
                $area = new Area([
                    'name' => $data->areaName,
                    'countryId' => $country->id,
                    'regionId' => $region->id,
                    'cityId' => $city->id,
                ]);
                $area->save();
            }
            return $area;
        }
        return null;
    }

}

<?php
namespace App\GraphQL\City;

use App\GraphQL\Exporter;

class CityExporter implements Exporter {

    static function getTypes()
    {
        return [
            'App\GraphQL\City\Types\CityType',
            'App\GraphQL\City\Types\CityListDirectionEnumType',
            'App\GraphQL\City\Types\CityListFiltersType',
            'App\GraphQL\City\Types\CityListOrderEnumType',
            'App\GraphQL\City\Types\CityListOrderType',
            'App\GraphQL\City\Types\CityListType',
            'App\GraphQL\City\Types\CityAddInputType',
            'App\GraphQL\City\Types\CityUpdateInputType',
        ];
    }

    static function getQueries()
    {
        return [
            'App\GraphQL\City\Queries\AllCitiesQuery',
            'App\GraphQL\City\Queries\CityCountQuery',
            'App\GraphQL\City\Queries\OneCityQuery',
        ];
    }

    static function getMutations()
    {
        return [
            'App\GraphQL\City\Mutations\AddCityMutation',
            'App\GraphQL\City\Mutations\RemoveCityMutation',
            'App\GraphQL\City\Mutations\UpdateCityMutation',
        ];
    }

}
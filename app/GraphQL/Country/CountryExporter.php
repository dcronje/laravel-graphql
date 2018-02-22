<?php
namespace App\GraphQL\Country;

use App\GraphQL\Exporter;

class CountryExporter implements Exporter {

    static function getTypes()
    {
        return [
            'App\GraphQL\Country\Types\CountryType',
            'App\GraphQL\Country\Types\CountryListDirectionEnumType',
            'App\GraphQL\Country\Types\CountryListFiltersType',
            'App\GraphQL\Country\Types\CountryListOrderEnumType',
            'App\GraphQL\Country\Types\CountryListOrderType',
            'App\GraphQL\Country\Types\CountryListType',
            'App\GraphQL\Country\Types\CountryAddInputType',
            'App\GraphQL\Country\Types\CountryUpdateInputType',
        ];
    }

    static function getQueries()
    {
        return [
            'App\GraphQL\Country\Queries\AllCountriesQuery',
            'App\GraphQL\Country\Queries\CountryCountQuery',
            'App\GraphQL\Country\Queries\OneCountryQuery',
        ];
    }

    static function getMutations()
    {
        return [
            'App\GraphQL\Country\Mutations\AddCountryMutation',
            'App\GraphQL\Country\Mutations\RemoveCountryMutation',
            'App\GraphQL\Country\Mutations\UpdateCountryMutation',
        ];
    }

}
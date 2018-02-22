<?php
namespace App\GraphQL\Location;

use App\GraphQL\Exporter;

class LocationExporter implements Exporter {

    static function getTypes()
    {
        return [
            'App\GraphQL\Location\Types\LocationType',
            'App\GraphQL\Location\Types\LocationListDirectionEnumType',
            'App\GraphQL\Location\Types\LocationListFiltersType',
            'App\GraphQL\Location\Types\LocationListOrderEnumType',
            'App\GraphQL\Location\Types\LocationListOrderType',
            'App\GraphQL\Location\Types\LocationListType',
            'App\GraphQL\Location\Types\LocationAddInputType',
            'App\GraphQL\Location\Types\LocationUpdateInputType',
        ];
    }

    static function getQueries()
    {
        return [
            'App\GraphQL\Location\Queries\AllLocationsQuery',
            'App\GraphQL\Location\Queries\LocationCountQuery',
            'App\GraphQL\Location\Queries\OneLocationQuery',
        ];
    }

    static function getMutations()
    {
        return [
            'App\GraphQL\Location\Mutations\AddLocationMutation',
            'App\GraphQL\Location\Mutations\RemoveLocationMutation',
            'App\GraphQL\Location\Mutations\UpdateLocationMutation',
        ];
    }

}

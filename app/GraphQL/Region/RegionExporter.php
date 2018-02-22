<?php
namespace App\GraphQL\Region;

use App\GraphQL\Exporter;

class RegionExporter implements Exporter {

    static function getTypes()
    {
        return [
            'App\GraphQL\Region\Types\RegionType',
            'App\GraphQL\Region\Types\RegionListDirectionEnumType',
            'App\GraphQL\Region\Types\RegionListFiltersType',
            'App\GraphQL\Region\Types\RegionListOrderEnumType',
            'App\GraphQL\Region\Types\RegionListOrderType',
            'App\GraphQL\Region\Types\RegionListType',
            'App\GraphQL\Region\Types\RegionAddInputType',
            'App\GraphQL\Region\Types\RegionUpdateInputType',
        ];
    }

    static function getQueries()
    {
        return [
            'App\GraphQL\Region\Queries\AllRegionsQuery',
            'App\GraphQL\Region\Queries\RegionCountQuery',
            'App\GraphQL\Region\Queries\OneRegionQuery',
        ];
    }

    static function getMutations()
    {
        return [
            'App\GraphQL\Region\Mutations\AddRegionMutation',
            'App\GraphQL\Region\Mutations\RemoveRegionMutation',
            'App\GraphQL\Region\Mutations\UpdateRegionMutation',
        ];
    }

}
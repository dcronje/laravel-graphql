<?php
namespace App\GraphQL\Area;

use App\GraphQL\Exporter;

class AreaExporter implements Exporter {

    static function getTypes()
    {
        return [
            'App\GraphQL\Area\Types\AreaType',
            'App\GraphQL\Area\Types\AreaListDirectionEnumType',
            'App\GraphQL\Area\Types\AreaListFiltersType',
            'App\GraphQL\Area\Types\AreaListOrderEnumType',
            'App\GraphQL\Area\Types\AreaListOrderType',
            'App\GraphQL\Area\Types\AreaListType',
            'App\GraphQL\Area\Types\AreaAddInputType',
            'App\GraphQL\Area\Types\AreaUpdateInputType',
        ];
    }

    static function getQueries()
    {
        return [
            'App\GraphQL\Area\Queries\AllAreasQuery',
            'App\GraphQL\Area\Queries\AreaCountQuery',
            'App\GraphQL\Area\Queries\OneAreaQuery',
        ];
    }

    static function getMutations()
    {
        return [
            'App\GraphQL\Area\Mutations\AddAreaMutation',
            'App\GraphQL\Area\Mutations\RemoveAreaMutation',
            'App\GraphQL\Area\Mutations\UpdateAreaMutation',
        ];
    }

}
<?php
namespace App\GraphQL\Coordinate;

use App\GraphQL\Exporter;

class CoordinateExporter implements Exporter {

    static function getTypes()
    {
        return [
            'App\GraphQL\Coordinate\Types\CoordinateType',
        ];
    }

    static function getQueries()
    {
        return [
        ];
    }

    static function getMutations()
    {
        return [
        ];
    }

}
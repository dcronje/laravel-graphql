<?php
namespace App\GraphQL\Location\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Location;
use App\GraphQL\Location\LocationHelper;

class AllLocationsQuery extends Query
{

    protected $attributes = [
        'name' => 'allLocations'
    ];

    public function type()
    {
        return GraphQL::type('LocationList');
    }

    public function args()
    {
        return LocationHelper::allLocationsArgs();
    }

    public function resolve($root, $args)
    {
        return LocationHelper::allLocationsResolver($root, $args);
    }

}

<?php
namespace App\GraphQL\Location\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Location;
use App\GraphQL\Location\LocationHelper;

class OneLocationQuery extends Query
{

    protected $attributes = [
        'name' => 'oneLocation'
    ];

    public function type()
    {
        return GraphQL::type('Location');
    }

    public function args()
    {
        return LocationHelper::oneLocationArgs();
    }

    public function resolve($root, $args)
    {
        return LocationHelper::oneLocationResolver($root, $args);
    }

}

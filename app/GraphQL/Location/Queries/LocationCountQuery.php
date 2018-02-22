<?php
namespace App\GraphQL\Location\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Location;
use App\GraphQL\Location\LocationHelper;

class LocationCountQuery extends Query
{

    protected $attributes = [
        'name' => 'locationCount'
    ];

    public function type()
    {
        return Type::nonNull(Type::int());
    }

    public function args()
    {
        return LocationHelper::locationCountArgs();
    }

    public function resolve($root, $args)
    {
        return LocationHelper::locationCountResolver($root, $args);
    }

}

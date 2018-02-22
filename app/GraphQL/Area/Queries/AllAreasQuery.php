<?php
namespace App\GraphQL\Area\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Area;
use App\GraphQL\Area\AreaHelper;

class AllAreasQuery extends Query
{

    protected $attributes = [
        'name' => 'allAreas'
    ];

    public function type()
    {
        return GraphQL::type('AreaList');
    }

    public function args()
    {
        return AreaHelper::allAreasArgs();
    }

    public function resolve($root, $args)
    {
        return AreaHelper::allAreasResolver($root, $args);
    }

}

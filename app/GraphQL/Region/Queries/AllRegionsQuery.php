<?php
namespace App\GraphQL\Region\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Region;
use App\GraphQL\Region\RegionHelper;

class AllRegionsQuery extends Query
{

    protected $attributes = [
        'name' => 'allRegions'
    ];

    public function type()
    {
        return GraphQL::type('RegionList');
    }

    public function args()
    {
        return RegionHelper::allRegionsArgs();
    }

    public function resolve($root, $args)
    {
        return RegionHelper::allRegionsResolver($root, $args);
    }

}

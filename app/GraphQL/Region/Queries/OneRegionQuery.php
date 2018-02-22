<?php
namespace App\GraphQL\Region\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Region;
use App\GraphQL\Region\RegionHelper;

class OneRegionQuery extends Query
{

    protected $attributes = [
        'name' => 'oneRegion'
    ];

    public function type()
    {
        return GraphQL::type('Region');
    }

    public function args()
    {
        return RegionHelper::oneRegionArgs();
    }

    public function resolve($root, $args)
    {
        return RegionHelper::oneRegionResolver($root, $args);
    }

}

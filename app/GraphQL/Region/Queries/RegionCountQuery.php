<?php
namespace App\GraphQL\Region\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Region;
use App\GraphQL\Region\RegionHelper;

class RegionCountQuery extends Query
{

    protected $attributes = [
        'name' => 'regionCount'
    ];

    public function type()
    {
        return Type::nonNull(Type::int());
    }

    public function args()
    {
        return RegionHelper::regionCountArgs();
    }

    public function resolve($root, $args)
    {
        return RegionHelper::regionCountResolver($root, $args);
    }

}

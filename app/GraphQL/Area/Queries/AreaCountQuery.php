<?php
namespace App\GraphQL\Area\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Area;
use App\GraphQL\Area\AreaHelper;

class AreaCountQuery extends Query
{

    protected $attributes = [
        'name' => 'areaCount'
    ];

    public function type()
    {
        return Type::nonNull(Type::int());
    }

    public function args()
    {
        return AreaHelper::areaCountArgs();
    }

    public function resolve($root, $args)
    {
        return AreaHelper::areaCountResolver($root, $args);
    }

}

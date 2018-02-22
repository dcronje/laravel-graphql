<?php
namespace App\GraphQL\City\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\City;
use App\GraphQL\City\CityHelper;

class CityCountQuery extends Query
{

    protected $attributes = [
        'name' => 'cityCount'
    ];

    public function type()
    {
        return Type::nonNull(Type::int());
    }

    public function args()
    {
        return CityHelper::cityCountArgs();
    }

    public function resolve($root, $args)
    {
        return CityHelper::cityCountResolver($root, $args);
    }

}

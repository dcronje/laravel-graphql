<?php
namespace App\GraphQL\City\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\City;
use App\GraphQL\City\CityHelper;

class OneCityQuery extends Query
{

    protected $attributes = [
        'name' => 'oneCity'
    ];

    public function type()
    {
        return GraphQL::type('City');
    }

    public function args()
    {
        return CityHelper::oneCityArgs();
    }

    public function resolve($root, $args)
    {
        return CityHelper::oneCityResolver($root, $args);
    }

}

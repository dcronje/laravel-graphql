<?php
namespace App\GraphQL\City\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\City;
use App\GraphQL\City\CityHelper;

class AllCitiesQuery extends Query
{

    protected $attributes = [
        'name' => 'allCities'
    ];

    public function type()
    {
        return GraphQL::type('CityList');
    }

    public function args()
    {
        return CityHelper::allCitiesArgs();
    }

    public function resolve($root, $args)
    {
        return CityHelper::allCitiesResolver($root, $args);
    }

}

<?php
namespace App\GraphQL\Country\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Country;
use App\GraphQL\Country\CountryHelper;

class OneCountryQuery extends Query
{

    protected $attributes = [
        'name' => 'oneCountry'
    ];

    public function type()
    {
        return GraphQL::type('Country');
    }

    public function args()
    {
        return CountryHelper::oneCountryArgs();
    }

    public function resolve($root, $args)
    {
        return CountryHelper::oneCountryResolver($root, $args);
    }

}

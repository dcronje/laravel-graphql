<?php
namespace App\GraphQL\Country\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Country;
use App\GraphQL\Country\CountryHelper;

class AllCountriesQuery extends Query
{

    protected $attributes = [
        'name' => 'allCountries'
    ];

    public function type()
    {
        return GraphQL::type('CountryList');
    }

    public function args()
    {
        return CountryHelper::allCountriesArgs();
    }

    public function resolve($root, $args)
    {
        return CountryHelper::allCountriesResolver($root, $args);
    }

}

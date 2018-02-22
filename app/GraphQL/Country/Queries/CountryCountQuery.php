<?php
namespace App\GraphQL\Country\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Country;
use App\GraphQL\Country\CountryHelper;

class CountryCountQuery extends Query
{

    protected $attributes = [
        'name' => 'countryCount'
    ];

    public function type()
    {
        return Type::nonNull(Type::int());
    }

    public function args()
    {
        return CountryHelper::countryCountArgs();
    }

    public function resolve($root, $args)
    {
        return CountryHelper::countryCountResolver($root, $args);
    }

}

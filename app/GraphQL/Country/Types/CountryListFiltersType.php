<?php
namespace App\GraphQL\Country\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class CountryListFiltersType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CountryListFilters',
        'description' => 'Filters for country list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The countries name',
            ],
            'minCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The countries minimum creation time',
            ],
            'maxCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The countries maximum creation time',
            ],
            'minUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The countries minimum update time',
            ],
            'maxUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The countries maximum update time',
            ],
        ];
    }

}

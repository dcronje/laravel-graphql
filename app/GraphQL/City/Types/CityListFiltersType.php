<?php
namespace App\GraphQL\City\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class CityListFiltersType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CityListFilters',
        'description' => 'Filters for city list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The cities name',
            ],
            'minCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The cities minimum creation time',
            ],
            'maxCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The cities maximum creation time',
            ],
            'minUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The cities minimum update time',
            ],
            'maxUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The cities maximum update time',
            ],
        ];
    }

}

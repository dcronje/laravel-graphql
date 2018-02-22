<?php
namespace App\GraphQL\City\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CityListType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CityList',
        'description' => 'A list of cities',
    ];

    public function fields()
    {
        return [
            'list' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('City'))),
                'description' => 'The items',
            ],
            'count' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The total count of items',
            ],
            'skip' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The offset',
            ],
            'limit' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The limit',
            ],
        ];
    }

}

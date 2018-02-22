<?php
namespace App\GraphQL\Area\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class AreaListType extends GraphQLType
{

    protected $attributes = [
        'name' => 'AreaList',
        'description' => 'A list of areas',
    ];

    public function fields()
    {
        return [
            'list' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Area'))),
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

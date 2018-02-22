<?php
namespace App\GraphQL\Location\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class LocationListType extends GraphQLType
{

    protected $attributes = [
        'name' => 'LocationList',
        'description' => 'A list of locations',
    ];

    public function fields()
    {
        return [
            'list' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Location'))),
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

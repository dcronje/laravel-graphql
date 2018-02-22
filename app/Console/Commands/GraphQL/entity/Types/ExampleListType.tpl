<?php
namespace App\GraphQL\Example\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class ExampleListType extends GraphQLType
{

    protected $attributes = [
        'name' => 'ExampleList',
        'description' => 'A list of examples',
    ];

    public function fields()
    {
        return [
            'list' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Example'))),
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

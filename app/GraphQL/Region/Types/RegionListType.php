<?php
namespace App\GraphQL\Region\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class RegionListType extends GraphQLType
{

    protected $attributes = [
        'name' => 'RegionList',
        'description' => 'A list of regions',
    ];

    public function fields()
    {
        return [
            'list' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Region'))),
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

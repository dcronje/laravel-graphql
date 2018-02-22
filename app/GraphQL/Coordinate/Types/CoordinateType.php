<?php
namespace App\GraphQL\Coordinate\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CoordinateType extends GraphQLType
{

    protected $attributes = [
        'name' => 'Coordinate',
        'description' => 'A set of coordinates',
    ];

    public function fields()
    {
        return [
            'longitude' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'The longitude of the coordinates',
            ],
            'latitude' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'The latitude of the coordinates',
            ],
        ];
    }

}

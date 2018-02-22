<?php
namespace App\GraphQL\Location\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class LocationAddInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'LocationAddInput',
        'description' => 'Add input for location',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The locations name',
            ],
            'longitude' => [
                'type' => Type::float(),
                'description' => 'The locations longitude',
            ],
            'latitude' => [
                'type' => Type::float(),
                'description' => 'The locations latitude',
            ],
            'streetAddress' => [
                'type' => Type::string(),
                'description' => 'The locations street address',
            ],
            'building' => [
                'type' => Type::string(),
                'description' => 'The locations building',
            ],
        ];
    }

}

<?php
namespace App\GraphQL\City\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class CityAddInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CityAddInput',
        'description' => 'Add input for city',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The cities name',
            ],
        ];
    }

}

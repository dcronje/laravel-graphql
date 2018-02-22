<?php
namespace App\GraphQL\City\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class CityUpdateInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CityUpdateInput',
        'description' => 'Update input for city',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The cities name',
            ],
        ];
    }

}

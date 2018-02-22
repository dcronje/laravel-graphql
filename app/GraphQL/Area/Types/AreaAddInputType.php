<?php
namespace App\GraphQL\Area\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class AreaAddInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'AreaAddInput',
        'description' => 'Add input for area',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The areas name',
            ],
        ];
    }

}

<?php
namespace App\GraphQL\Area\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class AreaUpdateInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'AreaUpdateInput',
        'description' => 'Update input for area',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The areas name',
            ],
        ];
    }

}

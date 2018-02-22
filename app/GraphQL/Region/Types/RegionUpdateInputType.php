<?php
namespace App\GraphQL\Region\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class RegionUpdateInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'RegionUpdateInput',
        'description' => 'Update input for region',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The regions name',
            ],
        ];
    }

}

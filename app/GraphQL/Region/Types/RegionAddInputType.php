<?php
namespace App\GraphQL\Region\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class RegionAddInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'RegionAddInput',
        'description' => 'Add input for region',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The regions name',
            ],
            'countryId' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The regions country id',
            ],
        ];
    }

}

<?php
namespace App\GraphQL\Country\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class CountryAddInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CountryAddInput',
        'description' => 'Add input for country',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The countries name',
            ],
        ];
    }

}

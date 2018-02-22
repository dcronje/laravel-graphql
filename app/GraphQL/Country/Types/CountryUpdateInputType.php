<?php
namespace App\GraphQL\Country\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class CountryUpdateInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CountryUpdateInput',
        'description' => 'Update input for country',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The countries name',
            ],
        ];
    }

}

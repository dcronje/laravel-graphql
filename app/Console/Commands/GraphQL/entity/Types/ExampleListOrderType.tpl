<?php
namespace App\GraphQL\Example\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class ExampleListOrderType extends GraphQLType
{

    protected $attributes = [
        'name' => 'ExampleListOrder',
        'description' => 'Filters for example list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'field' => [
                'type' => GraphQL::type('ExampleListOrderEnum'),
                'description' => 'The field to order by',
            ],
            'direction' => [
                'type' => GraphQL::type('ExampleListDirectionEnum'),
                'description' => 'The direction to order',
            ],
        ];
    }

}

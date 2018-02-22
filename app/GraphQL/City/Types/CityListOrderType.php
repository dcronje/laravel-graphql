<?php
namespace App\GraphQL\City\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CityListOrderType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CityListOrder',
        'description' => 'Filters for city list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'field' => [
                'type' => GraphQL::type('CityListOrderEnum'),
                'description' => 'The field to order by',
            ],
            'direction' => [
                'type' => GraphQL::type('CityListDirectionEnum'),
                'description' => 'The direction to order',
            ],
        ];
    }

}

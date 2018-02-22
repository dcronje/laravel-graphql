<?php
namespace App\GraphQL\Location\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class LocationListOrderType extends GraphQLType
{

    protected $attributes = [
        'name' => 'LocationListOrder',
        'description' => 'Filters for location list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'field' => [
                'type' => GraphQL::type('LocationListOrderEnum'),
                'description' => 'The field to order by',
            ],
            'direction' => [
                'type' => GraphQL::type('LocationListDirectionEnum'),
                'description' => 'The direction to order',
            ],
        ];
    }

}

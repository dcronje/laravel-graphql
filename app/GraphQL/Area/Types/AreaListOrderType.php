<?php
namespace App\GraphQL\Area\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class AreaListOrderType extends GraphQLType
{

    protected $attributes = [
        'name' => 'AreaListOrder',
        'description' => 'Filters for area list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'field' => [
                'type' => GraphQL::type('AreaListOrderEnum'),
                'description' => 'The field to order by',
            ],
            'direction' => [
                'type' => GraphQL::type('AreaListDirectionEnum'),
                'description' => 'The direction to order',
            ],
        ];
    }

}

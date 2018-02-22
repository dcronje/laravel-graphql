<?php
namespace App\GraphQL\Region\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class RegionListOrderType extends GraphQLType
{

    protected $attributes = [
        'name' => 'RegionListOrder',
        'description' => 'Filters for region list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'field' => [
                'type' => GraphQL::type('RegionListOrderEnum'),
                'description' => 'The field to order by',
            ],
            'direction' => [
                'type' => GraphQL::type('RegionListDirectionEnum'),
                'description' => 'The direction to order',
            ],
        ];
    }

}

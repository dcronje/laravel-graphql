<?php
namespace App\GraphQL\Country\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CountryListOrderType extends GraphQLType
{

    protected $attributes = [
        'name' => 'CountryListOrder',
        'description' => 'Filters for country list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'field' => [
                'type' => GraphQL::type('CountryListOrderEnum'),
                'description' => 'The field to order by',
            ],
            'direction' => [
                'type' => GraphQL::type('CountryListDirectionEnum'),
                'description' => 'The direction to order',
            ],
        ];
    }

}

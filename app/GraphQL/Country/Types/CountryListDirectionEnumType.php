<?php
namespace App\GraphQL\Country\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;

class CountryListDirectionEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'CountryListDirectionEnum',
        'description' => 'Order direction for a list',
    ];

    public function values()
    {
        return [
            'ASC' => [
                'value' => 'ASC',
                'description' => 'Order countries ascending',
            ],
            'DESC' => [
                'value' => 'DESC',
                'description' => 'Order countries desending',
            ],
        ];
    }

}

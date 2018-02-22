<?php
namespace App\GraphQL\City\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;

class CityListDirectionEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'CityListDirectionEnum',
        'description' => 'Order direction for a list',
    ];

    public function values()
    {
        return [
            'ASC' => [
                'value' => 'ASC',
                'description' => 'Order cities ascending',
            ],
            'DESC' => [
                'value' => 'DESC',
                'description' => 'Order cities desending',
            ],
        ];
    }

}

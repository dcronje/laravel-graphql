<?php
namespace App\GraphQL\City\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;
use Excpetion;

class CityListOrderEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'CityListOrderEnum',
        'description' => 'Possible city filters'
    ];

    public function values()
    {
        return [
            'NAME' => [
                'value' => 'name',
                'description' => 'The name of the city',
            ],
            'CREATED_AT' => [
                'value' => 'createdAt',
                'description' => 'The creation time of the city',
            ],
            'UPDATED_AT' => [
                'value' => 'updatedAt',
                'description' => 'The update time of the city',
            ],
        ];
    }

}

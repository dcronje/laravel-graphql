<?php
namespace App\GraphQL\Location\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;

class LocationListOrderEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'LocationListOrderEnum',
        'description' => 'Possible location filters'
    ];

    public function values()
    {
        return [
            'NAME' => [
                'value' => 'name',
                'description' => 'The name of the location',
            ],
            'COUNTRY' => [
                'value' => 'name',
                'description' => 'The country of the location',
            ],
            'REGION' => [
                'value' => 'name',
                'description' => 'The region of the location',
            ],
            'CITY' => [
                'value' => 'name',
                'description' => 'The city of the location',
            ],
            'AREA' => [
                'value' => 'name',
                'description' => 'The area of the location',
            ],
            'CREATED_AT' => [
                'value' => 'name',
                'description' => 'The creation time of the location',
            ],
            'UPDATED_AT' => [
                'value' => 'name',
                'description' => 'The update time of the location',
            ],
        ];
    }

}

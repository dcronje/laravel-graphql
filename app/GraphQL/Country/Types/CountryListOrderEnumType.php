<?php
namespace App\GraphQL\Country\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;
use Excpetion;

class CountryListOrderEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'CountryListOrderEnum',
        'description' => 'Possible country filters'
    ];

    public function values()
    {
        return [
            'NAME' => [
                'value' => 'name',
                'description' => 'The name of the country',
            ],
            'CREATED_AT' => [
                'value' => 'createdAt',
                'description' => 'The creation time of the country',
            ],
            'UPDATED_AT' => [
                'value' => 'updatedAt',
                'description' => 'The update time of the country',
            ],
        ];
    }

}

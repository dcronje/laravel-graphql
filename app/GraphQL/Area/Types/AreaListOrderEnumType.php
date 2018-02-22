<?php
namespace App\GraphQL\Area\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;
use Excpetion;

class AreaListOrderEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'AreaListOrderEnum',
        'description' => 'Possible area filters'
    ];

    public function values()
    {
        return [
            'NAME' => [
                'value' => 'name',
                'description' => 'The name of the area',
            ],
            'CREATED_AT' => [
                'value' => 'createdAt',
                'description' => 'The creation time of the area',
            ],
            'UPDATED_AT' => [
                'value' => 'updatedAt',
                'description' => 'The update time of the area',
            ],
        ];
    }

}

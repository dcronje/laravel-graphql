<?php
namespace App\GraphQL\Region\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;
use Excpetion;

class RegionListOrderEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'RegionListOrderEnum',
        'description' => 'Possible region filters'
    ];

    public function values()
    {
        return [
            'NAME' => [
                'value' => 'name',
                'description' => 'The name of the region',
            ],
            'CREATED_AT' => [
                'value' => 'createdAt',
                'description' => 'The creation time of the region',
            ],
            'UPDATED_AT' => [
                'value' => 'updatedAt',
                'description' => 'The update time of the region',
            ],
        ];
    }

}

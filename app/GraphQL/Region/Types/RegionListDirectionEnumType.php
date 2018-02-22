<?php
namespace App\GraphQL\Region\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;

class RegionListDirectionEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'RegionListDirectionEnum',
        'description' => 'Order direction for a list',
    ];

    public function values()
    {
        return [
            'ASC' => [
                'value' => 'ASC',
                'description' => 'Order regions ascending',
            ],
            'DESC' => [
                'value' => 'DESC',
                'description' => 'Order regions desending',
            ],
        ];
    }

}

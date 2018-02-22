<?php
namespace App\GraphQL\Area\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;

class AreaListDirectionEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'AreaListDirectionEnum',
        'description' => 'Order direction for a list',
    ];

    public function values()
    {
        return [
            'ASC' => [
                'value' => 'ASC',
                'description' => 'Order areas ascending',
            ],
            'DESC' => [
                'value' => 'DESC',
                'description' => 'Order areas desending',
            ],
        ];
    }

}

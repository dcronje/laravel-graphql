<?php
namespace App\GraphQL\Location\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;

class LocationListDirectionEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'LocationListDirectionEnum',
        'description' => 'Order direction for a list',
    ];

    public function values()
    {
        return [
            'ASC' => [
                'value' => 'ASC',
                'description' => 'Order locations ascending',
            ],
            'DESC' => [
                'value' => 'DESC',
                'description' => 'Order locations desending',
            ],
        ];
    }

}

<?php
namespace App\GraphQL\Common;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;

class ListDirectionEnumType extends BaseEnumType
{
  
    protected $attributes = [
        'name' => 'ListDirectionEnum',
        'description' => 'Order direction for a list',
    ];

    public function values()
    {
        return [
            'ASC' => [
                'value' => 'ASC',
                'description' => 'Order ascending',
            ],
            'DESC' => [
                'value' => 'DESC',
                'description' => 'Order desending',
            ],
        ];
    }

}

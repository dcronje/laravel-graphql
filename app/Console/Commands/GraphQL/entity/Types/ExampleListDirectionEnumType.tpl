<?php
namespace App\GraphQL\Example\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;

class ExampleListDirectionEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'ExampleListDirectionEnum',
        'description' => 'Order direction for a list',
    ];

    public function values()
    {
        return [
            'ASC' => [
                'value' => 'ASC',
                'description' => 'Order examples ascending',
            ],
            'DESC' => [
                'value' => 'DESC',
                'description' => 'Order examples desending',
            ],
        ];
    }

}

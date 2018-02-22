<?php
namespace App\GraphQL\Example\Types;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\EnumType as BaseEnumType;
use Excpetion;

class ExampleListOrderEnumType extends BaseEnumType
{

    protected $attributes = [
        'name' => 'ExampleListOrderEnum',
        'description' => 'Possible example filters'
    ];

    public function values()
    {
        //Remove after configuration
        throw new \Exception("ExampleListOrderEnumType not configured! - Edit file at: /app/GraphQL/Example/Types/ExampleListOrderEnumType.php", 500);
        return [
            'NAME' => [
                'value' => 'name',
                'description' => 'The name of the example',
            ],
            'CREATED_AT' => [
                'value' => 'createdAt',
                'description' => 'The creation time of the example',
            ],
            'UPDATED_AT' => [
                'value' => 'updatedAt',
                'description' => 'The update time of the example',
            ],
        ];
    }

}

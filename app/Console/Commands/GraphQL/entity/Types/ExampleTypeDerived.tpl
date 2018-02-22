<?php
namespace App\GraphQL\Example\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class ExampleType extends GraphQLType
{

    protected $attributes = [
        'name' => 'Example',
        'description' => 'A example',
    ];

    public function fields()
    {
        //Remove after configuration
        throw new \Exception("ExampleType not configured! - Edit file at: /app/GraphQL/Example/Types/ExampleType.php", 500);
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the example',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the example',
            ],
        ];
    }

}

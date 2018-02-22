<?php
namespace App\GraphQL\Example\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class ExampleAddInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'ExampleAddInput',
        'description' => 'Add input for example',
    ];

    protected $inputObject = true;

    public function fields()
    {
        //Remove after configuration
        throw new \Exception("ExampleAddInputType not configured! - Edit file at: /app/GraphQL/Example/Types/ExampleAddInputType.php", 500);
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The examples name',
            ],
        ];
    }

}

<?php
namespace App\GraphQL\Example\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class ExampleUpdateInputType extends GraphQLType
{

    protected $attributes = [
        'name' => 'ExampleUpdateInput',
        'description' => 'Update input for example',
    ];

    protected $inputObject = true;

    public function fields()
    {
        //Remove after configuration
        throw new \Exception("ExampleUpdateInputType not configured! - Edit file at: /app/GraphQL/Example/Types/ExampleUpdateInputType.php", 500);
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The examples name',
            ],
        ];
    }

}

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
            'createdAt' => [
                'type' => Type::string(),
                'description' => 'The creation time of the example',
            ],
            'updatedAt' => [
                'type' => Type::string(),
                'description' => 'The update time of the example',
            ],
        ];
    }

    protected function resolveCreatedAtField($root, $args)
    {
        if (is_string($root['created_at'])) {
          return $root['created_at'];
        }
        return $root['created_at']->format('Y-m-d H:m:s');
    }

    protected function resolveUpdatedAtField($root, $args)
    {
        if (is_string($root['updated_at'])) {
          return $root['updated_at'];
        }
        return $root['updated_at']->format('Y-m-d H:m:s');
    }

}

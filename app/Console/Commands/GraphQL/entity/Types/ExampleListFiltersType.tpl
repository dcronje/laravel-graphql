<?php
namespace App\GraphQL\Example\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class ExampleListFiltersType extends GraphQLType
{

    protected $attributes = [
        'name' => 'ExampleListFilters',
        'description' => 'Filters for example list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        //Remove after configuration
        throw new \Exception("ExampleListFiltersType not configured! - Edit file at: /app/GraphQL/Example/Types/ExampleListFiltersType.php", 500);
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The examples name',
            ],
            'minCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The examples minimum creation time',
            ],
            'maxCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The examples maximum creation time',
            ],
            'minUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The examples minimum update time',
            ],
            'maxUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The examples maximum update time',
            ],
        ];
    }

}

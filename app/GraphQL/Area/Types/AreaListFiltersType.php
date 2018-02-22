<?php
namespace App\GraphQL\Area\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class AreaListFiltersType extends GraphQLType
{

    protected $attributes = [
        'name' => 'AreaListFilters',
        'description' => 'Filters for area list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The areas name',
            ],
            'minCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The areas minimum creation time',
            ],
            'maxCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The areas maximum creation time',
            ],
            'minUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The areas minimum update time',
            ],
            'maxUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The areas maximum update time',
            ],
        ];
    }

}

<?php
namespace App\GraphQL\Region\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use Exception;

class RegionListFiltersType extends GraphQLType
{

    protected $attributes = [
        'name' => 'RegionListFilters',
        'description' => 'Filters for region list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The regions name',
            ],
            'minCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The regions minimum creation time',
            ],
            'maxCreatedAt' => [
                'type' => Type::string(),
                'description' => 'The regions maximum creation time',
            ],
            'minUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The regions minimum update time',
            ],
            'maxUpdatedAt' => [
                'type' => Type::string(),
                'description' => 'The regions maximum update time',
            ],
        ];
    }

}

<?php
namespace App\GraphQL\Location\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class LocationListFiltersType extends GraphQLType
{

    protected $attributes = [
        'name' => 'LocationListFilters',
        'description' => 'Filters for location list',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::string(),
                'description' => 'The items',
            ],
            'countries' => [
                'type' => Type::listOf(Type::id()),
                'description' => 'Filter by a list of countries',
            ],
            'regions' => [
                'type' => Type::listOf(Type::id()),
                'description' => 'Filter by a list of regions',
            ],
            'cities' => [
                'type' => Type::listOf(Type::id()),
                'description' => 'Filter by a list of cities',
            ],
            'areas' => [
                'type' => Type::listOf(Type::id()),
                'description' => 'Filter by a list of areas',
            ],
            'minCreatedAt' => [
              'type' => Type::string(),
              'description' => 'Filter by minimum creation date',
            ],
            'maxCreatedAt' => [
              'type' => Type::string(),
              'description' => 'Filter by maximum creation date',
            ],
            'minUpdatedAt' => [
              'type' => Type::string(),
              'description' => 'Filter by minimum update date',
            ],
            'maxUpdatedAt' => [
              'type' => Type::string(),
              'description' => 'Filter by maximum update date',
            ],
        ];
    }

}

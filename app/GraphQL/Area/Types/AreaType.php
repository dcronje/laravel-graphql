<?php
namespace App\GraphQL\Area\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\GraphQL\Location\LocationHelper;
use Exception;

class AreaType extends GraphQLType
{

    protected $attributes = [
        'name' => 'Area',
        'description' => 'A area',
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the area',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the area',
            ],
            'allLocations' => LocationHelper::allLocationsField(),
            'oneLocation' => LocationHelper::oneLocationField(),
            'locationCount' => LocationHelper::locationCountField(),
            'createdAt' => [
                'type' => Type::string(),
                'description' => 'The creation time of the area',
            ],
            'updatedAt' => [
                'type' => Type::string(),
                'description' => 'The update time of the area',
            ],
        ];
    }

    protected function resolveAllLocationsField($root, $args)
    {
        return LocationHelper::allLocationsResolver($root, $args, ['areaId', '=', $root['id']]);
    }

    protected function resolveOneLocationField($root, $args)
    {
        return LocationHelper::oneLocationResolver($root, $args, ['areaId', '=', $root['id']]);
    }

    protected function resolveLocationCountField($root, $args)
    {
        return LocationHelper::locationCountResolver($root, $args, ['areaId', '=', $root['id']]);
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

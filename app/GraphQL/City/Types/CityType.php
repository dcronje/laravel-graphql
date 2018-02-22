<?php
namespace App\GraphQL\City\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\GraphQL\Area\AreaHelper;
use Exception;

class CityType extends GraphQLType
{

    protected $attributes = [
        'name' => 'City',
        'description' => 'A city',
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the city',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the city',
            ],
            'allAreas' => AreaHelper::allAreasField(),
            'oneArea' => AreaHelper::oneAreaField(),
            'areaCount' => AreaHelper::areaCountField(),
            'createdAt' => [
                'type' => Type::string(),
                'description' => 'The creation time of the city',
            ],
            'updatedAt' => [
                'type' => Type::string(),
                'description' => 'The update time of the city',
            ],
        ];
    }

    protected function resolveAllAreasField($root, $args)
    {
        return AreaHelper::allAreasResolver($root, $args, ['cityId', '=', $root['id']]);
    }

    protected function resolveOneAreaField($root, $args)
    {
        return AreaHelper::oneAreaResolver($root, $args, ['cityId', '=', $root['id']]);
    }

    protected function resolveAreaCountField($root, $args)
    {
        return AreaHelper::areaCountResolver($root, $args, ['cityId', '=', $root['id']]);
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

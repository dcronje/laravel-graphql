<?php
namespace App\GraphQL\Region\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\GraphQL\City\CityHelper;
use Exception;

class RegionType extends GraphQLType
{

    protected $attributes = [
        'name' => 'Region',
        'description' => 'A region',
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the region',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the region',
            ],
            'allCities' => CityHelper::allCitiesField(),
            'oneCity' => CityHelper::oneCityField(),
            'cityCount' => CityHelper::cityCountField(),
            'createdAt' => [
                'type' => Type::string(),
                'description' => 'The creation time of the region',
            ],
            'updatedAt' => [
                'type' => Type::string(),
                'description' => 'The update time of the region',
            ],
        ];
    }

    protected function resolveAllCitiesField($root, $args)
    {
        return CityHelper::allCitiesResolver($root, $args, ['regionId', '=', $root['id']]);
    }

    protected function resolveOneCityField($root, $args)
    {
        return CityHelper::oneCityResolver($root, $args, ['regionId', '=', $root['id']]);
    }

    protected function resolveCityCountField($root, $args)
    {
        return CityHelper::cityCountResolver($root, $args, ['regionId', '=', $root['id']]);
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

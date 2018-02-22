<?php
namespace App\GraphQL\Country\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\GraphQL\Region\RegionHelper;
use Exception;

class CountryType extends GraphQLType
{

    protected $attributes = [
        'name' => 'Country',
        'description' => 'A country',
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the country',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the country',
            ],
            'allRegions' => RegionHelper::allRegionsField(),
            'oneRegion' => RegionHelper::oneRegionField(),
            'regionCount' => RegionHelper::regionCountField(),
            'createdAt' => [
                'type' => Type::string(),
                'description' => 'The creation time of the country',
            ],
            'updatedAt' => [
                'type' => Type::string(),
                'description' => 'The update time of the country',
            ],
        ];
    }

    protected function resolveAllRegionsField($root, $args)
    {
        return RegionHelper::allRegionsResolver($root, $args, ['countryId', '=', $root['id']]);
    }

    protected function resolveOneRegionField($root, $args)
    {
        return RegionHelper::oneRegionResolver($root, $args, ['countryId', '=', $root['id']]);
    }

    protected function resolveRegionCountField($root, $args)
    {
        return RegionHelper::regionCountResolver($root, $args, ['countryId', '=', $root['id']]);
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

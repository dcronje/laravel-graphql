<?php
namespace App\GraphQL\Location\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Area;
use App\City;
use App\Region;
use App\Country;

class LocationType extends GraphQLType
{

    protected $attributes = [
        'name' => 'Location',
        'description' => 'A location',
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
            'coordinates' => [
                'type' => GraphQL::type('Coordinate'),
                'description' => 'The coordinates of the location',
            ],
            'building' => [
                'type' => Type::string(),
                'description' => 'The building description of the location',
            ],
            'address' => [
                'type' => Type::string(),
                'description' => 'The address of the location',
            ],
            'area' => [
                'type' => GraphQL::type('Area'),
                'description' => 'The locations area',
            ],
            'city' => [
                'type' => GraphQL::type('City'),
                'description' => 'The locations city',
            ],
            'region' => [
                'type' => GraphQL::type('Region'),
                'description' => 'The locations region',
            ],
            'country' => [
                'type' => GraphQL::type('Country'),
                'description' => 'The locations country',
            ],
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

    public function resolveAreaField($root, $args)
    {
        return Area::where('id', '=', $root['areaId'])->first();
    }

    public function resolveCityField($root, $args)
    {
        return City::where('id', '=', $root['cityId'])->first();
    }

    public function resolveRegionField($root, $args)
    {
        return Region::where('id', '=', $root['regionId'])->first();
    }

    public function resolveCountryField($root, $args)
    {
        return Country::where('id', '=', $root['countryId'])->first();
    }

    public function resolveCoordinatesField($root, $args)
    {
        return [
            'latitude' => $root['latitude'],
            'longitude' => $root['longitude'],
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

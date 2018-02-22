<?php
namespace App\GraphQL\Location\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Location;
use App\Lib\GoogleGeo;
use App\Lib\Locations;
use Exception;

class AddLocationMutation extends Mutation
{

    protected $attributes = [
        'name' => 'addLocation',
    ];

    public function type()
    {
        return GraphQL::type('Location');
    }

    public function args()
    {
        return [
            'input' => ['name' => 'input', 'type' => Type::nonNull(GraphQL::type('LocationAddInput'))],
        ];
    }

    public function rules()
    {
        return [
            'input' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $geo = new GoogleGeo();
        $geoData = false;
        if (isset($args['input']['longitude']) && !empty($args['input']['longitude']) && isset($args['input']['latitude']) && !empty($args['input']['latitude'])) {
            $geoData = $geo->geocode($args['input']['latitude'], $args['input']['longitude'], false);
        } else if ($args['input']['streetAddress']) {
            $geoData = $geo->reverseGeocode($args['input']['streetAddress'], false);
        } else {
          throw new Exception('Either longitude and latitude or streetAdress and building are required', 400);
        }
        $geoData->{'name'} = $args['input']['name'];
        $geoData->{'building'} = $args['input']['building'];
        $location = Location::where('name', 'LIKE', $args['input']['name'])
            ->where('building', 'LIKE', $args['input']['building'])
            ->where('longitude', '=', $geoData->center->longitude)
            ->where('latitude', '=', $geoData->center->latitude)
            ->first();
        if ($location) {
          return $location;
        }
        $location = Locations::process($geoData);
        return $location;
    }

}

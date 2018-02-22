<?php
namespace App\GraphQL\Location\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Location;
use App\Lib\GoogleGeo;
use App\Lib\Locations;
use Exception;

class UpdateLocationMutation extends Mutation
{

    protected $attributes = [
        'name' => 'updateLocation',
    ];

    public function type()
    {
        return GraphQL::type('Location');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::id())],
            'input' => ['name' => 'input', 'type' => Type::nonNull(Graphql::type('LocationUpdateInput'))],
        ];
    }

    public function rules()
    {
        return [
            'id' => ['required'],
            'input' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $location = Location::where('id', '=', $args['id'])->first();
        if (!$location) {
            throw new Exception('Location with id: '.$args['id'].' not found!', 404);
        }
        $geo = new GoogleGeo();
        $geoData = false;
        $shouldGeocode = false;
        if (isset($args['input']['longitude']) && !empty($args['input']['longitude']) && isset($args['input']['latitude']) && !empty($args['input']['latitude'])) {
            $geoData = $geo->geocode($args['input']['latitude'], $args['input']['longitude'], false);
            $shouldGeocode = true;
        } else if (isset($args['input']['streetAddress'])) {
            $geoData = $geo->reverseGeocode($args['input']['streetAddress'], false);
            $shouldGeocode = true;
        }
        if ($shouldGeocode) {
            $locationData = Locations::process($geoData, false);
            if (isset($args['input']['name'])) {
                $locationData->{'name'} = $args['input']['name'];
            }
            if (isset($args['input']['building'])) {
                $locationData->{'building'} = $args['input']['building'];
            }
            $location->update($locationData);
        } else {
          $location->update($args['input']);
        }
        $location->save();
        return $location;
    }

}

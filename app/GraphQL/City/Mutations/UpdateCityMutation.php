<?php
namespace App\GraphQL\City\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\City;
use App\Lib\GoogleGeo;
use App\Lib\Cities;
use Exception;

class UpdateCityMutation extends Mutation
{

    protected $attributes = [
        'name' => 'updateCity',
    ];

    public function type()
    {
        return GraphQL::type('City');
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::id())],
            'input' => ['name' => 'input', 'type' => Type::nonNull(Graphql::type('CityUpdateInput'))],
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
        $city = City::where('id', '=', $args['id'])->first();
        if (!$city) {
            throw new Exception('City with id: '.$args['id'].' not found!', 404);
        }
        $city->update($args['input']);
        $city->save();
        return $city;
    }

}

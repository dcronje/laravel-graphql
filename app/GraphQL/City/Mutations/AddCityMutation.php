<?php
namespace App\GraphQL\City\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\City;
use App\Lib\GoogleGeo;
use App\Lib\Cities;
use Exception;

class AddCityMutation extends Mutation
{

    protected $attributes = [
        'name' => 'addCity',
    ];

    public function type()
    {
        return GraphQL::type('City');
    }

    public function args()
    {
        return [
            'input' => ['name' => 'input', 'type' => Type::nonNull(GraphQL::type('CityAddInput'))],
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
        $city = new City($args['input']);
        $city->save();
        return $exmaple;
    }

}

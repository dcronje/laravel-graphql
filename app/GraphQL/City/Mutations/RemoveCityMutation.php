<?php
namespace App\GraphQL\City\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\City;
use Exception;

class RemoveCityMutation extends Mutation
{

    protected $attributes = [
        'name' => 'removeCity',
    ];

    public function type()
    {
        return Type::id();
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::id())],
        ];
    }

    public function rules()
    {
        return [
            'id' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $city = City::where('id', '=', $args['id'])->first();
        if (!$city) {
          throw new Exception('City with id: '.$args['id'].' not found!', 404);
        }
        $city->delete();
        return $args['id'];
    }

}

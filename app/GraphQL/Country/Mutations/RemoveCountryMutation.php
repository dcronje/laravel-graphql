<?php
namespace App\GraphQL\Country\Mutations;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Country;
use Exception;

class RemoveCountryMutation extends Mutation
{

    protected $attributes = [
        'name' => 'removeCountry',
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
        $country = Country::where('id', '=', $args['id'])->first();
        if (!$country) {
          throw new Exception('Country with id: '.$args['id'].' not found!', 404);
        }
        $country->delete();
        return $args['id'];
    }

}
